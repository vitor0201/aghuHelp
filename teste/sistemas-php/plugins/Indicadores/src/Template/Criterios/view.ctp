
<div class="criterios view large-9 medium-8 columns content">
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
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $criterio->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $criterio->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				KANBAN Cores <small><?php //h($criterio->id) ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Cor Hexadecimal') ?></th>
					<td><?= h($criterio->cor)?></td>
				</tr>
				<tr>
					<th><?= __('Cor ') ?></th>
					<td style="background-color:<?php echo $criterio->cor; ?>"></td>
				</tr>
				<tr>
					<th><?= __('Início') ?></th>
					<td><?= $this->Number->format($criterio->inicio) ?></td>
				</tr>
				<tr>
					<th><?= __('Fim') ?></th>
					<td><?= $this->Number->format($criterio->fim) ?></td>
				</tr>
				<tr>
					<th><?= __('Especialidade') ?></th>
					<td><?= h($especialidades[$criterio->especialidade_id]) ?></td>
				</tr>
				<tr>
					<th><?= __('Unidade') ?></th>
					<td><?= $unidades[$criterio->unidade_id] ?></td>
				</tr>
				<tr>
					<th><?= __('Movimentação') ?></th>
					<td><?= $movimentos[$criterio->movimento_id] ?></td>
				</tr>

			</table>



			<ul class="nav nav-tabs">



			</ul>




			<div class="tab-content"></div>

		</div>
	</div>
</div>
