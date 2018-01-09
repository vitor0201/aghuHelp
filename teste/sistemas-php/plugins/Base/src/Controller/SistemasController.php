<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Sistemas Controller
 *
 * @property \App\Model\Table\SistemasTable $Sistemas
 */
class SistemasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    	
    	
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorSistemas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Sistemas.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterSistemas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Sistemas->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Sistemas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Sistemas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('sistemas', $this->paginate($this->Sistemas));
        $this->set('_serialize', ['sistemas']);
        
         $this->PaginationSession->save();
    }
    

    /**
     * View method
     *
     * @param string|null $id Sistema id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sistema = $this->Sistemas->get($id, [
            'contain' => ['Acoes', 'Ajudas', 'Grupos', 'Menus', 'Parametros', 'Usuarios']
        ]);
        $this->set('sistema', $sistema);
        $this->set('_serialize', ['sistema']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sistema = $this->Sistemas->newEntity();
        if ($this->request->is('post')) {
            $sistema = $this->Sistemas->patchEntity($sistema, $this->request->data);
            if ($this->Sistemas->save($sistema)) {
            	
				// CRIA O GRUPO ADMIN            	
            	$grupo = $this->Sistemas->Grupos->newEntity();
            	$grupo->descricao = 'ADMIN';
            	$grupo->atividade = 'ADMIN';
            	$grupo->sigla = 'ADMIN';
            	$grupo->ativo = true;
            	$grupo->sistema_id = $sistema->id;
            	
            	$this->Sistemas->Grupos->save($grupo);
            	
            	// CRIA O USUARIO 
            	$user = $this->Sistemas->Usuarios->newEntity();
            	$user->login = $this->login['login'];
            	$user->nome = $this->login['nome'];
            	$user->ativo = true;
            	$user->is_admin = false;
            	$user->sistema_id = $sistema->id;
            	$user->grupos = [$grupo];
            	
            	$this->Sistemas->Usuarios->save($user);
            	
            	// CRIA O MENU ADMIN
            	$menu = $this->Sistemas->Menus->newEntity();
            	$menu->descricao = 'Sistema';
            	$menu->parent_id = null;
            	$menu->ativo = true;
            	$menu->acao_id = null;
            	$menu->sistema_id = $sistema->id;
            	$this->Sistemas->Menus->save($menu);
            	
            	// CRIA AS ACOES BASICAS INICIAIS e O MENU
            	
            	$prefix = 'base';
            	$crud = ['Listar'=>'index','Detalhar'=>'view','Cadastrar' =>'add','Alterar'=>'edit','Remover'=>'delete'];
            	$iniciais = [
            			'usuarios'=> 	$crud + ['Logout'=>'logout', 'Buscar AD/LDAP' =>'lookupLdapUsers','Trocar Sistema' =>'escolher'],
            			//'grupos' => 	$crud,
            			//'acoes' => 		$crud,
            			//'menus' => 		$crud + ['Mover acima'=>'moveUp','Mover abaixo'=>'moveDown'],
            			'parametros' => ['Configurar'=>'configurar'],
            			//'sistemas' => $crud,
            			'ajudas' => ['Ajuda'=>'manual']
				];
				 
            	$acao = []; 
            	$i=0; 
            	
            	
            	foreach ($iniciais as $controller => $arr){
            		
            		foreach ($arr as $descricao => $action){
            			$acao[$i] = $this->Sistemas->Acoes->newEntity();
            			$acao[$i]->prefix = $prefix;
            			$acao[$i]->controller = $controller;
            			$acao[$i]->action = $action;
            			$acao[$i]->descricao = "$descricao $controller";
            			$acao[$i]->tipo = "private";
            			$acao[$i]->ativo = true;
            			$acao[$i]->grupos = [$grupo];
            			$acao[$i]->sistema_id = $sistema->id;
            			
            			$this->Sistemas->Acoes->save($acao[$i]);
						if(in_array($action,['index','manual','configurar'])){
							$item_menu = $this->Sistemas->Menus->newEntity();
			            	$item_menu->descricao = $acao[$i]->descricao;
			            	$item_menu->parent_id = $menu->id;
			            	$item_menu->ativo = true;
			            	$item_menu->acao_id = $acao[$i]->id;
			            	$item_menu->sistema_id = $sistema->id;
			            	$this->Sistemas->Menus->save($item_menu);
						}
						$i++;
            		}
            	}
            	
            	
                $this->Flash->success(__('O registro de sistema foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $sistema->id]);
            } else {
                $this->Flash->error(__('O registro de sistema não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('sistema'));
        $this->set('_serialize', ['sistema']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sistema id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sistema = $this->Sistemas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sistema = $this->Sistemas->patchEntity($sistema, $this->request->data);
            if ($this->Sistemas->save($sistema)) {
                $this->Flash->success(__('O registro de sistema foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $sistema->id]);
            } else {
                $this->Flash->error(__('O registro de sistema não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('sistema'));
        $this->set('_serialize', ['sistema']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sistema id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	//debug($this->Sistemas->Grupos);
    	//exit;
    	
        $this->request->allowMethod(['post', 'delete']);
        
        $sistema = $this->Sistemas->get($id);
       
        if ($this->Sistemas->delete($sistema, ['atomic'=>true])) {
            $this->Flash->success(__('O registro de sistema foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de sistema não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
