<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;

namespace Indicadores\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;

/**
 * Configuracao Controller
 *
 * @property \Indicadores\Model\Table\ConfiguracaoTable $Configuracao
 */
class ConfiguracaoController extends AppController {
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$this->paginate = [ 
				'contain' => [ 
						'Indicadores' 
				] 
		];
		
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorConfiguracao' 
		] );
		$this->PaginationSession->restore ();
		
		$this->loadComponent ( 'Base.Filter' );
		$this->Filter->addFilter ( [ 
				'filtro1' => [ 
						'field' => 'Configuracao.id',
						'operator' => '=' 
				] 
		] );
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterConfiguracao' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			$data_export = $this->Configuracao->find ( 'all', [ 
					'conditions' => $conditions,
					'contain' => [ 
							'Indicadores' 
					] 
			] );
			$callback = function ($object) {
				return [ 
						$object->id 
				];
			};
			$this->Export->CSV ( 'Configuracao_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $data_export, [ 
					'id' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 15;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Configuracao.id ASC' 
			];
		
		$this->paginate ['conditions'] = $conditions;
		
		$this->set ( 'configuracao', $this->paginate ( $this->Configuracao ) );
		$this->set ( '_serialize', [ 
				'configuracao' 
		] );
		
		$this->PaginationSession->save ();
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id
	 *        	Configuracao id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$configuracao = $this->Configuracao->get ( $id, [ 
				'contain' => [ 
						'Indicadores' 
				] 
		] );
		$this->set ( 'configuracao', $configuracao );
		$this->set ( '_serialize', [ 
				'configuracao' 
		] );
	}
	
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$configuracao = $this->Configuracao->newEntity ();
		if ($this->request->is ( 'post' )) {
			$configuracao = $this->Configuracao->patchEntity ( $configuracao, $this->request->data );
			$configuracao->set ( [ 
					'ativo' => true 
			] );
			if ($this->Configuracao->save ( $configuracao )) {
				$this->Flash->success ( __ ( 'O registro de configuracao foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'view',
						$configuracao->id 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro de configuracao não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		
		$indicadores = $this->Configuracao->Indicadores->find ( 'list', [ 
				'limit' => 200,
				'keyField' => 'id',
				'valueField' => 'nome' 
		] )->where ( [ 
				'cadastro_manual IS TRUE' 
		] );
		$this->set ( compact ( 'configuracao', 'indicadores' ) );
		$this->set ( '_serialize', [ 
				'configuracao' 
		] );
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id
	 *        	Configuracao id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$configuracao = $this->Configuracao->get ( $id, [ 
				'contain' => [ ] 
		] );
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			$configuracao = $this->Configuracao->patchEntity ( $configuracao, $this->request->data );
			if ($this->Configuracao->save ( $configuracao )) {
				$this->Flash->success ( __ ( 'O registro de configuracao foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'view',
						$configuracao->id 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro de configuracao não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		$indicadores = $this->Configuracao->Indicadores->find ( 'list', [ 
				'limit' => 200,
				'keyField' => 'id',
				'valueField' => 'nome' 
		] )->where ( [ 
				'cadastro_manual IS TRUE' 
		] );
		$this->set ( compact ( 'configuracao', 'indicadores' ) );
		$this->set ( '_serialize', [ 
				'configuracao' 
		] );
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id
	 *        	Configuracao id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod ( [ 
				'post',
				'delete' 
		] );
		$configuracao = $this->Configuracao->get ( $id );
		if ($configuracao->ativo == true) {
			$configuracao->set ( [ 
					'ativo' => false 
			] );
		} else {
			$configuracao->set ( [ 
					'ativo' => true 
			] );
		}
		
		if ($this->Configuracao->save ( $configuracao )) {
			$this->Flash->success ( __ ( 'O registro foi removido com sucesso.' ) );
		} else {
			$this->Flash->error ( __ ( 'O registro não foi removido. Por favor, tente novamente.' ) );
		}
		return $this->redirect ( [ 
				'action' => 'index' 
		] );
	}
}
