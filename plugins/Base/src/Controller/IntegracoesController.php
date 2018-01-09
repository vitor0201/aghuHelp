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
use Cake\Datasource\ConnectionManager;



/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 */
class IntegracoesController extends AppController
{
	
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
		$this->set('status',$this->userAccountControl);
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
	
	public function pacientes(){

		// Conexao
		$conn = ConnectionManager::get('aghu');
		
		// Filtro
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro1'=> ['field'=> 'prontuario', 'operator'=>'='],
				'filtro2'=> ['field'=> 'nome', 'operator'=>'ILIKE', 'explode'=>'AND'],
				]
		);
		
		$conditions = $this->Filter->getConditions(['session'=>'filterPacientesAghu']);
		
		//debug($conditions);
		
		// Classe temporaria
		$pacientes = TableRegistry::get('Pacientes', [
						    'table' => 'agh.aip_pacientes',
						    'connection' => $conn,
						]);
		
		$query = $pacientes->find();
		
		$query = $query->where($conditions);
		
		// url para paginacao
		// determina a paginacao
		$perPage = isset($this->request->query['limit'])? $this->request->query['limit'] : 5;
		$currentPage = isset($this->request->query['page'])? $this->request->query['page'] : 1;
		$maxPage = (int) ( $query->count() / $perPage)  ;
		
		$query = $query->limit($perPage)->page($currentPage);
		$url = $this->Filter->getUrl();
		
		
		//debug($perPage);
		//debug($currentPage);
		
		
		$this->set('pacientes', $query);
		$this->set('url', $url);
		$this->set('currentPage', $currentPage);
		$this->set('maxPage', $maxPage);
// 		$result = $query->toArray();	
		
// 		$result = $pacientes->toArray();
		
// 		debug($result);
		
		TableRegistry::clear();
	}
	
	public function medicos(){
		/*
		"
		SELECT pes.codigo, q.nro_reg_conselho, pes.nome, q.tql_codigo, q.situacao
		FROM agh.rap_pessoas_fisicas pes
		INNER JOIN agh.rap_qualificacoes q ON pes.codigo = q.pes_codigo AND
		(q.tql_codigo = 1 OR q.tql_codigo = 3 OR q.tql_codigo = 5) AND
		q.situacao = ''C'' AND
		q.nro_reg_conselho is not null
		";
		*/
		
		// Conexao
		$conn = ConnectionManager::get('aghu');
	
		// Filtro
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro1'=> ['field'=> 'nome', 'operator'=>'ILIKE', 'explode'=>'AND'],
				'filtro2'=> ['field'=> 'nro_reg_conselho', 'operator'=>'ILIKE'],
				]
		);
	
		$conditions = $this->Filter->getConditions(['session'=>'filterMedicosAghu']);
	
		//debug($conditions);
	
		// Classe temporaria
		$medicos = TableRegistry::get('Medicos', [
				'table' => 'agh.rap_pessoas_fisicas',
				'connection' => $conn,
				]);
	
		$query = $medicos->find();
	
		$query = 
		$query->join([
				'table' => 'agh.rap_qualificacoes',
				'alias' => 'q',
				'type' => 'INNER',
				'conditions' => "medicos.codigo = q.pes_codigo AND
								(q.tql_codigo = 1 OR q.tql_codigo = 3 OR q.tql_codigo = 5) AND
								q.situacao = 'C' AND
								q.nro_reg_conselho is not null",
				]);
		
		
		
		$query = $query->where($conditions);
		
		$query = $query->select(['q.nro_reg_conselho','Medicos.nome','Medicos.sexo','Medicos.dt_nascimento','Medicos.cpf']);
		$query = $query->distinct();
	
		// url para paginacao
		// determina a paginacao
		$perPage = isset($this->request->query['limit'])? $this->request->query['limit'] : 5;
		$currentPage = isset($this->request->query['page'])? $this->request->query['page'] : 1;
		$maxPage = (int) ( $query->count() / $perPage)  ;
	
		$query = $query->limit($perPage)->page($currentPage);
		$url = $this->Filter->getUrl();
	
		//debug($perPage);
		//debug($currentPage);
		//debug($maxPage);
	
		$this->set('medicos', $query);
		$this->set('url', $url);
		$this->set('currentPage', $currentPage);
		$this->set('maxPage', $maxPage);
		//$result = $query->toArray();
	
		//$result = $pacientes->toArray();
	
		//debug($result);
	
		TableRegistry::clear();
	}
	
	
	public function procedimentos(){
		// Conexao
		$conn = ConnectionManager::get('aghu');
	
		// Filtro
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro2'=> ['field'=> 'descricao', 'operator'=>'ILIKE', 'explode'=>'AND'],
				'filtro1'=> ['field'=> 'cod_tabela', 'operator'=>'='],
				]
		);
	
		$conditions = $this->Filter->getConditions(['session'=>'filterProcedimentosAghu']);
	
		//debug($conditions);
	
		// Classe temporaria
		$medicos = TableRegistry::get('Procedimentos', [
				'table' => 'agh.fat_itens_proced_hospitalar',
				'connection' => $conn,
				]);
	
		$query = $medicos->find();
	
		$query = $query->where($conditions);
	
		$query = $query->select(['Procedimentos.cod_tabela','Procedimentos.descricao','Procedimentos.sexo','Procedimentos.idade_min', 'Procedimentos.idade_max','Procedimentos.ind_situacao']);
		$query = $query->distinct();
	
		// url para paginacao
		// determina a paginacao
		$perPage = isset($this->request->query['limit'])? $this->request->query['limit'] : 5;
		$currentPage = isset($this->request->query['page'])? $this->request->query['page'] : 1;
		$maxPage = (int) ( $query->count() / $perPage)  ;
	
		$query = $query->limit($perPage)->page($currentPage);
		$url = $this->Filter->getUrl();
	
		//debug($perPage);
		//debug($currentPage);
		//debug($maxPage);
	
		$this->set('procedimentos', $query);
		$this->set('url', $url);
		$this->set('currentPage', $currentPage);
		$this->set('maxPage', $maxPage);
		//$result = $query->toArray();
	
		//debug($result);
	
		TableRegistry::clear();
	}
	
	public function especialidades(){
		
	}
	
	public function exemplos(){
		
	}
	
}
