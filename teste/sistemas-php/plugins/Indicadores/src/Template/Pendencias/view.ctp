
<div class="pendencias view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading">


			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left pull-right" aria-hidden="true"></span>&nbsp; '.__('Voltar'), ['action' => 'kanban', 'controller'=>'estatisticas'], ['escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				Pendência <small><?= h($pendencia->id) ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Tipo de Pendência') ?></th>
					<td><?= $pendencia->has('tipo_pendencia') ? $this->Html->link($pendencia->tipo_pendencia->descricao, ['controller' => 'TipoPendencias', 'action' => 'view', $pendencia->tipo_pendencia->id]) : '' ?></td>
				</tr>
				<tr>
					<th><?= __('Observação') ?></th>
					<td><?= h($pendencia->observacao) ?></td>
				</tr>

				<tr>
					<th><?= __('Usuário') ?></th>
					<td><?= h($pendencia->usuario_id) ?></td>
				</tr>
				<tr>
					<th><?= __('Data de Cadastro') ?></th>
					<td><?= h($pendencia->data_cadastro) ?></td>
				</tr>
			</table>



			<ul class="nav nav-tabs">



			</ul>




			<div class="tab-content"></div>

		</div>
	</div>
</div>
