
<div class="categorias view large-9 medium-8 columns content">
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
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $categoria->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $categoria->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				Categoria <small><?= h( $categoria->id) ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Descricao') ?></th>
					<td><?= h($categoria->descricao) ?></td>
				</tr>
				<tr>
					<th><?= __('Ativo') ?></th>
					<td><?= $categoria->ativo ? $this->Html->label('ATIVO','info') :  $this->Html->label('INATIVO','danger'); ?></td>
				</tr>
			</table>






			<div class="tab-content">

				<div role="tabpanel" class="tab-pane " id="Arquivos">

	    	<?php if (!empty($categoria->arquivos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th><?= __('Id') ?></th>
								<th><?= __('Categoria Id') ?></th>
								<th><?= __('Titulo') ?></th>
								<th><?= __('Autor') ?></th>
								<th><?= __('Descricao') ?></th>
								<th><?= __('Ativo') ?></th>
								<th><?= __('Arquivo Caminho') ?></th>
								<th><?= __('Arquivo Tamanho') ?></th>
								<th><?= __('Arquivo Type') ?></th>
								<th><?= __('Data Publicacao') ?></th>
								<!--  <th class="actions"><?= __('Actions') ?></th> -->
							</tr>
						</thead>
	            <?php foreach ($categoria->arquivos as $arquivos): ?>
	            <?php
            $class = "";
            // if(!$arquivos->ativo)
            // $class="text-danger";
            
            ?>
	            <tr <?php echo $class;?>>
							<td><?= h($arquivos->id) ?></td>
							<td><?= h($arquivos->categoria_id) ?></td>
							<td><?= h($arquivos->titulo) ?></td>
							<td><?= h($arquivos->autor) ?></td>
							<td><?= h($arquivos->descricao) ?></td>
							<td><?= h($arquivos->ativo) ?></td>
							<td><?= h($arquivos->arquivo_caminho) ?></td>
							<td><?= h($arquivos->arquivo_tamanho) ?></td>
							<td><?= h($arquivos->arquivo_type) ?></td>
							<td><?= h($arquivos->data_publicacao) ?></td>
							<!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Arquivos', 'action' => 'view', $arquivos->id])?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Arquivos', 'action' => 'edit', $arquivos->id])?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Arquivos', 'action' => 'delete', $arquivos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $arquivos->id)])?>

	                </td>
	                -->
						</tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum registro encontrado.</div>
	    <?php endif; ?>
	    </div>
			</div>

		</div>
	</div>
</div>
