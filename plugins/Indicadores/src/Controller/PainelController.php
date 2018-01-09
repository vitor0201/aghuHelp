<?php

namespace Indicadores\Controller;

use Indicadores\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Base\Controller\Component\FilterComponent;

class PainelController extends AppController {
	public function internacoes() {
		
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
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
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
		$data = $where ['Internacoes.dthr_internacao']; // "01/05/2017";
		unset ( $where ['Internacoes.dthr_internacao'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( '01/m/Y' );
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
				'data_count' => "to_char(date_trunc('month', Internacoes.dthr_internacao)::date, 'MM/YYYY')",
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
		] )->order ( [ 
				'data_count' 
		] )->group ( [ 
				'data_count' 
		] );
		
		/*
		 * SE FOR ENTRE O INTERVALO DE ENTRADA
		 * SE FOR ENTRE O INTERVALO DE SAIDA
		 * SE FOR SAIDA NULA OU SAIDA MAIOR QUE O ULTIMO DIA E MAIOR QUE INTERNACAO MENOR QUE O PRIMEIRO DIA
		 */
		$where [] = "(Internacoes.dthr_internacao >= '$data')";
		
		$query->where ( $where );
		$this->set ( 'internacoes', $query );
	}
	public function leitos() {
		$conn = ConnectionManager::get ( 'aghu' );
		// SELECT
		$internacoes = TableRegistry::get ( 'Leitos', [ 
				'table' => 'agh.ain_leitos',
				'connection' => $conn 
		] );
		/*
		 * Possui a query estática
		 */
		$query = $internacoes->find ( 'all' )->select ( [ 
				'total' => 'count(*)' 
		] )->where ( [ 
				"ind_situacao LIKE 'A'" 
		] );
		$this->set ( 'leitos', $query );
	}
	public function rotatividade() {
		
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
				'unidade_id' => [ 
						'field' => 'Unidade_leito.seq',
						'operator' => 'IN' 
				] 
		] );
		
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
		$data = $where ['Internacoes.dthr_internacao']; // "01/05/2017";
		unset ( $where ['Internacoes.dthr_internacao'] );
		// Se as datas forem vazias
		if (! $data) {
			$data = $this->request->data ['data_internacao'] = date ( '01/m/Y' );
		}
		$where ['Movimentos.tmi_seq IN'] = 21;
		
		/*
		 * Gerar Query para adicionar as unidades com o filtro OR, tanto na query como na sub
		 * Copia o número que herdou do filtro e adiciona nos arrays dos $where
		 * Se for selecionado uma unidade é obrigado a acrescentar o Movimentos.tmi_seq(tipo de movimentação)
		 * o numero 14(transferencia de unidade)
		 */
		if (isset ( $this->request->data ['unidade_id'] ) || isset ( $this->request->query ['unidade_id'] )) {
			if ($this->request->data ['unidade_id']) {
				$where ['Internacoes.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				$where ['OR'] ['Internacoes.unf_seq IN'] = $where ['Internacoes.unf_seq IN'];
				$where ['OR'] ['Unidade_leito.seq IN'] = $where ['Unidade_leito.seq IN'];
				$subWhere ['Leitos.unf_seq IN'] = $where ['Unidade_leito.seq IN'];
				unset ( $where ['Movimentos.tmi_seq IN'] );
				$where ['Movimentos.tmi_seq IN'] = [ 
						14,
						21 
				];
				unset ( $where ['Internacoes.unf_seq IN'], $where ['Unidade_leito.seq IN'] );
			}
		}
		/*
		 * conexão com leitos, que será a subquery de interções
		 */
		$leitos = TableRegistry::get ( 'Leitos', [ 
				'table' => 'agh.ain_leitos',
				'connection' => $conn 
		] );
		$leito = $leitos->find ( 'all' )->select ( [ 
				'contador' => 'count(*)' 
		] )->where ( [ 
				"ind_situacao LIKE 'A'" 
		] );
		$leito->where ( $subWhere );
		
		/*
		 * Query principal, trás todas as saídas das internações e divide pelo número de leitos ativos
		 */
		$internacoes = TableRegistry::get ( 'Internacoes', [ 
				'table' => 'agh.ain_internacoes',
				'connection' => $conn 
		] );
		$query = $internacoes->find ()->select ( [ 
				'data_count' => "to_char(date_trunc('month', Internacoes.dthr_internacao)::date, 'MM/YYYY')",
				'Total' => "TRUNC(((COUNT(*)::numeric)/($leito)::numeric),2)" 
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
		] )->leftJoin ( [ 
				'Movimentos' => 'agh.ain_movimentos_internacao' 
		], [ 
				'Movimentos.int_seq = Internacoes.seq' 
		] )->order ( [ 
				'data_count' 
		] )->group ( [ 
				'data_count' 
		] );
		
		$where [] = "(Internacoes.dthr_internacao >= '$data')";
		$query->where ( $where );
		unset ( $where );
		unset ( $subWhere );
		
		$this->set ( 'internacoes', $query );
	}
	public function ampliacao() {
		$conn = ConnectionManager::get ( 'aghu' );
		// SELECT
		$internacoes = TableRegistry::get ( 'Leitos', [ 
				'table' => 'agh.ain_leitos',
				'connection' => $conn 
		] );
		/*
		 * Possui a query estática
		 */
		$query = $internacoes->find ( 'all' )->select ( [ 
				'total' => 'round(((count(*)::numeric /240::numeric)*100)-100,2)',
				'qtd' => 'count(*)' 
		] )->where ( [ 
				"ind_situacao LIKE 'A'" 
		] );
		$this->set ( 'leitos', $query );
	}
	public function dados($id) {
		$conn = ConnectionManager::get ( 'mv' );
		$dados = TableRegistry::get ( 'Indicadores.Configuracao' );
		$dado = $dados->find ( 'all' )->select ( [ 
				'date' => "to_char((Configuracao.data)::date, 'MM/YYYY')",
				'Configuracao.valor',
				'Indicadores.nome',
				'Configuracao.indicador_id',
				'Indicadores.valor'
		] )->where ( [ 
				'Configuracao.indicador_id' => $id 
		] )->andWhere ( [ 
				'Configuracao.ativo' => true 
		] )->contain ( [ 
				'Indicadores' 
		] )->order ( [ 
				'Configuracao.data' 
		] );
		$this->set ( 'dados', $dado );
	}
}