
<div class="situacoes view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $situacao->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $situacao->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Situacao <small><?= h($situacao->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Descricao') ?></th>
            <td><?= h($situacao->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($situacao->id) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Dispositivos" aria-controls="Dispositivos" role="tab" data-toggle="tab"><?= __('Related Dispositivos') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Dispositivos">

	    	<?php if (!empty($situacao->dispositivos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Tipo Dispositivo Id') ?></th>
		                <th><?= __('Internauta Id') ?></th>
		                <th><?= __('Situacao Id') ?></th>
		                <th><?= __('Endereco Mac') ?></th>
		                <th><?= __('Justificativa') ?></th>
		                <th><?= __('Data Cadastro') ?></th>
		                <th><?= __('Data Recebimento') ?></th>
		                <th><?= __('Endereco Ip') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($situacao->dispositivos as $dispositivos): ?>
	            <?php 
	            	$class="";
	            	//if(!$dispositivos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($dispositivos->id) ?></td>
	                <td><?= h($dispositivos->tipo_dispositivo_id) ?></td>
	                <td><?= h($dispositivos->internauta_id) ?></td>
	                <td><?= h($dispositivos->situacao_id) ?></td>
	                <td><?= h($dispositivos->endereco_mac) ?></td>
	                <td><?= h($dispositivos->justificativa) ?></td>
	                <td><?= h($dispositivos->data_cadastro) ?></td>
	                <td><?= h($dispositivos->data_recebimento) ?></td>
	                <td><?= h($dispositivos->endereco_ip) ?></td>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Dispositivos', 'action' => 'view', $dispositivos->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Dispositivos', 'action' => 'edit', $dispositivos->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Dispositivos', 'action' => 'delete', $dispositivos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dispositivos->id)]) ?>

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
