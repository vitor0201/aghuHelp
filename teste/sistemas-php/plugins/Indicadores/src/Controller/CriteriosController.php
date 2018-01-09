<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;

/**
 * Criterios Controller
 *
 * @property \Indicadores\Model\Table\CriteriosTable $Criterios
 */
class CriteriosController extends AppController {
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$conn = ConnectionManager::get ( 'aghu' ); // conexão com o AGHU
		$this->paginate = [ ];
		// 'contain' => ['Especialidades', 'Unidades']
		
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorCriterios' 
		] );
		$this->PaginationSession->restore ();
		$this->loadComponent ( 'Base.Filter' );
		$this->Filter->addFilter ( [ 
				'filtro1' => [ 
						'field' => 'Criterios.id',
						'operator' => '=' 
				] 
		] );
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterCriterios' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			$data_export = $this->Criterios->find ( 'all', [ 
					'conditions' => $conditions,
					'contain' => [ ] 
			] );
			$callback = function ($object) {
				return [ 
						$object->id 
				];
			};
			$this->Export->CSV ( 'Criterios_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $data_export, [ 
					'id' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 15;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Criterios.id ASC' 
			];
			
			// ESPECIALIDADES
		$especialidades = TableRegistry::get ( 'Especialidades', [ 
				'table' => 'agh.agh_especialidades',
				'connection' => $conn 
		] );
		$especialidades_list = $especialidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'nome_especialidade',
				'order' => 'nome_especialidade' 
		] );
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		// MOVIMENTOS
		$movimentos = TableRegistry::get ( 'Movimentos', [
				'table' => 'agh.ain_tipos_mvto_leito',
				'connection' => $conn
		] );
		$movimentos_list = $movimentos->find ( 'list', [
				'keyField' => 'codigo',
				'valueField' => 'descricao',
				'order' => 'descricao'
		] );
		
		// SETS
		$this->set ( 'movimentos', $movimentos_list->toArray() );
		$this->set ( 'especialidades', $especialidades_list->toArray () );
		$this->set ( 'unidades', $unidades_list->toArray () );
		$this->set ( 'criterios', $this->paginate ( $this->Criterios ) );
		$this->set ( '_serialize', [ 
				'criterios' 
		] );
		
		$this->paginate ['conditions'] = $conditions;
		$this->PaginationSession->save ();
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id
	 *        	Criterio id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$conn = ConnectionManager::get ( 'aghu' ); // conexão com o AGHU
		
		$criterio = $this->Criterios->get ( $id, [ 
				'contain' => [ ] 
		] );
		// ESPECIALIDADES
		$especialidades = TableRegistry::get ( 'Especialidades', [ 
				'table' => 'agh.agh_especialidades',
				'connection' => $conn 
		] );
		$especialidades_list = $especialidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'nome_especialidade',
				'order' => 'nome_especialidade' 
		] );
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		
		// MOVIMENTOS
		$movimentos = TableRegistry::get ( 'Movimentos', [
				'table' => 'agh.ain_tipos_mvto_leito',
				'connection' => $conn
		] );
		$movimentos_list = $movimentos->find ( 'list', [
				'keyField' => 'codigo',
				'valueField' => 'descricao',
				'order' => 'descricao'
		] );
		
		// SETS
		$this->set ( 'movimentos', $movimentos_list->toArray() );
		$this->set ( 'especialidades', $especialidades_list->toArray () );
		$this->set ( 'unidades', $unidades_list->toArray () );
		$this->set ( 'criterio', $criterio );
		$this->set ( '_serialize', [ 
				'criterio' 
		] );
	}
	
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$conn = ConnectionManager::get ( 'aghu' ); // conexão com o AGHU
		
		$criterio = $this->Criterios->newEntity ();
		if ($this->request->is ( 'post' )) {
			$criterio = $this->Criterios->patchEntity ( $criterio, $this->request->data );
			$this->request->data ['id'];
			if ($this->Criterios->save ( $criterio )) {
				$this->Flash->success ( __ ( 'O registro foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'index',
						$criterio->id 

				] );
			} else {
				$this->Flash->error ( __ ( 'O registro não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		
		// $especialidades = $this->Criterios->Especialidades->find('list', ['limit' => 200]);
		// $unidades = $this->Criterios->Unidades->find('list', ['limit' => 200]);
		
		// ESPECIALIDADES
		$especialidades = TableRegistry::get ( 'Especialidades', [ 
				'table' => 'agh.agh_especialidades',
				'connection' => $conn 
		] );
		$especialidades_list = $especialidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'nome_especialidade',
				'order' => 'nome_especialidade' 
		] );
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		// MOVIMENTOS
		$movimentos = TableRegistry::get ( 'Movimentos', [ 
				'table' => 'agh.ain_tipos_mvto_leito',
				'connection' => $conn 
		] );
		$movimentos_list = $movimentos->find ( 'list', [ 
				'keyField' => 'codigo',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		
		// SETS
		$this->set ( 'movimentos', $movimentos_list );
		$this->set ( 'unidades', $unidades_list );
		$this->set ( 'especialidades', $especialidades_list );
		$this->set ( compact ( 'criterio' ) );
		$this->set ( '_serialize', [ 
				'criterio' 
		] );
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id
	 *        	Criterio id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$conn = ConnectionManager::get ( 'aghu' ); // conexão com o AGHU
		$criterio = $this->Criterios->get ( $id, [ 
				'contain' => [ ] 
		] );
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			$criterio = $this->Criterios->patchEntity ( $criterio, $this->request->data );
			if ($this->Criterios->save ( $criterio )) {
				$this->Flash->success ( __ ( 'O registro foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'index',
						$criterio->id 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		/*
		 * $especialidades = $this->Criterios->Especialidades->find('list', [
		 * 'limit' => 200
		 * ]);
		 * $unidades = $this->Criterios->Unidades->find('list', [
		 * 'limit' => 200
		 * ]);
		 */
		
		// ESPECIALIDADES
		$especialidades = TableRegistry::get ( 'Especialidades', [ 
				'table' => 'agh.agh_especialidades',
				'connection' => $conn 
		] );
		$especialidades_list = $especialidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'nome_especialidade',
				'order' => 'nome_especialidade' 
		] );
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		
		// LEITOS
		$movimentos = TableRegistry::get ( 'Movimentos', [ 
				'table' => 'agh.ain_tipos_mvto_leito',
				'connection' => $conn 
		] );
		$movimentos_list = $movimentos->find ( 'list', [ 
				'keyField' => 'codigo',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] );
		
		// SETS
		$this->set ( 'movimentos', $movimentos_list );
		$this->set ( 'unidades', $unidades_list );
		$this->set ( 'especialidades', $especialidades_list );
		$this->set ( compact ( 'criterio' ) );
		$this->set ( '_serialize', [ 
				'criterio' 
		] );
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id
	 *        	Criterio id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$conn = ConnectionManager::get ( 'aghu' );
		$this->request->allowMethod ( [ 
				'post',
				'delete' 
		] );
		$criterio = $this->Criterios->get ( $id );
		if ($this->Criterios->delete ( $criterio )) {
			$this->Flash->success ( __ ( 'O registro foi removido com sucesso.' ) );
		} else {
			$this->Flash->error ( __ ( 'O registro não foi removido. Por favor, tente novamente.' ) );
		}
		return $this->redirect ( [ 
				'action' => 'index' 
		] );
	}
	public function lookupcriterios($id = null) {
		$criterio = $this->Criterios->find ( 'all', [ ] )->where ( [ 
				'unidade_id' => $id 
		] )->order ( 'inicio' )->toArray ();
		
		// Conexão com unidades
		$conn = ConnectionManager::get ( 'aghu' );
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao',
				'conditions' => [ 
						'seq' => $id 
				] 
		] );
		
		// SET
		$this->set ( 'unidades', $unidades_list->first () );
		$this->set ( 'criterio', $criterio );
		$this->set ( '_serialize', [ 
				'criterio' 
		] );
	}
}
