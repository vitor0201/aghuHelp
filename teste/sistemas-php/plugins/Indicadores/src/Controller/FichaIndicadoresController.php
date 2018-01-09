<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;

/**
 * FichaIndicadores Controller
 *
 * @property \Indicadores\Model\Table\FichaIndicadoresTable $FichaIndicadores
 */
class FichaIndicadoresController extends AppController {
	
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
				'session' => 'paginatorFichaIndicadores' 
		] );
		$this->PaginationSession->restore ();
		
		$this->loadComponent ( 'Base.Filter' );
		$this->Filter->addFilter ( [ 
				'filtro1' => [ 
						'field' => 'FichaIndicadores.id',
						'operator' => '=' 
				] 
		] );
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterFichaIndicadores' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			$data_export = $this->FichaIndicadores->find ( 'all', [ 
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
			$this->Export->CSV ( 'FichaIndicadores_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $data_export, [ 
					'id' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 15;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'FichaIndicadores.id ASC' 
			];
		
		$this->paginate ['conditions'] = $conditions;
		
		$this->set ( 'fichaIndicadores', $this->paginate ( $this->FichaIndicadores ) );
		$this->set ( '_serialize', [ 
				'fichaIndicadores' 
		] );
		
		$this->PaginationSession->save ();
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id
	 *        	Ficha Indicador id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$fichaIndicador = $this->FichaIndicadores->find ( 'all', [ 
				'contain' => [ 
						'Indicadores' 
				] 
		] )->where ( [ 
				'FichaIndicadores.indicador_id' => $id 
		] );
		$this->set ( 'fichaIndicador', $fichaIndicador->first());
		$this->set ( '_serialize', [ 
				'fichaIndicador' 
		] );
	}
	
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$fichaIndicador = $this->FichaIndicadores->newEntity ();
		if ($this->request->is ( 'post' )) {
			$fichaIndicador = $this->FichaIndicadores->patchEntity ( $fichaIndicador, $this->request->data );
			if ($this->FichaIndicadores->save ( $fichaIndicador )) {
				$this->Flash->success ( __ ( 'O registro de ficha indicador foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'view',
						$fichaIndicador->id 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro de ficha indicador não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		$indicadores = $this->FichaIndicadores->Indicadores->find ( 'list', [ 
				'limit' => 200,
				'keyField' => 'id',
				'valueField' => 'nome' 
		] );
		
		$this->set ( compact ( 'fichaIndicador', 'indicadores' ) );
		$this->set ( '_serialize', [ 
				'fichaIndicador' 
		] );
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id
	 *        	Ficha Indicador id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$fichaIndicador = $this->FichaIndicadores->get ( $id, [ 
				'contain' => [ ] 
		] );
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			$fichaIndicador = $this->FichaIndicadores->patchEntity ( $fichaIndicador, $this->request->data );
			if ($this->FichaIndicadores->save ( $fichaIndicador )) {
				$this->Flash->success ( __ ( 'O registro de ficha indicador foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'view',
						$fichaIndicador->id 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro de ficha indicador não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		$indicadores = $this->FichaIndicadores->Indicadores->find ( 'list', [ 
				'limit' => 200,
				'keyField' => 'id',
				'valueField' => 'nome' 
		] );
		$this->set ( compact ( 'fichaIndicador', 'indicadores' ) );
		$this->set ( '_serialize', [ 
				'fichaIndicador' 
		] );
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id
	 *        	Ficha Indicador id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod ( [ 
				'post',
				'delete' 
		] );
		$fichaIndicador = $this->FichaIndicadores->get ( $id );
		if ($this->FichaIndicadores->delete ( $fichaIndicador )) {
			$this->Flash->success ( __ ( 'O registro de ficha indicador foi removido com sucesso.' ) );
		} else {
			$this->Flash->error ( __ ( 'O registro de ficha indicador não foi removido. Por favor, tente novamente.' ) );
		}
		return $this->redirect ( [ 
				'action' => 'index' 
		] );
	}
}
