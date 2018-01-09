<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Base\Controller\Component\FilterComponent;

/**
 * Estatisticas Controller
 *
 * @property \Indicadores\Model\Table\EstatisticasTable $Estatisticas
 */
class EstatisticasController extends AppController {
	
	/*
	 * CENSO DIARIO
	 */
	public function kanban() {
		
		// debug($kanb_list);
		// AGHU
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
				],
				'nome_paciente' => [ 
						'field' => 'Pacientes.nome',
						'operator' => 'ILIKE' 
				] 
		] );
		
		// ...
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// debug($conditions);
		// gambi: procura a unidade na internacao ou no leito.
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			// debug($conditions); debug($this->request->data);
			// exit();
			if ($this->request->data ['unidade_id']) {
				$conditions ['Leitos.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				$conditions ['OR'] ['Leitos.unf_seq IN'] = $conditions ['Leitos.unf_seq IN'];
				$conditions ['OR'] ['Internacoes.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				unset ( $conditions ['Leitos.unf_seq IN'], $conditions ['Internacoes.unf_seq IN'] );
			}
		}
		
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
		] )->where ( [ 
				'Unidades.ind_unid_internacao LIKE' => 'S' 
		] )->orWhere ( [ 
				'Unidades.ind_unid_emergencia  LIKE' => 'S' 
		] )->cache ( 'unid_list', 'long' );
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
		- // }
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
		
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y 23:59:59' );
		}
		
		$query = $pacientes->find ()->
		// ->hydrate(false)
		select ( [ 
				'Movimentos__entrada' => ' MIN(Movimentos.dthr_lancamento) ',
				'Movimentos.int_seq',
				'Movimentos.unf_seq',
				'Movimentos.seq',
				'Unidades.descricao',
				'Unidades.ind_unid_emergencia',
				'Unidades.ind_unid_internacao',
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
            	    Unidades.ind_unid_emergencia,
        	        Unidades.ind_unid_internacao,
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
					Procedimentos.descricao,
					date_part('days', coalesce(Internacoes.dt_saida_paciente,CURRENT_TIMESTAMP)-Internacoes.dthr_internacao)
					" 
		] )->order ( 'Internacoes.lto_lto_id, Pacientes.nome, min(Movimentos.dthr_lancamento) DESC, Movimentos.unf_seq' );
		
		$conditions [] = "
		(('$data'::date between Internacoes.dthr_internacao AND Internacoes.dt_saida_paciente)
		OR
		(Internacoes.dt_saida_paciente is null and Internacoes.dthr_internacao<='$data'))
			";
		$conditions [] = "Movimentos.tmi_seq NOT IN (11, 12, 13, 22) "; // condições que não são exibidas as transferencias
		                                                                // $conditions[] = "Movimentos.tmi_seq IN (14) ";
		$conditions [] = "Internacoes.ind_saida_pac = 'N' ";
		// $conditions[] = "Unidades.ind_unid_emergencia like 'S'";
		
		// Unidades.ind_unid_internacao like 'S'";*/
		
		// debug($conditions);
		$query = $query->where ( $conditions );
		
		// debug($query);
		
		/*
		 * $this->paginate = [
		 * 'sortWhitelist'=>[
		 * 'Internacoes.dthr_internacao',
		 * 'Pacientes.nome',
		 * 'Pacientes.prontuario',
		 * 'Pacientes.sexo',
		 * 'Pacientes.dt_nascimento',
		 * 'Internacoes.dt_saida_paciente' ,
		 * 'Unidades.descricao',
		 * 'Cids.codigo',
		 * 'Pessoas.nome',
		 * 'Especialidades.nome_especialidade',
		 * 'Internacoes.lto_lto_id'
		 *
		 * ]
		 * ];
		 *
		 * $this->paginate['conditions'] = $conditions;
		 */
		
		// INDICADORES.PENDENCIA
		$kanb = TableRegistry::get ( 'Indicadores.Pendencias' );
		foreach ( $query as $value ) {
			$arr [] = $value ['prontuario'];
		}
		$kanb_list = $kanb->find ( 'all' )->where ( [ 
				'Pendencias.internacao_id IN' => $arr 
		] )->contain ( [ 
				'TipoPendencias' 
		] );
		// debug($query);
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			// $query = $query->execute();
			$callback = function ($object) {
				// debug($object);
				// exit();
				return [ 
						$object->nome,
						$object->prontuario,
						$object->dt_nascimento->format ( 'd/m/Y' ),
						$object->sexo,
						$object->idade,
						$object ['Internacoes'] ['dthr_internacao'],
						$object ['Internacoes'] ['dt_saida_paciente'],
						$object ['Internacoes'] ['dthr_alta_medica'],
						$object ['Internacoes'] ['permanencia'],
						$object ['Internacoes'] ['leito'],
						$object ['Unidades'] ['descricao'],
						$object ['Especialidades'] ['nome_especialidade'],
						$object ['Cids'] ['codigo'],
						$object ['Cids'] ['descricao'],
						$object ['Medico'] ['nome'] 
				];
			};
			$this->Export->CSV ( 'Criterios_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $query, [ 
					'Nome',
					'Prontuario',
					'Nascimento',
					'Sexo',
					'Idade',
					'Data Internacao',
					'Data Saida',
					'Data Alta',
					'Permanencia',
					'Leito',
					'Unidade',
					'Especialidade',
					'Cid codigo',
					'Cid',
					'Medico' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 350;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Pacientes.prontuario ASC' 
			];
			// SET
		$this->set ( 'internados', $this->paginate ( $query ) );
		$this->set ( 'internados', $query );
		$this->set ( 'kanb', $kanb_list );
		
		// debug($query->clause('where'));
	}
	
	/*
	 * CENSO DIARIO
	 */
	public function internacao() {
		$conn = ConnectionManager::get ( 'aghu' );
		
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorEstatisticas' 
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
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterEstatisticas' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// gambi: procura a unidade na internacao ou no leito.
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			// debug($conditions);
			if ($this->request->data ['unidade_id']) {
				$conditions ['Leitos.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				$conditions ['OR'] ['Leitos.unf_seq IN'] = $conditions ['Leitos.unf_seq IN'];
				$conditions ['OR'] ['Internacoes.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				unset ( $conditions ['Leitos.unf_seq IN'], $conditions ['Internacoes.unf_seq IN'] );
			}
		}
		
		// debug($conditions); exit;
		
		/*
		 * TABELAS AUXILIARES, MONTAR OPCOES DE FILTRO
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
		] )->where ( [ 
				'Unidades.ind_unid_internacao LIKE' => 'S' 
		] )->orWhere ( [ 
				'Unidades.ind_unid_emergencia  LIKE' => 'S' 
		] )->cache ( 'unid_list', 'long' );
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
		
		// if (! isset ( $this->request->query ['limit'] ))
		// $this->paginate ['limit'] = 50;
		
		// if (! isset ( $this->request->query ['order'] ))
		// $this->paginate ['order'] = [
		// 'Pacientes.nome ASC'
		// ];
		
		// $this->PaginationSession->save ();
		
		$data = $conditions ['Internacoes.dthr_internacao']; // "18/02/2016";
		
		unset ( $conditions ['Internacoes.dthr_internacao'] );
		
		IF (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y 23:59:59' );
		}
		
		$query = $pacientes->find ()->
		// ->hydrate(false)
		select ( [ 
				'Pacientes.nome',
				'Pacientes.prontuario',
				'Pacientes.dt_nascimento',
				'Pacientes.sexo',
				'Pacientes__idade' => "date_part('year',age(Pacientes.dt_nascimento))",
				'Internacoes.dthr_internacao',
				'Internacoes.unf_seq',
				'Internacoes.dt_saida_paciente',
				'Internacoes.dthr_alta_medica',
				'Internacoes__permanencia' => "date_part('days', coalesce(Internacoes.dt_saida_paciente,CURRENT_TIMESTAMP)-Internacoes.dthr_internacao)",
				'Unidades__descricao' => " (coalesce((Unidades.descricao),'') || coalesce((UnidadesLeito.descricao),'')) ",
				'Unidades__sigla' => " (coalesce((Unidades.sigla),'') || coalesce((UnidadesLeito.sigla),'')) ",
				'Internacoes__leito' => 'Internacoes.lto_lto_id',
				'Especialidades.nome_especialidade',
				'Cids.codigo',
				'Cids.descricao',
				'Medico__nome' => 'Pessoas.nome' 
		] )->innerJoin ( [ 
				'Internacoes' => 'agh.ain_internacoes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Unidades' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Internacoes.unf_seq = Unidades.seq' 
		] )->leftJoin ( [ 
				'UnidadesLeito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Leitos.unf_seq = UnidadesLeito.seq' 
		] )->leftJoin ( [ 
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
		] );
		
		// ->where("
		// ('$data'::date between Internacoes.dthr_internacao AND Internacoes.dt_saida_paciente)
		// OR (Internacoes.dt_saida_paciente is null and Internacoes.dthr_internacao<='$data')
		// "
		// )
		
		// debug($conditions);
		// debug($this->request->query);
		$paginate_query = $this->request->query;
		if (empty ( $conditions ) && $data != date ( 'd/m/Y' )) {
			// echo "CACHE";
			$query->cache ( "$data-" . md5 ( json_encode ( $paginate_query ) ), 'long' );
		} else {
			// echo "NAO CACHE";
		}
		
		$conditions [] = "
						(('$data'::date between Internacoes.dthr_internacao AND Internacoes.dt_saida_paciente)
							OR 
						(Internacoes.dt_saida_paciente is null and Internacoes.dthr_internacao<='$data'))
						";
		
		$this->paginate = [ 
				'sortWhitelist' => [ 
						'Internacoes.dthr_internacao',
						'Pacientes.nome',
						'Pacientes.prontuario',
						'Pacientes.sexo',
						'Pacientes.dt_nascimento',
						'Internacoes.dt_saida_paciente',
						'Unidades.descricao',
						'Cids.codigo',
						'Pessoas.nome',
						'Especialidades.nome_especialidade',
						'Internacoes.lto_lto_id' 
				],
				'limit' => 500,
				'order' => [ 
						'Pacientes.prontuario ASC' 
				] 
		];
		
		$this->paginate ['conditions'] = $conditions;
		
		// Export CSV
		if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
			$this->loadComponent ( 'Base.Export' );
			// $query = $query->execute();
			$callback = function ($object) {
				// debug($object);
				// exit();
				return [ 
						$object->nome,
						$object->prontuario,
						$object->dt_nascimento->format ( 'd/m/Y' ),
						$object->sexo,
						$object->idade,
						$object ['Internacoes'] ['dthr_internacao'],
						$object ['Internacoes'] ['dt_saida_paciente'],
						$object ['Internacoes'] ['dthr_alta_medica'],
						$object ['Internacoes'] ['permanencia'],
						$object ['Internacoes'] ['leito'],
						$object ['Unidades'] ['descricao'],
						$object ['Especialidades'] ['nome_especialidade'],
						$object ['Cids'] ['codigo'],
						$object ['Cids'] ['descricao'],
						$object ['Medico'] ['nome'] 
				];
			};
			$this->Export->CSV ( 'Criterios_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $query, [ 
					'Nome',
					'Prontuario',
					'Nascimento',
					'Sexo',
					'Idade',
					'Data Internacao',
					'Data Saida',
					'Data Alta',
					'Permanencia',
					'Leito',
					'Unidade',
					'Especialidade',
					'Cid codigo',
					'Cid',
					'Medico' 
			], $callback );
		}
		
		if (! isset ( $this->request->query ['limit'] ))
			$this->paginate ['limit'] = 100;
		
		if (! isset ( $this->request->query ['order'] ))
			$this->paginate ['order'] = [ 
					'Pacientes.prontuario ASC' 
			];
			// SET
		$this->set ( 'internados', $this->paginate ( $query ) );
		$this->set ( 'internados', $query );
		
		// debug($query->clause('where'));
		// debug($query);
	}
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	// Função que exibe os detalhes do paciente
	public function paciente($id = null) {
		// AGHU CONEXÃO
		$conn = ConnectionManager::get ( 'aghu' );
		$pacientes = TableRegistry::get ( 'Pacientes', [ 
				'table' => 'agh.aip_pacientes',
				'connection' => $conn 
		] );
		// $pacientes_list = $pacientes->select()
		
		$paciente_list = $pacientes->find ( 'all' )->select ( [ 
				'Pacientes.nome',
				'Pacientes.prontuario',
				'Pacientes.dt_nascimento',
				'Pacientes.naturalidade',
				'Pacientes.nro_cartao_saude',
				'Pacientes.cpf',
				'Pacientes.rg',
				'Pacientes.nome_mae',
				'Pacientes.nome_pai',
				'Pacientes.naturalidade',
				'Pacientes.cor',
				'Pacientes.sexo',
				'Pacientes.sexo_biologico',
				'Pacientes.grau_instrucao',
				'Pacientes.estado_civil',
				'Pacientes.ddd_fone_residencial',
				'Pacientes.fone_residencial',
				'Cidades.nome',
				'Cidades.uf_sigla',
				'Cidades.cod_ibge',
				'Endereco_pacientes.tipo_endereco',
				'Logradouros.nome',
				'Endereco_pacientes.nro_logradouro',
				'Bairros.descricao',
				'Endereco_pacientes.bcl_clo_cep' 
		] )->leftJoin ( [ 
				'Cidades' => 'agh.aip_cidades' 
		], [ 
				'Pacientes.cdd_codigo = Cidades.codigo' 
		] )->leftJoin ( [ 
				'Nacionalidades' => 'agh.aip_nacionalidades' 
		], [ 
				'Pacientes.nac_codigo = Nacionalidades.codigo' 
		] )->leftJoin ( [ 
				'Endereco_pacientes' => 'agh.aip_enderecos_pacientes' 
		], [ 
				'Pacientes.codigo = Endereco_pacientes.pac_codigo' 
		] )->leftJoin ( [ 
				'Logradouros' => 'agh.aip_logradouros' 
		], [ 
				'Endereco_pacientes.bcl_clo_lgr_codigo = Logradouros.codigo' 
		] )->leftJoin ( [ 
				'Bairros' => 'agh.aip_bairros' 
		], [ 
				'Endereco_pacientes.bcl_bai_codigo = Bairros.codigo' 
		] )->where ( [ 
				'prontuario' => $id 
		] )->first ()->toArray ();
		// debug($paciente_list);
		
		$this->set ( 'paciente', $paciente_list );
		$this->set ( '_serialize', [ 
				'paciente' 
		] );
	}
	public function historico($id = null) {
		
		// AGHU CONEXÃO
		$conn = ConnectionManager::get ( 'aghu' );
		$pacientes = TableRegistry::get ( 'Pacientes', [ 
				'table' => 'agh.aip_pacientes',
				'connection' => $conn 
		] );
		
		$paciente_list = $pacientes->find ( 'all' )->select ( [ 
				'Pacientes.nome',
				'Pacientes.prontuario',
				'Pacientes.dt_nascimento' 
		] )->innerJoin ( [ 
				'Internacoes' => 'agh.ain_internacoes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->where ( [ 
				'Pacientes.prontuario' => $id 
		] )->first ();
		
		// INDICADORES.PENDENCIA -
		$kanb = TableRegistry::get ( 'Indicadores.Pendencias' );
		$kanb_list = $kanb->find ( 'all' )->where ( [ 
				'Pendencias.internacao_id IN' => $paciente_list ['prontuario'] 
		] )->contain ( [ 
				'TipoPendencias' 
		] );
		
		// set
		$this->set ( 'paciente', $paciente_list );
		$this->set ( 'pendencias', $kanb_list );
		$this->set ( '_serialize', [ 
				'paciente' 
		] );
	}
	
	// FUNÇÃO PARA EXIBIÇÃO
	public function monitor() {
		$conn = ConnectionManager::get ( 'aghu' );
		
		$this->loadComponent ( 'Base.PaginationSession', [ 
				'session' => 'paginatorEstatisticas' 
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
				] 
		] );
		
		$conditions = $this->Filter->getConditions ( [ 
				'session' => 'filterEstatisticas' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		
		// gambi: procura a unidade na internacao ou no leito.
		
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			// debug($conditions);
			if ($this->request->data ['unidade_id']) {
				$conditions ['Leitos.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				$conditions ['OR'] ['Leitos.unf_seq IN'] = $conditions ['Leitos.unf_seq IN'];
				$conditions ['OR'] ['Internacoes.unf_seq IN'] = $conditions ['Internacoes.unf_seq IN'];
				
				// $legenda = $this->request->data;
				$this->set ( 'legenda', $this->request->data );
				unset ( $conditions ['Leitos.unf_seq IN'], $conditions ['Internacoes.unf_seq IN'] );
			}
		}
		
		// debug($conditions); exit;
		
		/*
		 * TABELAS AUXILIARES, MONTAR OPCOES DE FILTRO
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
		] )->cache ( 'list_especialidades', 'long' );
		
		$this->set ( 'especialidades', $especialidades_list );
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidades', [ 
				'table' => 'agh.agh_unidades_funcionais',
				'connection' => $conn 
		] );
		
		$unidades_list = $unidades->find ( 'list', [ 
				'keyField' => 'seq',
				'valueField' => ([ 
						'descricao',
						'seq' 
				]),
				'order' => ([ 
						'descricao',
						'seq' 
				]) 
		] )->where ( [ 
				'Unidades.ind_unid_internacao LIKE' => 'S' 
		] )->orWhere ( [ 
				'Unidades.ind_unid_emergencia  LIKE' => 'S' 
		] )->cache ( 'unid_list', 'long' );
		$this->set ( 'unidades', $unidades_list );
		
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
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y 23:59:59' );
		}
		
		$query = $pacientes->find ()->
		// ->hydrate(false)
		select ( [ 
				'Pacientes.nome',
				'Pacientes.prontuario',
				'Pacientes.dt_nascimento',
				'Pacientes.sexo',
				'Pacientes__idade' => "date_part('year',age(Pacientes.dt_nascimento))",
				'Internacoes.dthr_internacao',
				'Internacoes.unf_seq',
				'Internacoes.dthr_internacao',
				'Internacoes.dt_saida_paciente',
				'Internacoes.dthr_alta_medica',
				'Internacoes__permanencia' => "date_part('days', coalesce(Internacoes.dt_saida_paciente,CURRENT_TIMESTAMP)-Internacoes.dthr_internacao)",
				'Unidades__descricao' => " (coalesce((Unidades.descricao),'') || coalesce((UnidadesLeito.descricao),'')) ",
				'Unidades__sigla' => " (coalesce((Unidades.sigla),'') || coalesce((UnidadesLeito.sigla),'')) ",
				'Unidades.seq',
				'Internacoes__leito' => 'Internacoes.lto_lto_id',
				'Especialidades.nome_especialidade',
				'Medico__nome' => 'Pessoas.nome',
				'Movimentos__entrada' => " MAX(Movimentos.dthr_lancamento) " 
		] )->innerJoin ( [ 
				'Internacoes' => 'agh.ain_internacoes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Unidades' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Internacoes.unf_seq = Unidades.seq' 
		] )->leftJoin ( [ 
				'UnidadesLeito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Leitos.unf_seq = UnidadesLeito.seq' 
		] )->leftJoin ( [ 
				'Especialidades' => 'agh.agh_especialidades' 
		], [ 
				'Internacoes.esp_seq = Especialidades.seq' 
		] )->leftJoin ( [ 
				'Servidores' => 'agh.rap_servidores' 
		], [ 
				'Internacoes.ser_matricula_professor  = Servidores.matricula',
				'Internacoes.ser_vin_codigo_professor = Servidores.vin_codigo' 
		] )->leftJoin ( [ 
				'Pessoas' => 'agh.rap_pessoas_fisicas' 
		], [ 
				'Servidores.pes_codigo  = Pessoas.codigo' 
		] )->innerJoin ( [ 
				'Movimentos' => 'agh.ain_movimentos_internacao' 
		], [ 
				'Movimentos.int_seq = Internacoes.seq' 
		] )->group ( [ 
				"
				Pacientes.nome,
				Pacientes.prontuario,
				Pacientes.dt_nascimento,
				Pacientes.sexo,
				Internacoes.dthr_internacao,
				Internacoes.unf_seq,
				Internacoes.dthr_internacao,
				Internacoes.dt_saida_paciente,
				Internacoes.dthr_alta_medica,
				Especialidades.nome_especialidade,
				Unidades.descricao,
				UnidadesLeito.descricao,
				Unidades.sigla,
				UnidadesLeito.sigla,
				Internacoes.lto_lto_id,
				Unidades.seq,
				Pessoas.nome" 
		] )->order ( 'Internacoes.lto_lto_id, Pacientes.nome, min(Movimentos.dthr_lancamento) DESC' );
		
		$paginate_query = $this->request->query;
		if (empty ( $conditions ) && $data != date ( 'd/m/Y ' )) {
			// echo "CACHE";
			$query->cache ( "$data-" . md5 ( json_encode ( $paginate_query ) ), 'long' );
		} else {
			// echo "NAO CACHE";
		}
		
		$conditions [] = "
				(('$data'::date between Internacoes.dthr_internacao AND Internacoes.dt_saida_paciente)
				OR
				(Internacoes.dt_saida_paciente is null and Internacoes.dthr_internacao<='$data'))
				";
		
		$this->paginate = [ 
				'sortWhitelist' => [ 
						'Internacoes.dthr_internacao',
						'Pacientes.nome',
						'Pacientes.prontuario',
						'Pacientes.sexo',
						'Pacientes.dt_nascimento',
						'Internacoes.dt_saida_paciente',
						'Unidades.descricao',
						'Cids.codigo',
						'Pessoas.nome',
						'Especialidades.nome_especialidade',
						'Internacoes.lto_lto_id' 
				] 
		];
		
		$this->paginate ['conditions'] = $conditions;
		
		// CRITERIOS
		$criterios = TableRegistry::get ( 'Criterios', [ 
				'table' => 'kanban.criterios' 
		] );
		$criterios = $criterios->find ( 'all', [ 
				'order' => 'unidade_id, especialidade_id, inicio' 
		] )->toArray ();
		$this->set ( 'criterios', $criterios );
		
		// INDICADORES.PENDENCIA
		$kanb = TableRegistry::get ( 'Indicadores.Pendencias' );
		
		$kanb_list = $kanb->find ( 'all' )->contain ( [ 
				'TipoPendencias' 
		] )->toArray ();
		
		// SET
		$this->set ( 'especialidades', $especialidades_list );
		$this->set ( 'internados', $this->paginate ( $query ) );
		$this->set ( 'kanb', $kanb_list );
	}
	public function leitos() {
		$conn = ConnectionManager::get ( 'aghu' );
		
		/*
		 * PACIENTES
		 * conecta com o BD(AGHU) e trás todos os pacientes internados
		 * tambem reutiliza o TableRegistry de Paciente para fazer o where no SQL do leitos
		 * tml_cod == 16
		 */
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		
		$internacoesQuery = $internacoes->find ( 'all' )->select ( [ 
				'prontuario' => 'Pacientes.prontuario',
				'unidade' => "COALESCE(Pacientes.unf_seq, leitos.unf_seq)",
				'leito' => "COALESCE(Pacientes.lto_lto_id, '0000')",
				'descricao' => "(coalesce((unidade.descricao),'') || coalesce((unidade_leito.descricao),''))",
				'tml_cod' => "COALESCE(Leitos.tml_codigo, '16') ",
				'dt_inter' => 'Internacoes.dthr_internacao' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->leftJoin ( [ 
				'leitos' => 'agh.ain_leitos' 
		], [ 
				'leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'unidade' => 'agh.agh_unidades_funcionais' 
		], [ 
				'unidade.seq = Internacoes.unf_seq' 
		] )->leftJoin ( [ 
				'unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'unidade_leito.seq = leitos.unf_seq ' 
		] )->where ( [ 
				'(Internacoes.dt_saida_paciente IS NULL AND Internacoes.dthr_internacao IS NOT NULL)' 
		] );
		
		/*
		 * LEITOS
		 *
		 * conecta com o BD(AGHU) e trás todos os leitos que não estão ocupados
		 * condição 'Leitos.tml_codigo' => 'tml_cod' != 16
		 * o where compara com todos os pacientes que estão em leitos != 0000(temporário ou corredor) e não os trazendo
		 */
		
		$leitosWhere = $internacoes->find ( 'all' )->select ( [ 
				'Pacientes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Internacoes.pac_codigo = Pacientes.codigo' 
		] )->where ( [ 
				'Internacoes.dt_saida_paciente IS NULL AND Internacoes.dthr_internacao IS NOT NULL AND Pacientes.lto_lto_id IS NOT NULL' 
		] );
		// $leitosWhere[] = "(AND Leitos.ind_situacao LIKE 'A')";
		
		$leitos = TableRegistry::get ( 'Leitos', [ 
				'table' => 'agh.ain_leitos',
				'connection' => $conn 
		] );
		
		$leitos = $leitos->find ( 'all' )->select ( [ 
				'prontuario' => 'CAST((NULL) AS INTEGER)',
				'unidade' => 'Leitos.unf_seq',
				'leito' => 'Leitos.lto_id',
				'descricao' => 'Unidade.descricao',
				'tml_cod' => 'Leitos.tml_codigo',
				'dt_inter' => 'CAST((NULL) AS TIMESTAMP)' 
		] )->leftJoin ( [ 
				'Unidade' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade.seq = Leitos.unf_seq' 
		] )->leftJoin ( [ 
				'Internacao' => 'agh.ain_internacoes' 
		], [ 
				'Internacao.lto_lto_id =  Leitos.lto_id AND Internacao.dt_saida_paciente is null' 
		] )->where ( [ 
				"Leitos.lto_id NOT IN" => $leitosWhere 
		] )->where ( [ 
				"Leitos.ind_situacao LIKE 'A'" 
		] );
		
		/*
		 * UNION entre as duas tabelas
		 */
		
		$internacoesQuery = $internacoesQuery->union ( $leitos );
		$internacoesQuery->find ( 'all' )->epilog ( 'ORDER BY  descricao, dt_inter ASC NULLS LAST, tml_cod' );
		// debug($internacoesQuery);
		/*
		 * CRITÉRIOS
		 */
		$criterios = TableRegistry::get ( 'Criterios', [ 
				'table' => 'kanban.criterios' 
		] );
		$criterios = $criterios->find ( 'all', [ 
				'order' => 'unidade_id, especialidade_id, inicio' 
		] )->toArray ();
		
		/*
		 * SET
		 */
		$this->set ( 'criterios', $criterios );
		$this->set ( 'leitos', $internacoesQuery->toArray () );
		
		// debug($query->clause('where'));
	}
	public function painel() {
	}
	public function taxaOcupacao() {
	}
	public function painelConfig(){
		
	}
}




//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	// public function index() {
	// $this->loadComponent ( 'Base.PaginationSession', [
	// 'session' => 'paginatorEstatisticas'
	// ] );
	// $this->PaginationSession->restore ();
	
	// $this->loadComponent ( 'Base.Filter' );
	// $this->Filter->addFilter ( [
	// 'filtro1' => [
	// 'field' => 'Estatisticas.id',
	// 'operator' => '='
	// ]
	// ] );
	// // ...
	
	// $conditions = $this->Filter->getConditions ( [
	// 'session' => 'filterEstatisticas'
	// ] );
	// $this->set ( 'url', $this->Filter->getUrl () );
	
	// // Export CSV
	// if (isset ( $this->request->query ['export'] ) && $this->request->query ['export'] == 'csv') {
	// $this->loadComponent ( 'Base.Export' );
	// $data_export = $this->Estatisticas->find ( 'all', [
	// 'conditions' => $conditions
	// ] );
	// $callback = function ($object) {
	// return [
	// $object->id
	// ];
	// };
	// $this->Export->CSV ( 'Estatisticas_' . date ( 'd_m_Y_H_i_s' ) . '.csv', $data_export, [
	// 'id'
	// ], $callback );
	// }
	
	// if (! isset ( $this->request->query ['limit'] ))
	// $this->paginate ['limit'] = 15;
	
	// if (! isset ( $this->request->query ['order'] ))
	// $this->paginate ['order'] = [
	// 'Estatisticas.id ASC'
	// ];
	
	// $this->paginate ['conditions'] = $conditions;
	
	// $this->set ( 'estatisticas', $this->paginate ( $this->Estatisticas ) );
	// $this->set ( '_serialize', [
	// 'estatisticas'
	// ] );
	
	// $this->PaginationSession->save ();
	// }
	
	// /**
	// * View method
	// *
	// * @param string|null $id
	// * Estatistica id.
	// * @return void
	// * @throws \Cake\Network\Exception\NotFoundException When record not found.
	// */
/**
 * Add method
 *
 * @return void Redirects on successful add, renders view otherwise.
 */
	/*
	 * public function add()
	 * {
	 * $estatistica = $this->Estatisticas->newEntity();
	 * if ($this->request->is('post')) {
	 * $estatistica = $this->Estatisticas->patchEntity($estatistica, $this->request->data);
	 * if ($this->Estatisticas->save($estatistica)) {
	 * $this->Flash->success(__('O registro de estatistica foi salvo com sucesso.'));
	 * return $this->redirect([
	 * 'action' => 'view',
	 * $estatistica->id
	 * ]);
	 * } else {
	 * $this->Flash->error(__('O registro de estatistica não foi salvo. Por favor, tente novamente.'));
	 * }
	 * }
	 * $this->set(compact('estatistica'));
	 * $this->set('_serialize', [
	 * 'estatistica'
	 * ]);
	 * }
	 */

/**
 * Edit method
 *
 * @param string|null $id
 *        	Estatistica id.
 * @return void Redirects on successful edit, renders view otherwise.
 * @throws \Cake\Network\Exception\NotFoundException When record not found.
 */
	/*
	 * public function edit($id = null)
	 * {
	 * $estatistica = $this->Estatisticas->get($id, [
	 * 'contain' => []
	 * ]);
	 * if ($this->request->is([
	 * 'patch',
	 * 'post',
	 * 'put'
	 * ])) {
	 * $estatistica = $this->Estatisticas->patchEntity($estatistica, $this->request->data);
	 * if ($this->Estatisticas->save($estatistica)) {
	 * $this->Flash->success(__('O registro de estatistica foi salvo com sucesso.'));
	 * return $this->redirect([
	 * 'action' => 'view',
	 * $estatistica->id
	 * ]);
	 * } else {
	 * $this->Flash->error(__('O registro de estatistica não foi salvo. Por favor, tente novamente.'));
	 * }
	 * }
	 * $this->set(compact('estatistica'));
	 * $this->set('_serialize', [
	 * 'estatistica'
	 * ]);
	 * }
	 *
	 * /**
	 * Delete method
	 *
	 * @param string|null $id
	 * Estatistica id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	/*
	 * public function delete($id = null)
	 * {
	 * $this->request->allowMethod([
	 * 'post',
	 * 'delete'
	 * ]);
	 * $estatistica = $this->Estatisticas->get($id);
	 * if ($this->Estatisticas->delete($estatistica)) {
	 * $this->Flash->success(__('O registro de estatistica foi removido com sucesso.'));
	 * } else {
	 * $this->Flash->error(__('O registro de estatistica não foi removido. Por favor, tente novamente.'));
	 * }
	 * return $this->redirect([
	 * 'action' => 'index'
	 * ]);
	 * }
	 */

