
<div class="arquivos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $arquivo->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $arquivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Arquivo <small><?= h($arquivo->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Categoria') ?></th>
            <td><?= $arquivo->has('categoria') ? $this->Html->link($arquivo->categoria->id, ['controller' => 'Categorias', 'action' => 'view', $arquivo->categoria->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Titulo') ?></th>
            <td><?= h($arquivo->titulo) ?></td>
        </tr>
        <tr>
            <th><?= __('Autor') ?></th>
            <td><?= h($arquivo->autor) ?></td>
        </tr>
        <tr>
            <th><?= __('Descricao') ?></th>
            <td><?= h($arquivo->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Arquivo Caminho') ?></th>
            <td><?= h($arquivo->arquivo_caminho) ?></td>
        </tr>
        <tr>
            <th><?= __('Arquivo Type') ?></th>
            <td><?= h($arquivo->arquivo_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($arquivo->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Arquivo Tamanho') ?></th>
            <td><?= $this->Number->format($arquivo->arquivo_tamanho) ?></td>
        </tr>
        <tr>
            <th><?= __('Data Publicacao') ?></th>
            <td><?= h($arquivo->data_publicacao) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $arquivo->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Tags" aria-controls="Tags" role="tab" data-toggle="tab"><?= __('Related Tags') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Tags">

	    	<?php if (!empty($arquivo->tags)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Descricao') ?></th>
		                <th><?= __('Ativo') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($arquivo->tags as $tags): ?>
	            <?php 
	            	$class="";
	            	//if(!$tags->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($tags->id) ?></td>
	                <td><?= h($tags->descricao) ?></td>
	                <td><?= h($tags->ativo) ?></td>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>

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
