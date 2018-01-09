<?php
namespace Base\Controller;

use Base\Controller\AppController;
use Adldap\Adldap;
use Adldap\Classes\Utilities;
use Adldap\Exceptions\AdldapException;
use Adldap\Exceptions\PasswordPolicyException;
use Adldap\Exceptions\WrongPasswordException;
use Adldap\Models\Traits\HasDescriptionTrait;
use Adldap\Models\Traits\HasLastLogonAndLogOffTrait;
use Adldap\Models\Traits\HasMemberOfTrait;
use Adldap\Objects\AccountControl;
use Adldap\Objects\BatchModification;
use Adldap\Schemas\ActiveDirectory;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;



/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 */
class UsuariosController extends AppController
{

	// ldap/ad status de conta de usuario
	public	$userAccountControl = [
				1 => 	'SCRIPT',
				2 => 	'ACCOUNTDISABLE',
				8 => 	'HOMEDIR_REQUIRED',
				16 =>	'BLOQUEIO',
				32=>	'PASSWD_NOTREQD',
				64=>	'PASSWD_CANT_CHANGE',
				128=>	'ENCRYPTED_TEXT_PWD_ALLOWED',
				256=>	'TEMP_DUPLICATE_ACCOUNT	',
				512=>	'NORMAL_ACCOUNT',
				2048=>	'INTERDOMAIN_TRUST_ACCOUNT',
				4096=>	'WORKSTATION_TRUST_ACCOUNT',
				8192=>	'SERVER_TRUST_ACCOUNT',
				65536=>	'DONT_EXPIRE_PASSWORD',
				131072=>	'MNS_LOGON_ACCOUNT',
				262144=>	'SMARTCARD_REQUIRED',
				524288=>	'TRUSTED_FOR_DELEGATION',
				1048576=>	'NOT_DELEGATED',
				2097152=>	'USE_DES_KEY_ONLY',
				4194304=>	'DONT_REQ_PREAUTH',
				8388608=>	'PASSWORD_EXPIRED',
				16777216=>	'TRUSTED_TO_AUTH_FOR_DELEGATION	',
				67108864=>	'PARTIAL_SECRETS_ACCOUNT'
			];
	
	// ldap status = inativo
	public 	$inactiveStatus = [2];
	
	
	public function ldapUsers(){
	
		
		$this->loadComponent('Base.Parametro');
		
		// armazena a paginacao na sessao 
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorUsuariosLDAP']);
		$this->PaginationSession->restore();
		
		/// Cria os filtros
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro1'=> ['field'=> 'cn', 'operator'=>'='],
				'filtro2'=> ['field'=> 'sAMAccountName', 'operator'=>'='],
				'filtro3'=> ['field'=> 'userAccountControl', 'operator'=>'='],
				
				]
		);
		// processa os filtros aplicados
		$conditions = $this->Filter->getConditions(['session'=>'filterUsuarios']);
		$this->set('url', $this->Filter->getUrl());
		//debug(date('H:i:s'));
		//debug($conditions);
		
		// envia status para a visao
		$this->set('status', $this->userAccountControl);
		$this->set('inactive_status',$this->inactiveStatus);

		/* conecta ao LDAP/AD */
		$ad = $this->Usuarios->connectLDAP($this->Parametro);
		
		if(!$ad){
			$this->Flash->error(__('Não é possível conectar ao LDAP/AD. '.$this->Usuarios->ldapAdError ));
			return;
		}
		
		// determina a paginacao 
		$perPage = isset($this->request->query['limit'])? $this->request->query['limit'] : 15; 
		$currentPage = isset($this->request->query['page'])? $this->request->query['page'] : 0; 
		
		
		// realiza a busca dos dados
		$paginator = 
		$ad
		->users()
		->search()
		->select(array('cn', 'displayname','name', 'sAMAccountName', 'mail','useraccountcontrol'));
		
		if(isset($conditions['cn'])) {
			$names = explode(' ', $conditions['cn']);
			foreach ($names as $n) 
				$paginator = $paginator->whereContains('cn', $n);
		}
		
		if(isset($conditions['sAMAccountName'])) {
			$paginator = $paginator->whereContains('sAMAccountName', $conditions['sAMAccountName']);
		}
		
		if(isset($conditions['userAccountControl'])) {
			$paginator = $paginator->where('userAccountControl:1.2.840.113556.1.4.803:', '=', $conditions['userAccountControl']);
		}
		
		
		// Export CSV
		if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
			$this->loadComponent('Base.Export');
			$data_export =$paginator->sortBy('name', 'asc')->get();
			$callback = function ($object){
				return [$object->getDisplayName(), $object->samaccountname[0], $object->useraccountcontrol[0]];
			};
			$this->Export->CSV('Usuarios_LDAP'.date('d_m_Y_H_i_s').'.csv', $data_export, ['NOME','LOGIN','STATUS'], $callback );
			exit;
		}
		
		$result = $paginator->sortBy('name', 'asc')->paginate($perPage, $currentPage);
		
		$this->set('ldap_users',$result);
		
		$this->PaginationSession->save();
	}
	
	
	public function lookupLdapUsers(){
	
		
		$this->loadComponent('Base.Parametro');
		
		
		// armazena a paginacao na sessao
		$this->loadComponent('Base.PaginationSession', ['session'=>'lookupUsuariosLDAP']);
		$this->PaginationSession->restore();
	
		/// Cria os filtros
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro1'=> ['field'=> 'cn', 'operator'=>'='],
				'filtro2'=> ['field'=> 'sAMAccountName', 'operator'=>'='],
				'filtro3'=> ['field'=> 'userAccountControl', 'operator'=>'='],
				]
		);
		// processa os filtros aplicados
		$conditions = $this->Filter->getConditions(['session'=>'filterUsuariosLDAPLookup']);
		$this->set('url', $this->Filter->getUrl());
		//debug(date('H:i:s'));
		//debug($conditions);
	
		// envia status para a visao
		$this->set('status',$this->userAccountControl);
		$this->set('inactive_status',$this->inactiveStatus);
	
		/* conecta ao LDAP/AD */
		$ad = $this->Usuarios->connectLDAP($this->Parametro);
		
		if(!$ad){
			$this->Flash->error(__('Não é possível conectar ao LDAP/AD. '.$this->Usuarios->ldapAdError ));
			return;
		}
	
	
		// determina a paginacao
		$perPage = isset($this->request->query['limit'])? $this->request->query['limit'] : 5;
		$currentPage = isset($this->request->query['page'])? $this->request->query['page'] : 0;
	
	
		// realiza a busca dos dados
		$paginator =
		$ad
		->users()
		->search()
		->select(array('cn', 'displayname','name', 'sAMAccountName', 'mail','useraccountcontrol'));
	
		if(isset($conditions['cn'])) {
			$names = explode(' ', $conditions['cn']);
			foreach ($names as $n)
				$paginator = $paginator->whereContains('cn', $n);
		}
	
		if(isset($conditions['sAMAccountName'])) {
			$paginator = $paginator->whereContains('sAMAccountName', $conditions['sAMAccountName']);
		}
	
		if(isset($conditions['userAccountControl'])) {
			$paginator = $paginator->where('userAccountControl:1.2.840.113556.1.4.803:', '=', $conditions['userAccountControl']);
		}
	
		$result = $paginator->sortBy('name', 'asc')->paginate($perPage, $currentPage);
	
		//debug($paginator);
	
		$this->set('ldap_users',$result);
	
		$this->PaginationSession->save();
	}
	
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	    	 
    	
        $this->paginate = [
            'contain' => ['Sistemas','Grupos']
        ];
        $sistemas = $this->Usuarios->Sistemas->find('list');
        $this->set('sistemas',$sistemas);
        
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorUsuarios']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro_sistema'=> ['field'=> 'Usuarios.sistema_id', 'operator'=>'='],
				'filtro_nome'=> ['field'=> 'Usuarios.nome', 'operator'=>'ILIKE'],
				'filtro_login'=> ['field'=> 'Usuarios.login', 'operator'=>'ILIKE'],
				'filtro_status'=> ['field'=> 'Usuarios.ativo', 'operator'=>'=']
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterUsuarios']);
    	$this->set('url', $this->Filter->getUrl());
    	
    	$conditions['Usuarios.sistema_id'] = $this->sistema['id'];
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Usuarios->find('all', ['conditions'=> $conditions  ,'contain' => ['Sistemas','Grupos']   ]);
    		$callback = function ($object){
    			$grupos = [];
    			foreach($object->grupos as $grupo){
    				$grupos[] = $grupo->descricao;
    			}
    			return [$object->id, $object->nome, $object->login, $object->ativo ? 'Ativo' : 'Inativo', implode(', ', $grupos) ];
    		};
    		$this->Export->CSV('Usuarios_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['_id','Nome','Login','Status/Sistema','Grupos'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Usuarios.id ASC'];
    		
    	
    	
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('usuarios', $this->paginate($this->Usuarios));
        
         $this->set('paging',$this->request->params['paging']);
        
        $this->set('_serialize', ['usuarios','paging']);
        
        
        
         $this->PaginationSession->save();
    }
    
    
    /**
     * Index method
     *
     * @return void
     */
    public function listar()
    {
    	 
    	 
    	$this->paginate = [
    	'contain' => ['Sistemas','Grupos']
    	];
    	$sistemas = $this->Usuarios->Sistemas->find('list');
    	$this->set('sistemas',$sistemas);
    
    	$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorUsuarios']);
    	$this->PaginationSession->restore();
    
    	$this->loadComponent('Base.Filter');
    	$this->Filter->addFilter([
    			'filtro_sistema'=> ['field'=> 'Usuarios.sistema_id', 'operator'=>'='],
    			'filtro_nome'=> ['field'=> 'Usuarios.nome', 'operator'=>'ILIKE'],
    			'filtro_login'=> ['field'=> 'Usuarios.login', 'operator'=>'ILIKE'],
    			'filtro_status'=> ['field'=> 'Usuarios.ativo', 'operator'=>'=']
    			]);
    	 
    	$conditions = $this->Filter->getConditions(['session'=>'filterUsuarios']);
    	$this->set('url', $this->Filter->getUrl());
    	 
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Usuarios->find('all', ['conditions'=> $conditions  ,'contain' => ['Sistemas']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Usuarios_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	 
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Usuarios.id ASC'];
    
    	//$conditions['Usuarios.sistema_id'] = $this->sistema['id'];
    	 
    	$this->paginate['conditions']	= $conditions;
    	 
    	$this->set('usuarios', $this->paginate($this->Usuarios));
    	$this->set('_serialize', ['usuarios']);
    
    	$this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Usuario id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = 46)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Sistemas', 'Grupos']
        ]);
        
        // controle de escopo
        /*
        if($usuario->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível exibir o usuário [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        $this->set('usuario', $usuario);
        $this->set('_serialize', ['usuario']);
        
        $this->set('status',$this->userAccountControl);
        $this->set('inactive_status',$this->inactiveStatus);
        
        
        $this->loadComponent('Base.Parametro');
        
    	
    	/* conecta ao LDAP/AD */
		$ad = $this->Usuarios->connectLDAP($this->Parametro);
		
		if(!$ad){
			$this->set('ldap_ad_status','LDAP/AD: Não é possivel conectar.');
			$this->set('user_ldap', false);
		}
		else {
        
	        // realiza a busca do usuarios
	        $user =
	        $ad
	        ->users()
	        ->find($usuario->login);
	        
	      	$this->set('user_ldap', $user);
	        
	        if($user) {
		        
	        	$esta_ativo_ldap_ad = true;
		        
				foreach($this->inactiveStatus as $st_inativo) {
		        	if(($user->getUserAccountControl() & $st_inativo)){  // 'se esta contido', apenas um '&' mesmo e não '&&' operador binario
		        		$esta_ativo_ldap_ad = false;
		        		break;
		        	}
				}
				$this->set('ldap_ad_status', ($esta_ativo_ldap_ad ? 'ATIVO' : 'INATIVO'));
	        }
	        else{
	        	$this->set('ldap_ad_status','NÃO ENCONTRADO');
	        }
		}
        
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
        	
        	$this->request->data['sistema_id'] = $this->sistema['id'];
        	
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            
            //debug($usuario);
            //exit;
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $usuario->id]);
            } else {
                $this->Flash->error(__('O usuário não foi salvo. Por favor, tente novamente.'));
            }
        }
        $sistemas = $this->Usuarios->Sistemas->find('list', ['limit' => 200]);
        
        $grupos = $this->Usuarios->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$this->sistema['id'],'Grupos.ativo'=>true]]);
        
        // agrupar os grupos por ativo e inativo 
        $grupos =  $grupos->toArray();
        if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
        if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
   
        unset($grupos[1]);
        unset($grupos[0]);
        
        
        
        $this->set(compact('usuario','sistemas','grupos'));
        $this->set('_serialize', ['usuario']);
    }

    
    public function cadastrar()
    {
    	$usuario = $this->Usuarios->newEntity();
    	if ($this->request->is('post')) {
    		 
    		//$this->request->data['sistema_id'] = $this->sistema['id'];
    		 
    		$usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
    
    		//debug($usuario);
    		//exit;
    		if ($this->Usuarios->save($usuario)) {
    			$this->Flash->success(__('O usuário foi salvo com sucesso.'));
    			return $this->redirect(['action' => 'view', $usuario->id]);
    		} else {
    			$this->Flash->error(__('O usuário não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    	$sistemas = $this->Usuarios->Sistemas->find('list', ['limit' => 200]);
    
    	/*$grupos = $this->Usuarios->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$this->sistema['id'],'Grupos.ativo'=>true]]);
    
    	/* agrupar os grupos por ativo e inativo
    	$grupos =  $grupos->toArray();
    	if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
    	if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
    	 
    	unset($grupos[1]);
    	unset($grupos[0]);
    
    	*/
    
    	$this->set(compact('usuario','sistemas'));
    	$this->set('_serialize', ['usuario']);
    }
    
    
    
    
    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Grupos','Sistemas']
        ]);
        // controle de escopo
        /*
        if($usuario->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o usuário [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	unset($this->request->data['sistema_id']);
            
        	$usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('O usuário foi alterado com sucesso.'));
                return $this->redirect(['action' => 'view', $usuario->id]);
            } else {
                $this->Flash->error(__('O usuario não foi alterado. Por favor, tente novamente.'));
            }
        }
        //$sistemas = $this->Usuarios->Sistemas->find('list', ['limit' => 200]);
        $grupos = $this->Usuarios->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$usuario->sistema_id]]);
        $grupos =  $grupos->toArray();
        
        if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
        if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
         
        unset($grupos[1]);
        unset($grupos[0]);
        
        $this->set(compact('usuario', 'grupos'));
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        
        // controle de escopo
        /*
        if($usuario->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível remover o usuário [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('O usuário foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O usuário não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
    public function login(){
    	
    	
    	
    	if ($this->request->is('post')) {
    		$usuario = strtolower($this->request->data['login']);
    		$senha = $this->request->data['senha'];
    		
    		unset( $this->request->data['senha']);
    		
    		// verifica no LDAP.
    		$this->loadComponent('Base.Parametro');
    		 
    		// conecta ao LDAP/AD 
    		$ad = $this->Usuarios->connectLDAP($this->Parametro);
    		
    		// verifica se o AD está online
    		if(!$ad){
    			//debug($this->Usuarios->ldapAdError);
    			$this->Flash->error(__('Serviço de Autenticação temporariamente indisponível. Tente novamente mais tarde.'));
    			return;
    		}
    		
    		// tenta conectar no AD com as credenciais informadas
    		if(!$ad->authenticate($usuario, $senha)){
    			$this->set('erro', true);
    			$this->Flash->error(__('Erro de login/senha.'));
    			sleep(1);
    			return;
    		}
    		
    		$userLDAP = $ad->users()->find($usuario);
    		
    		$login_ad =  [	
    						'nome'=> $userLDAP->getDisplayName(),
    						'login'=> $usuario,
    					];
    		
    		//$this->Flash->success(__('Seja bem-vindo, '.$userLDAP->getDisplayName()));
    		$this->request->session()->write('login', $login_ad);
    		
    		return $this->redirect(['action' => 'escolher']);
    		
    		
    	}
    	
    	
    }
    
    public function logout(){
    	$this->request->session()->destroy();
    	return $this->redirect(['action' => 'login']);
    }
    
    public function escolher($sistema_id=null){
    	 
    	
    	// Busca os Sistemas que o usuário tem permissão e tbm os os Sistemas que possuam acoes publicas (ou seja, qualquer um pode entrar sem estar cadastrado)
    	$usuarios = $this->Usuarios->find()->contain(
    			['Sistemas'=> function ($q) {
			        return $q->where(['Sistemas.ativo' => true]);
			    }
	    		,
	    		'Grupos'=> function ($q) {
				        return $q->where(['Grupos.ativo' => true, 'Grupos.is_public'=>false]);
				    }
				]
		
		)->where(['Usuarios.login' => $this->login['login'], 'Usuarios.ativo' =>true]);
    	 

		// pega os grupos publicos de sistemas ativos // qquer um pode entrar nesse sistema
		$grupos_publicos = 	$this->Usuarios->Grupos->find()->contain(
	    		['Sistemas'=> function ($q) {
				        return $q->where(['Sistemas.ativo' => true]);
				    }
				]
		)->where(['Grupos.ativo' => true,'Grupos.is_public'=>true]);
	
    	//debug($grupos_publicos); exit;
    	
    	/*foreach($grupos_publicos as $row) {
    		debug($row);
    	}*/
    	//exit;
    	
    	//$sistemas = $this->Sistemas->find('all', ['conditions'=>['']]);
    	$this->set('usuarios',$usuarios);
    	$this->set('grupos_publicos', $grupos_publicos);
    	
    	$redir_home = "/";
    	
    	if($sistema_id){
    		
    		// Verifica se o usuario tem permissao para o sistema escolhido
    		$has = false;
    		foreach ($usuarios as $row) {
    			// 
    			
    			if($row->sistema_id == $sistema_id){
    				
    				$grupos = [];
    				foreach($row->grupos as $grp){
    					$grupos[$grp->id] = $grp->descricao;
    				}
    				$redir_home = $row->sistema->redir_home;
    				//debug($grupos);
    				// grava os grupos na sessao
    				$this->request->session()->write('grupos',$grupos);
					// grava o usuario na sessao
    				//$this->request->session()->write('usuario',['nome'=>$row,'id'=>$row->id, 'is_admin'=>$row->is_admin]);
    				$this->request->session()->write('usuario',$row);
    				// grava o sistema selecionado na sessao
    				$this->request->session()->write('sistema',['nome'=>$row->sistema->nome, 'id'=>$row->sistema->id,'icon'=>$row->sistema->icon]);
    				// grava as permissoes na sessão
    				$permi = $this->getPermission();
    				$this->request->session()->write('permissao', $permi);
    				// grava o menu  na sessão, de acordo com as permissoes
    				$this->request->session()->write('menu', $this->getMenuItem());
    				
    				$has = true; break;
    			}
    		}
    		
    		foreach($grupos_publicos as $row) {
    			if($row->sistema_id == $sistema_id){
    				$grupos[$row->id] = $row->descricao;
    				//debug($grupos);
    				$redir_home = $row->sistema->redir_home;
    				// grava os grupos na sessao
    				//debug($grupos);
    				$this->request->session()->write('grupos',$grupos);
    				// grava o usuario na sessao
    				//$this->request->session()->write('usuario',['nome'=>'non-user','id'=>'', 'is_admin'=>false]);
    				$this->request->session()->write('usuario',$row);
    				// grava o sistema selecionado na sessao
    				$this->request->session()->write('sistema', ['nome'=>$row->sistema->nome, 'id'=>$row->sistema->id,'icon'=>$row->sistema->icon]);
    				// grava as permissoes na sessão
    				$permi = $this->getPermission();
    				$this->request->session()->write('permissao', $permi);
    				// grava o menu  na sessão, de acordo com as permissoes
    				$this->request->session()->write('menu', $this->getMenuItem());
    				
    				$has = true; break;
    			}
    		}
    		//debug($permi); exit;
    		
    		if(!$has){ // se nao tem o sistema, redireciona.
    			$this->Flash->error(__('Permissão negada ao sistema.'));
    			return $this->redirect(['action' => 'logout']);
    		}
    		//debug($redir_home); exit;
    		// redireciona para  a raiz do sistema
    		 return $this->redirect($redir_home);
    	}
    }
    
    // busca as permissoes depois de selecionar o sistema, baseado nos grupos do usuario.
    private function getPermission() {
    	
    	$grupos = $this->request->session()->read('grupos');
    	if(!$grupos) return [];
    	
    	$sistema = $this->request->session()->read('sistema');
    	if(!$sistema) return [];
    	
    	$grupos = $this->Usuarios->Grupos->find()->contain(
    			['Acoes'=> function ($q) use ( $sistema ) {
    				return $q
    						->where(['Acoes.ativo' => true, 'Acoes.tipo'=>'private', 'Acoes.sistema_id'=>$sistema['id'] ]);
    			}    			
    			]
    	
    	)->where(['Grupos.sistema_id' =>$sistema['id'] ,'Grupos.id IN'=> array_keys($grupos), 'Grupos.ativo' =>true]);
    	
    	//debug($grupos);
    	$permissao = [];
    	foreach ($grupos as $grupo) { 
    		//debug($grupo->acoes);
    		foreach($grupo->acoes as $action) {
    			$permissao[strtolower($action->prefix)][strtolower($action->controller)][strtolower($action->action)] = $action->id;
    		}
    	}
    	
    	// Busca as acoes publicas e protegidas
    	$acoes = TableRegistry::get('Base.Acoes');
    	$acoes_publicas = $acoes->find('all', ['conditions'=>['Acoes.sistema_id'=>$sistema['id'],'Acoes.ativo'=>true, 'Acoes.tipo IN'=>['public','protected']]]);
    	foreach($acoes as $action) {
    		$permissao[strtolower($action->prefix)][strtolower($action->controller)][strtolower($action->action)] = $action->id;
    	}
    	return $permissao;
    } 

    private function getMenu(){
    	$grupos = $this->request->session()->read('grupos');
    	if(!$grupos) return "";
    	
    	$sistema = $this->request->session()->read('sistema');
    	if(!$sistema) return "";
    	
    	return $this->getMenuItem();
    }
	// busca recursiva para montar o menu

    private function getMenuItem($nodeId=null){
    	
    	$permissao = $this->request->session()->read('permissao');
    	if(!$permissao) return "";
    	 
    	
    	$sistema = $this->request->session()->read('sistema');
    	if(!$sistema) return "";
    	
    	$menus = TableRegistry::get('Base.Menus');
    	 
    	
    	// Templates para montar os itens de menu:
    	//$templateRoot = '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"><ul class="nav navbar-nav">'."\n{INNER}\n".'</ul></div>'."\n";
    	$templateMenu = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'."\n{NAME}\n".' <span class="caret"></span></a>  <ul class="dropdown-menu">'."\n{INNER}\n".'</ul></li>'."\n";
    	$templateItem = '<li class=""><a href="{URL}">{NAME}</a></li>'."\n";
    	
    	$atual = false;
    	if($nodeId)
    		$atual = $menus->get($nodeId, ['contain'=>['Acoes']]);
    	// busca os itens
    	$conditions = ['Menus.parent_id IS NULL', 'Menus.ativo'=>true, 'Menus.sistema_id'=>$sistema['id']];
    	if($nodeId)
    		$conditions = ['Menus.parent_id'=>$nodeId, 'Menus.ativo'=>true,'Menus.sistema_id'=>$sistema['id']];
    	
    	$filhos = $menus->find('all', ['conditions'=>$conditions, 'order'=>'Menus.lft', ]);
// 		debug($filhos->count());
    	// Escolhe o template: raiz, sub-menu, item de menu
    	$thisTemplateNode = "";
    	if($nodeId){
	    	if($filhos->isEmpty()){
	    		$thisTemplateNode = $templateItem;
	    	}
	    	else {
	    		$thisTemplateNode = $templateMenu;
	    	}
	    	$thisTemplateNode = str_replace('{NAME}', $atual->descricao, $thisTemplateNode);
	    	
	    	$url = "#";
	    	
	    	/* Faz a verificacao do controle de acesso do menu */
	       	if($atual->acao_id){
	       		//debug($atual);
	    		if(!$this->menuHasPermission($atual->acao_id)) return "";
	    		$url = Router::url([ 'plugin'=>($atual->acao->prefix ? $atual->acao->prefix : NULL),'controller'=>$atual->acao->controller, 'action'=> $atual->acao->action]);
	    	}
	    	if($atual->action){
	    		$url = $atual->action;
	    	}
	    	
	    	$thisTemplateNode = str_replace('{URL}', $url, $thisTemplateNode);
	    	
    	}
    	$return="";
    	foreach ($filhos as $menuItem){
    		$return .= $this->getMenuItem($menuItem->id);
    	}
    	if($thisTemplateNode)
    			$return = str_replace('{INNER}', $return, $thisTemplateNode);
    		    	
    	return $return;
    	
    }
    
    private function menuHasPermission($acao_id){
    	$permissao = $this->request->session()->read('permissao');
    	$usuario = $this->request->session()->read('usuario');
    	
    	//if($usuario['is_admin']) return true;
    	
    	if(!$permissao) return false;
    	
    	return in_array_r($acao_id, $permissao);
    }
    public function acessoNegado(){
    	
    	//$this->Flash->error(__('Permissão negada.'));
    }
    


    public function angular(){
    	
    }

    public function angular2(){
    }
    
    public function angular3(){
    }

}
