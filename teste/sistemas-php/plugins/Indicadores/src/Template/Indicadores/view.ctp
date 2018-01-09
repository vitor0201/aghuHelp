
<div class="indicadores view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $indicador->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $indicador->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Indicador <small><?= h($indicador->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($indicador->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($indicador->id) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Configuracao" aria-controls="Configuracao" role="tab" data-toggle="tab"><?= __('Related Configuracao') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Configuracao">

	    	<?php if (!empty($indicador->configuracao)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Data') ?></th>
		                <th><?= __('Valor') ?></th>
		                <th><?= __('Indicador Id') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($indicador->configuracao as $configuracao): ?>
	            <?php 
	            	$class="";
	            	//if(!$configuracao->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($configuracao->id) ?></td>
	                <td><?= h($configuracao->data) ?></td>
	                <td><?= h($configuracao->valor) ?></td>
	                <td><?= h($configuracao->indicador_id) ?></td>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Configuracao', 'action' => 'view', $configuracao->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Configuracao', 'action' => 'edit', $configuracao->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Configuracao', 'action' => 'delete', $configuracao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $configuracao->id)]) ?>

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
