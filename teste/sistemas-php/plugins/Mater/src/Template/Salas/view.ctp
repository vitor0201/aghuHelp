
<div class="salas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $sala->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $sala->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Sala <small><?= h($sala->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Descricao') ?></th>
            <td><?= h($sala->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($sala->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $sala->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Agendamentos" aria-controls="Agendamentos" role="tab" data-toggle="tab"><?= __('Related Agendamentos') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Agendamentos">

	    	<?php if (!empty($sala->agendamentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Periodo Id') ?></th>
		                <th><?= __('Situacao Id') ?></th>
		                <th><?= __('Sala Id') ?></th>
		                <th><?= __('Data Cadastro') ?></th>
		                <th><?= __('Data') ?></th>
		                <th><?= __('Dia Semana') ?></th>
		                <th><?= __('Sequencia') ?></th>
		                <th><?= __('Horario') ?></th>
		                <th><?= __('Duracao') ?></th>
		                <th><?= __('Paciente Prontuario') ?></th>
		                <th><?= __('Prontuario') ?></th>
		                <th><?= __('Paciente Nome') ?></th>
		                <th><?= __('Paciente Fone1') ?></th>
		                <th><?= __('Paciente Fone2') ?></th>
		                <th><?= __('Paciente Nascimento') ?></th>
		                <th><?= __('Aih') ?></th>
		                <th><?= __('Observacao') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($sala->agendamentos as $agendamentos): ?>
	            <?php 
	            	$class="";
	            	//if(!$agendamentos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($agendamentos->id) ?></td>
	                <td><?= h($agendamentos->periodo_id) ?></td>
	                <td><?= h($agendamentos->situacao_id) ?></td>
	                <td><?= h($agendamentos->sala_id) ?></td>
	                <td><?= h($agendamentos->data_cadastro) ?></td>
	                <td><?= h($agendamentos->data) ?></td>
	                <td><?= h($agendamentos->dia_semana) ?></td>
	                <td><?= h($agendamentos->sequencia) ?></td>
	                <td><?= h($agendamentos->horario) ?></td>
	                <td><?= h($agendamentos->duracao) ?></td>
	                <td><?= h($agendamentos->paciente_prontuario) ?></td>
	                <td><?= h($agendamentos->prontuario) ?></td>
	                <td><?= h($agendamentos->paciente_nome) ?></td>
	                <td><?= h($agendamentos->paciente_fone1) ?></td>
	                <td><?= h($agendamentos->paciente_fone2) ?></td>
	                <td><?= h($agendamentos->paciente_nascimento) ?></td>
	                <td><?= h($agendamentos->aih) ?></td>
	                <td><?= h($agendamentos->observacao) ?></td>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Agendamentos', 'action' => 'view', $agendamentos->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Agendamentos', 'action' => 'edit', $agendamentos->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Agendamentos', 'action' => 'delete', $agendamentos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agendamentos->id)]) ?>

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
