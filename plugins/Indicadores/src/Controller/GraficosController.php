<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Base\Controller\Component\FilterComponent;

class GraficosController extends AppController {
	public function especialidade() {
		// CONEXÃO COM AGHU
		$conn = ConnectionManager::get ( 'aghu' );
		
		// FILTRO
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
				'data_saida' => [ 
						'field' => 'Internacoes.dt_saida_paciente',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				],
				'especialidade_id' => [ 
						'field' => 'Especialidades.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				] 
		] );
		
		// ...
		
		$where = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		/*
		 * TABELAS QUE GERAM O FILTRO
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
		$this->set ( 'especialidades_list', $especialidades_list );
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidade_leito', [ 
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
		
		/*
		 * VARIAVEIS QUE ARMAZENAM OS FILTROS
		 */
		
		// DATA
		$data = $where ['Internacoes.dthr_internacao']; // "18/02/2016";
		unset ( $where ['Internacoes.dthr_internacao'] );
		$data_final = $where ['Internacoes.dt_saida_paciente']; // "18/02/2016";
		unset ( $where ['Internacoes.dt_saida_paciente'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		if (! $data_final) {
			$data_final = $this->request->data ['data_saida'] = date ( 'd/m/Y' );
		}
		// SEXO
		if (isset ( $this->request->data ['unidade_id'] )) {
			$where ['Pacientes.sexo'];
		}
		// UNIDADE
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Internacoes.unf_seq IN'], $where ['Unidade_leito.seq IN'] );
			}
		}
		
		// ESPECIALIDADE
		if (isset ( $this->request->data ['especialidade_id'] )) {
			$where ['Especialidades.seq IN'];
			// unset($where ['Unidade_leito.seq IN']);
		}
		
		// SELECT
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'Especialidades.nome_especialidade',
				'Total' => "COUNT(*)" 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade_leito.seq = Leitos.unf_seq' 
		] )->innerJoin ( [ 
				'Especialidades' => 'agh.agh_especialidades' 
		], [ 
				'Especialidades.seq = Internacoes.esp_seq' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Pacientes.codigo = Internacoes.pac_codigo' 
		] )->group ( [ 
				'Especialidades.nome_especialidade' 
		] );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		
		$where [] = "(((Internacoes.dthr_internacao between '$data'::date AND '$data_final'::date)
	OR ((Internacoes.dt_saida_paciente between '$data'::date AND '$data_final'::date))
	OR ((Internacoes.dt_saida_paciente is null OR Internacoes.dt_saida_paciente >='$data_final') AND Internacoes.dthr_internacao<='$data')))";
		
		$query->where ( $where );
		$this->set ( 'especialidades', $query );
	}
	public function sexo() {
		// CONEXÃO COM AGHU
		$conn = ConnectionManager::get ( 'aghu' );
		
		// FILTRO
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
				'data_saida' => [ 
						'field' => 'Internacoes.dt_saida_paciente',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				] 
		] );
		
		// ...
		
		$where = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		
		$this->set ( 'url', $this->Filter->getUrl () );
		
		/*
		 * TABELAS QUE GERAM O FILTRO
		 */
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidade_leito', [ 
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
		
		/*
		 * VARIAVEIS QUE ARMAZENAM OS FILTROS
		 */
		
		// DATA
		$data = $where ['Internacoes.dthr_internacao']; // "18/02/2016";
		unset ( $where ['Internacoes.dthr_internacao'] );
		$data_final = $where ['Internacoes.dt_saida_paciente']; // "18/02/2016";
		unset ( $where ['Internacoes.dt_saida_paciente'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		if (! $data_final) {
			$data_final = $this->request->data ['data_saida'] = date ( 'd/m/Y' );
		}
		// UNIDADE
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Unidade_leito.seq IN'], $where ['Internacoes.unf_seq IN'] );
			}
		}
		// SEXO
		if (isset ( $this->request->data ['unidade_id'] )) {
			$where ['Pacientes.sexo'];
		}
		// SELECT
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'Pacientes.sexo',
				'Total' => "COUNT(*)" 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade_leito.seq = Leitos.unf_seq' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Pacientes.codigo = Internacoes.pac_codigo' 
		] )->group ( [ 
				'Pacientes.sexo' 
		] );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		
		$where [] = "(((Internacoes.dthr_internacao between '$data'::date AND '$data_final'::date)
		OR ((Internacoes.dt_saida_paciente between '$data'::date AND '$data_final'::date))
		OR ((Internacoes.dt_saida_paciente is null OR Internacoes.dt_saida_paciente >='$data_final') AND Internacoes.dthr_internacao<='$data')))";
		
		$query->where ( $where );
		$this->set ( 'sexos', $query );
	}
	public function idade() {
		// CONEXÃO COM AGHU
		$conn = ConnectionManager::get ( 'aghu' );
		
		// FILTRO
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
				'data_saida' => [ 
						'field' => 'Internacoes.dt_saida_paciente',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				] 
		] );
		
		// ...
		
		$where = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		
		$this->set ( 'url', $this->Filter->getUrl () );
		
		/*
		 * TABELAS QUE GERAM O FILTRO
		 */
		
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidade_leito', [ 
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
		
		/*
		 * VARIAVEIS QUE ARMAZENAM OS FILTROS
		 */
		
		// DATA
		$data = $where ['Internacoes.dthr_internacao']; // "18/02/2016";
		unset ( $where ['Internacoes.dthr_internacao'] );
		$data_final = $where ['Internacoes.dt_saida_paciente']; // "18/02/2016";
		unset ( $where ['Internacoes.dt_saida_paciente'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		if (! $data_final) {
			$data_final = $this->request->data ['data_saida'] = date ( 'd/m/Y' );
		}
		// SEXO
		if (isset ( $this->request->data ['unidade_id'] )) {
			$where ['Pacientes.sexo'];
		}
		// UNIDADE
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Unidade_leito.seq IN'], $where ['Internacoes.unf_seq IN'] );
			}
		}
		/*
		 * $function é a função que extrai os períodos de idade, usado no SELECT
		 */
		$function = "(CASE 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 0 AND 20 THEN '00 ano - 20 anos' 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 21 AND 30 THEN '21 anos - 30 anos'
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 31 AND 40 THEN '31 anos - 40 anos' 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 41 AND 50 THEN '41 anos - 50 anos' 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 51 AND 60 THEN '51 anos - 60 anos'
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 61 AND 70 THEN '61 anos - 61 anos' 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) BETWEEN 71 AND 80 THEN '71 anos - 80 anos' 
					WHEN (EXTRACT (YEAR FROM (CURRENT_DATE)) - (EXTRACT (YEAR FROM (Pacientes.dt_nascimento)))) >= 81 THEN 'Maior que 81 anos' END) ";
		
		// SELECT
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'count_idade' => "COUNT($function)",
				'faixa_idade' => "$function" 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade_leito.seq = Leitos.unf_seq' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Pacientes.codigo = Internacoes.pac_codigo' 
		] )->group ( [ 
				'faixa_idade' 
		] )->order ( [ 
				'faixa_idade' 
		] );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		
		$where [] = "(((Internacoes.dthr_internacao between '$data'::date AND '$data_final'::date)
		OR ((Internacoes.dt_saida_paciente between '$data'::date AND '$data_final'::date))
		OR ((Internacoes.dt_saida_paciente is null OR Internacoes.dt_saida_paciente >='$data_final') AND Internacoes.dthr_internacao<='$data')))";
		$query->where ( $where );
		$this->set ( 'idades', $query );
	}
	public function cores() {
		// CONEXÃO COM AGHU
		$conn = ConnectionManager::get ( 'aghu' );
		
		// FILTRO
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
				'data_saida' => [ 
						'field' => 'Internacoes.dt_saida_paciente',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				],
				'especialidade_id' => [ 
						'field' => 'Especialidades.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				] 
		] );
		
		// ...
		
		$where = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		/*
		 * TABELAS QUE GERAM O FILTRO
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
		$this->set ( 'especialidades_list', $especialidades_list );
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidade_leito', [ 
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
		
		/*
		 * VARIAVEIS QUE ARMAZENAM OS FILTROS
		 */
		
		// DATA
		$data = $where ['Internacoes.dthr_internacao']; // "18/02/2016";
		unset ( $where ['Internacoes.dthr_internacao'] );
		$data_final = $where ['Internacoes.dt_saida_paciente']; // "18/02/2016";
		unset ( $where ['Internacoes.dt_saida_paciente'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		if (! $data_final) {
			$data_final = $this->request->data ['data_saida'] = date ( 'd/m/Y' );
		}
		// SEXO
		if (isset ( $this->request->data ['unidade_id'] )) {
			$where ['Pacientes.sexo'];
		}
		// UNIDADE
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Internacoes.unf_seq IN'], $where ['Unidade_leito.seq IN'] );
			}
		}
		
		// ESPECIALIDADE
		if (isset ( $this->request->data ['especialidade_id'] )) {
			$where ['Especialidades.seq IN'];
			// unset($where ['Unidade_leito.seq IN']);
		}
		
		// SELECT
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'data_internacao' => "(EXTRACT(EPOCH FROM (date_trunc('seconds', '$data_final' - Internacoes.dthr_internacao)))::int)/60",
				'unidade_id' => 'COALESCE(Internacoes.unf_seq , Leitos.unf_seq  )' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade_leito.seq = Leitos.unf_seq' 
		] )->innerJoin ( [ 
				'Especialidades' => 'agh.agh_especialidades' 
		], [ 
				'Especialidades.seq = Internacoes.esp_seq' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Pacientes.codigo = Internacoes.pac_codigo' 
		] )->order ( 'data_internacao, unidade_id' );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		
		$where [] = "(((Internacoes.dthr_internacao between '$data'::date AND '$data_final'::date)
		OR ((Internacoes.dt_saida_paciente between '$data'::date AND '$data_final'::date))
		OR ((Internacoes.dt_saida_paciente is null OR Internacoes.dt_saida_paciente >='$data_final') AND Internacoes.dthr_internacao<='$data')))";
		
		$query->where ( $where );
		
		// CRITERIOS
		$criterios = TableRegistry::get ( 'Criterios', [ 
				'table' => 'kanban.criterios' 
		] );
		$criterios = $criterios->find ( 'all', [ 
				'order' => 'unidade_id, especialidade_id, inicio' 
		] );
		$this->set ( 'especialidades', $query );
		$this->set ( 'criterios', $criterios );
	}
	public function pendencias() {
		// CONEXÃO COM AGHU
		$conn = ConnectionManager::get ( 'aghu' );
		
		// FILTRO
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
				'data_saida' => [ 
						'field' => 'Internacoes.dt_saida_paciente',
						'operator' => '=' 
				],
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				],
				'especialidade_id' => [ 
						'field' => 'Especialidades.seq',
						'operator' => 'IN' 
				],
				'sexo' => [ 
						'field' => 'Pacientes.sexo',
						'operator' => '=' 
				] 
		] );
		
		// ...
		
		$where = $this->Filter->getConditions ( [ 
				'session' => 'filterKanban' 
		] );
		$this->set ( 'url', $this->Filter->getUrl () );
		/*
		 * TABELAS QUE GERAM O FILTRO
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
		$this->set ( 'especialidades_list', $especialidades_list );
		// UNIDADES
		$unidades = TableRegistry::get ( 'Unidade_leito', [ 
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
		
		/*
		 * VARIAVEIS QUE ARMAZENAM OS FILTROS
		 */
		
		// DATA
		$data = $where ['Internacoes.dthr_internacao']; // "18/02/2016";
		unset ( $where ['Internacoes.dthr_internacao'] );
		$data_final = $where ['Internacoes.dt_saida_paciente']; // "18/02/2016";
		unset ( $where ['Internacoes.dt_saida_paciente'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( 'd/m/Y' );
		}
		if (! $data_final) {
			$data_final = $this->request->data ['data_saida'] = date ( 'd/m/Y' );
		}
		// SEXO
		if (isset ( $this->request->data ['unidade_id'] )) {
			$where ['Pacientes.sexo'];
		}
		// UNIDADE
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Internacoes.unf_seq IN'], $where ['Unidade_leito.seq IN'] );
			}
		}
		
		// ESPECIALIDADE
		if (isset ( $this->request->data ['especialidade_id'] )) {
			$where ['Especialidades.seq IN'];
			// unset($where ['Unidade_leito.seq IN']);
		}
		
		// SELECT
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'data_internacao' => "(EXTRACT(EPOCH FROM (date_trunc('seconds', '$data_final' - Internacoes.dthr_internacao)))::int)/60",
				'unidade_id' => 'COALESCE(Internacoes.unf_seq , Leitos.unf_seq  )',
				'prontuario' => 'Pacientes.prontuario' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Leitos.lto_id = Internacoes.lto_lto_id' 
		] )->leftJoin ( [ 
				'Unidade_leito' => 'agh.agh_unidades_funcionais' 
		], [ 
				'Unidade_leito.seq = Leitos.unf_seq' 
		] )->innerJoin ( [ 
				'Especialidades' => 'agh.agh_especialidades' 
		], [ 
				'Especialidades.seq = Internacoes.esp_seq' 
		] )->leftJoin ( [ 
				'Leitos' => 'agh.ain_leitos' 
		], [ 
				'Internacoes.lto_lto_id = Leitos.lto_id' 
		] )->leftJoin ( [ 
				'Pacientes' => 'agh.aip_pacientes' 
		], [ 
				'Pacientes.codigo = Internacoes.pac_codigo' 
		] )->order ( 'data_internacao, unidade_id' );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		
		$where [] = "(((Internacoes.dthr_internacao between '$data'::date AND '$data_final'::date)
		OR ((Internacoes.dt_saida_paciente between '$data'::date AND '$data_final'::date))
		OR ((Internacoes.dt_saida_paciente is null OR Internacoes.dt_saida_paciente >='$data_final') AND Internacoes.dthr_internacao<='$data')))";
		
		$query->where ( $where );
		$kanb = TableRegistry::get ( 'Indicadores.Pendencias' );
		foreach ( $query as $value ) {
			$arr [] = $value ['prontuario'];
		}
		/*
		 * PENDENCIAS
		 */
		$kanb_list = $kanb->find ( 'all' )->select ( [ 
				'TipoPendencias.descricao',
				'quantidade' => 'count(*)' 
		] )->where ( [ 
				'Pendencias.internacao_id IN' => $arr 
		] )->contain ( [ 
				'TipoPendencias' 
		] )->group ( 'TipoPendencias.descricao' );
		
		$this->set ( 'pendencias', $kanb_list );
	}
}

