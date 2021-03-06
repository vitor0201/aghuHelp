
<div class="tags view large-9 medium-8 columns content">
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
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $tag->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $tag->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				Tag <small><?= Visualizar ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Descricao') ?></th>
					<td><?= h($tag->descricao) ?></td>
				</tr>
				<tr>
					<th><?= __('Ativo') ?></th>
					<td><?= $tag->ativo ? $this->Html->label('ATIVO','info') : $this->Html->label('INATIVO','danger') ; ?></td>
				</tr>
			</table>


		</div>
	</div>
</div>
