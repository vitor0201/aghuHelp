<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;

/**
 * Pendencias Controller
 *
 * @property \Indicadores\Model\Table\PendenciasTable $Pendencias
 */
class PendenciasController extends AppController {
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$this->paginate = [ 
				'contain' => [ 
						'TipoPendencias' 
				] 
		];
		
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorPendencias' 
		] );
		$this->PaginationSession->restore ();
		
		$this->loadComponent ( 'Base.Filter' );
		$this->Filter->addFilter ( [ 
				'filtro1' => [ 
						'field' => 'Pendencias.id',
						'operator' => '=' 
				] 
		] );
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterPendencias' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			$data_export = $this->Pendencias->find ( 'all', [ 
					'conditions' => $conditions,
					'contain' => [ 
							'TipoPendencias' 
					] 
			] );
			$callback = function ($object) {
				return [ 
						$object->id 
				];
			};
			$this->Export->CSV ( 'Pendencias_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $data_export, [ 
					'id' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 15;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Pendencias.id ASC' 
			];
		
		$this->paginate ['conditions'] = $conditions;
		$this->set ( 'pendencias', $this->paginate ( $this->Pendencias ) );
		$this->set ( '_serialize', [ 
				'pendencias' 
		] );
		
		$this->PaginationSession->save ();
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id
	 *        	Pendencia id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$pendencia = $this->Pendencias->get ( $id, [ 
				'contain' => [ 
						'TipoPendencias' 
				] 
		] );
		
		$this->set ( compact ( 'pendencia', $pendencia ) );
		$this->set ( '_serialize', [ 
				'pendencia' 
		] );
	}
	
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add($kanban_cont) {
		// debug($kanban_cont);
		$pendencia = $this->Pendencias->newEntity ();
		if ($this->request->is ( 'post' )) {
			
			// VALIDATION
			$this->request->data ['usuario_id'] = $this->login ['login'];
			$this->request->data ['internacao_id'] = $kanban_cont;
			$this->request->data ['data_cadastro'] = date ( 'd/m/Y H:i:s' );
			unset ( $this->request->data ['id'] );
			unset ( $this->request->data ['remocao_usuario_id'] );
			unset ( $this->request->data ['data_remocao'] );
			unset ( $this->request->data ['observacao_remocao'] );
			
			$pendencia = $this->Pendencias->patchEntity ( $pendencia, $this->request->data );
			if ($this->Pendencias->save ( $pendencia )) {
				// debug($pendencia);
				$this->Flash->success ( __ ( 'O registro foi salvo com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'kanban',
						'controller' => 'Estatisticas' 
				] );
			} else {
				debug ( $pendencia );
				$this->Flash->error ( __ ( 'O registro não foi salvo. Por favor, tente novamente.' ) );
			}
		}
		
		$tipoPendencias = $this->Pendencias->TipoPendencias->find ( 'list', [ 
				'limit' => 200,
				'keyField' => 'id',
				'valueField' => 'descricao' 
		] );
		// $remocaoUsuarios = $this->Pendencias->RemocaoUsuarios->find('list', ['limit' => 200]);
		$this->set ( compact ( 'pendencia', 'tipoPendencias' ) );
		$this->set ( '_serialize', [ 
				'pendencia' 
		] );
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id
	 *        	Pendencia id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
// MÉTODO QUE PODE ALTERAR OU FAZER EXCLUSÃO 
	public function edit($id = null) {
		$pendencia = $this->Pendencias->get ( $id, [ 
				'contain' => [ 
						'TipoPendencias' 
				] 
		] );
		//debug($pendencia);
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			if ($this->request->data ['deletar'] == 1)
			{
				
				$this->request->data ['data_remocao'] = date ( 'd/m/Y H:i:s' );
				$this->request->data ['remocao_usuario_id'] = $this->login ['login'];
				unset ( $this->request->data ['usuario_id'] );
				unset ( $this->request->data ['id'] );
				unset ( $this->request->data ['observacao'] );
				unset ( $this->request->data ['tipo_pendencia_id'] );
				unset ( $this->request->data ['data_cadastro'] );
				
				$pendencia = $this->Pendencias->patchEntity ( $pendencia, $this->request->data );
				if ($this->Pendencias->save ( $pendencia )) {
					// debug($pendencia);
					$this->Flash->success ( __ ( 'O registro foi removido com sucesso.' ) );
					return $this->redirect ( [ 
							'action' => 'kanban',
							'controller' => 'Estatisticas' 
					] );
				} else {
					$this->Flash->error ( __ ( 'O registro não foi removido. Por favor, tente novamente.' ) );
				}
			}
			elseif ($this->request->data ['deletar'] == 0)
			{
				unset ( $this->request->data ['data_remocao']);
				unset ( $this->request->data ['remocao_usuario_id']);
				$this->request->data ['usuario_id'] = $this->login ['login'];
				unset ( $this->request->data ['id'] );
				unset ( $this->request->data ['tipo_pendencia_id'] );
				unset ( $this->request->data ['data_cadastro'] );
				
				$pendencia = $this->Pendencias->patchEntity ( $pendencia, $this->request->data );
				debug($pendencia);
				if ($this->Pendencias->save ( $pendencia )) {
					// debug($pendencia);
					$this->Flash->success ( __ ( 'O registro foi alterado com sucesso.' ) );
					return $this->redirect ( [ 
							'action' => 'kanban',
							'controller' => 'Estatisticas' 
					] );
				} else {
					$this->Flash->error ( __ ( 'O registro não foi alterado. Por favor, tente novamente.' ) );
			}
		}
	}
		$tipoPendencias = $this->Pendencias->TipoPendencias->find ( 'list', [ 
				'limit' => 200 
		] );
		
		$query = $this->aghu ();
		$this->set ( 'internados', $query->toArray () );
		$this->set ( compact ( 'pendencia', 'tipoPendencias' ) );
		$this->set ( '_serialize', [ 
				'pendencia' 
		] );
	}
	
	// MÉTODO QUE EDITA
	public function update($id = null) {
		$pendencia = $this->Pendencias->get ( $id, [ 
				'contain' => [ 
						'TipoPendencias' 
				] 
		] );
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			
			unset ( $this->request->data ['data_remocao'] );
			unset ( $this->request->data ['remocao_usuario_id'] );
			unset ( $this->request->data ['usuario_id'] );
			unset ( $this->request->data ['id'] );
			unset ( $this->request->data ['data_cadastro'] );
			
			$pendencia = $this->Pendencias->patchEntity ( $pendencia, $this->request->data );
			if ($this->Pendencias->save ( $pendencia )) {
				// debug($pendencia);
				$this->Flash->success ( __ ( 'O registro foi removido com sucesso.' ) );
				return $this->redirect ( [ 
						'action' => 'kanban',
						'controller' => 'Estatisticas' 
				] );
			} else {
				$this->Flash->error ( __ ( 'O registro não foi removido. Por favor, tente novamente.' ) );
			}
		}
		$tipoPendencias = $this->Pendencias->TipoPendencias->find ( 'list', [ 
				'limit' => 200 
		] );
		
		$query = $this->aghu ();
		$this->set ( 'internados', $query->toArray () );
		$this->set ( compact ( 'pendencia', 'tipoPendencias' ) );
		$this->set ( '_serialize', [ 
				'pendencia' 
		] );
	}
	public function aghu() {
		$conn = ConnectionManager::get ( 'aghu' );
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorKanban' 
		] );
		$this->PaginationSession->restore ();
		
		$this->loadComponent ( 'Base.Filter' );
		$this->Filter->addFilter ( [ 
				'data_internacao' => [ 
						'field' => 'Internacoes.dthr_internacao',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Internacoes.unf_seq',
						'operator' => 'IN' 
				],
				'especialidade_id' => [ 
						'field' => 'Especialidades.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				],
				'cid' => [ 
						'field' => 'Cids.codigo',
						'operator' => 'ILIKE' 
				] 
		] );
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// debug($conditions);
		
		/*
		 * TABELAS AUXILIARES, MONTAR OPCOES DE FILTRO
		 */
		
		// CRITERIOS
		$criterios = TableRegistry::get ( 'Criterios', [ 
				'table' => 'kanban.criterios' 
		] );
		$criterios = $criterios->find ( 'all', [ 
				'order' => 'unidade_id, especialidade_id, inicio' 
		] )->toArray ();
		
		$this->set ( 'criterios', $criterios );
		
		$this->set ( 'especialidades', $especialidades_list );
		
		// ESPECIALIDADES
		$especialidades = TableRegistry::get ( 'Especialidades', [ 
				'table' => 'agh.agh_especialidades',
				'connection' => $conn 
		] );
		$especialidades_list = $especialidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'nome_especialidade',
				'order' => 'nome_especialidade' 
		] )->cache ( 'list_especialidades', 'long' );
		
		$this->set ( 'especialidades', $especialidades_list );
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => 'descricao',
				'order' => 'descricao' 
		] )->cache ( 'list_unidades', 'long' );
		$this->set ( 'unidades', $unidades_list );
		
		// CIDs
		// $cids = TableRegistry::get('Cids', [
		// 'table' => 'agh.agh_cids',
		// 'connection' => $conn,
		// ]);
		
		// $cids_list = $cids->find('all', [
		// // 'keyField' =>'seq',
		// 'fields'=> ['seq','codigo','descricao'],
		// // 'valueField'=>'descricao',
		// 'order' => 'codigo'
		// ]);
		
		// $aux_cid=array();
		// foreach($cids_list as $cid) {
		// // debug($cid);
		// $aux_cid[$cid->seq] = $cid->codigo ." - ". substr($cid->descricao,0,50);
		// }
		// $this->set('cids', $aux_cid);
		
		// Classe temporaria
		$pacientes = TableRegistry::get ( 'Pacientes', [ 
				'table' => 'agh.aip_pacientes',
				'connection' => $conn 
		] );
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 50;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Pacientes.nome ASC' 
			];
		
		$this->PaginationSession->save ();
		
		$data = $conditions ['Internacoes.dthr_internacao']; // "18/02/2016";
		
		unset ( $conditions ['Internacoes.dthr_internacao'] );
		
		IF (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		
		$query = $pacientes->find ()->
		// ->hydrate(false)
		select ( [ 
				'Movimentos__entrada' => ' MIN(Movimentos.dthr_lancamento) ',
				'Movimentos.int_seq',
				'Movimentos.unf_seq',
				'Movimentos.seq',
				'Unidades.descricao',
				'Pacientes.nome',
				'Pacientes.sexo',
				'Pacientes__idade' => "date_part('year',age(Pacientes.dt_nascimento))",
				'Pacientes.prontuario',
				'Internacoes.dthr_internacao',
				'Pacientes.dt_nascimento',
				'Especialidades.seq',
				'Especialidades.sigla',
				'Especialidades.nome_especialidade',
				'Pessoas.nome',
				'Internacoes.dthr_alta_medica',
				'Internacoes.lto_lto_id',
				'Internacoes.seq',
				'Movimentos.tmi_seq',
				'Cids.codigo',
				'Cids.descricao',
				'Procedimentos.descricao',
				'Internacoes__permanencia' => "date_part('days', coalesce(Internacoes.dt_saida_paciente,CURRENT_TIMESTAMP)-Internacoes.dthr_internacao)" 
		] )->innerJoin ( [ 
				'Internacoes' => 'agh.ain_internacoes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->innerJoin ( [ 
				'Movimentos' => 'agh.ain_movimentos_internacao' 
		], [ 
				'Movimentos.int_seq = Internacoes.seq' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Unidades' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Movimentos.unf_seq = Unidades.seq' 
		] )->
		// ->leftJoin(
		// ['UnidadesLeito' => 'agh.agh_unidades_funcionais'],
		// ['Leitos.unf_seq = UnidadesLeito.seq'])
		
		leftJoin ( [ 
				'Especialidades' => 'agh.agh_especialidades' 
		], [ 
				'Internacoes.esp_seq = Especialidades.seq' 
		] )->leftJoin ( [ 
				'CidInternacoes' => 'agh.ain_cids_internacao' 
		], [ 
				'Internacoes.seq = CidInternacoes.int_seq' 
		] )->leftJoin ( [ 
				'Cids' => 'agh.agh_cids' 
		], [ 
				'CidInternacoes.cid_seq = Cids.seq' 
		] )->leftJoin ( [ 
				'Servidores' => 'agh.rap_servidores' 
		], [ 
				'Internacoes.ser_matricula_professor  = Servidores.matricula',
				'Internacoes.ser_vin_codigo_professor = Servidores.vin_codigo' 
		] )->leftJoin ( [ 
				'Pessoas' => 'agh.rap_pessoas_fisicas' 
		], [ 
				'Servidores.pes_codigo  = Pessoas.codigo' 
		] )->leftJoin ( [ 
				'Procedimentos' => 'agh.fat_itens_proced_hospitalar' 
		], [ 
				'Procedimentos.pho_seq  = Internacoes.IPH_PHO_SEQ',
				'Procedimentos.seq = Internacoes.IPH_SEQ' 
		] )->group ( [ 
				"Movimentos.int_seq,
					Movimentos.unf_seq,
					Movimentos.seq,
					Unidades.descricao,
					Pacientes.nome,
					Pacientes.sexo,
					date_part('year',age(Pacientes.dt_nascimento)),
					Pacientes.prontuario,
					Internacoes.dthr_internacao,
					Pacientes.dt_nascimento,
					Especialidades.seq,
					Especialidades.sigla,
					Especialidades.nome_especialidade,
					Pessoas.nome,
					Internacoes.dthr_alta_medica,
					Internacoes.lto_lto_id,
			        Internacoes.seq,
					Movimentos.tmi_seq,
					Cids.codigo,
					Cids.descricao,
					Procedimentos.descricao,
					date_part('days', coalesce(Internacoes.dt_saida_paciente,CURRENT_TIMESTAMP)-Internacoes.dthr_internacao)
					" 
		] )->order ( 'Internacoes.lto_lto_id, Pacientes.nome, min(Movimentos.dthr_lancamento) DESC, Movimentos.unf_seq' );
		
		$conditions [] = "
                (('$data'::date between Internacoes.dthr_internacao AND Internacoes.dt_saida_paciente)
                OR
                (Internacoes.dt_saida_paciente is null and Internacoes.dthr_internacao<='$data'))
                ";
		$conditions [] = "Movimentos.tmi_seq NOT   IN (11, 12, 13) ";
		
		$conditions [] = "Internacoes.ind_saida_pac = 'N' ";
		
		$query = $query->where ( $conditions );
		return $query;
	}
}
