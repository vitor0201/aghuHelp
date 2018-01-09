<style>
<!--
.well {
	font-weight: bold;
}
-->
</style>
<div class="panel panel-default">
	<div class="panel-heading">

		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
				<li> <?php echo $fichaIndicador != null ? ( $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $fichaIndicador->id], ['escape' => false])) 
				: ( $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'add', $fichaIndicador->id], ['escape' => false])); ?></li>
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $fichaIndicador->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
			</ul>
		</div>

		<h3>Ficha Indicador</h3>
	</div>

	<div class="panel-body">
		<div class="col-md-12 text-center center-block">
			<div class="well well-sm">1. Dados Gerais do Indicador</div>

			<table class="table table-bordered">
				<tr>
					<th><?= __('Indicador') ?></th>
					<td><?= h( ($fichaIndicador->indicador->nome)) ?></td>
				</tr>
				<tr>
					<th><?= __('Identificador') ?></th>
					<td><?= h($fichaIndicador->identificador) ?></td>
				</tr>
				<tr>
					<th><?= __('Eixo') ?></th>
					<td><?= h($fichaIndicador->eixo) ?></td>

				</tr>
				<tr>
					<th><?= __('Area') ?></th>
					<td><?= h($fichaIndicador->area) ?></td>
				</tr>
				<tr>
					<th><?= __('Tipo') ?></th>
					<td><?= h($fichaIndicador->tipo) ?></td>
				</tr>

				<tr>
					<th><?= __('Nivel') ?></th>
					<td><?= h($fichaIndicador->nivel) ?></td>
				</tr>
				<tr>
					<th><?= __('Parâmetro') ?></th>
					<td><?= h($fichaIndicador->parametro) ?></td>
				</tr>
				<tr>
					<th><?= __('Objetivo') ?></th>
					<td><?= h($fichaIndicador->objetivo) ?></td>
				</tr>
				<tr>
					<th><?= __('Finalidade') ?></th>
					<td><?= h($fichaIndicador->finalidade) ?></td>
				</tr>
				<tr>
					<th><?= __('Historico') ?></th>
					<td><?= h($fichaIndicador->historico) ?></td>
				</tr>
			</table>

			<div class="well well-sm">2. Dados Sobre o Resposável</div>
			<table class="table table-bordered">
				<tr>
					<th><?= __('Responsavel') ?></th>
					<td><?= h($fichaIndicador->responsavel) ?></td>
				</tr>
				<tr>
					<th><?= __('Email') ?></th>
					<td><?= h($fichaIndicador->email) ?></td>
				</tr>
				<tr>
					<th><?= __('Telefone') ?></th>
					<td><?= h($fichaIndicador->telefone) ?></td>
				</tr>
			</table>

			<div class="well well-sm">3. Dados Sobre a Coleta do Indicador</div>
			<table class="table table-bordered">
				<tr>
					<th><?= __('Formula') ?></th>
					<td><?= h($fichaIndicador->formula) ?></td>
				</tr>

				<tr>
					<th><?= __('Homologacao') ?></th>
					<td><?= h($fichaIndicador->homologacao) ?></td>
				</tr>


				<tr>
					<th><?= __('Termos') ?></th>
					<td><?= h($fichaIndicador->termos) ?></td>
				</tr>
				<tr>
					<th><?= __('Fonte') ?></th>
					<td><?= h($fichaIndicador->fonte) ?></td>
				</tr>
				<tr>
					<th><?= __('Unidade de Medição') ?></th>
					<td><?= h($fichaIndicador->unidade_medicao) ?></td>
				</tr>
				<tr>
					<th><?= __('Coleta de Dados') ?></th>
					<td><?= h($fichaIndicador->coleta_dados) ?></td>
				</tr>
				<tr>
					<th><?= __('Periocidade') ?></th>
					<td><?= h($fichaIndicador->periocidade) ?></td>
				</tr>
			</table>
			<ul class="nav nav-tabs">
			</ul>
			<div class="tab-content"></div>

		</div>
	</div>
</div>

