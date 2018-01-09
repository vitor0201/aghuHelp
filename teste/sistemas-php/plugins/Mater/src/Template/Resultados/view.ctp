
<div class="resultados view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $resultado->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $resultado->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Resultado <small><?= h($resultado->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Descricao') ?></th>
            <td><?= h($resultado->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($resultado->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $resultado->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Cirurgias Procedimentos" aria-controls="Cirurgias Procedimentos" role="tab" data-toggle="tab"><?= __('Related Cirurgias Procedimentos') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Cirurgias Procedimentos">

	    	<?php if (!empty($resultado->cirurgias_procedimentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Cirurgia Id') ?></th>
		                <th><?= __('Procedimento Id') ?></th>
		                <th><?= __('Resultado Id') ?></th>
		                <th><?= __('Observacao') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($resultado->cirurgias_procedimentos as $cirurgiasProcedimentos): ?>
	            <?php 
	            	$class="";
	            	//if(!$cirurgiasProcedimentos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($cirurgiasProcedimentos->id) ?></td>
	                <td><?= h($cirurgiasProcedimentos->cirurgia_id) ?></td>
	                <td><?= h($cirurgiasProcedimentos->procedimento_id) ?></td>
	                <td><?= h($cirurgiasProcedimentos->resultado_id) ?></td>
	                <td><?= h($cirurgiasProcedimentos->observacao) ?></td>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'CirurgiasProcedimentos', 'action' => 'view', $cirurgiasProcedimentos->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'CirurgiasProcedimentos', 'action' => 'edit', $cirurgiasProcedimentos->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'CirurgiasProcedimentos', 'action' => 'delete', $cirurgiasProcedimentos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cirurgiasProcedimentos->id)]) ?>

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
