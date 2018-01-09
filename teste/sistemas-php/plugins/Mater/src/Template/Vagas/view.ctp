
<div class="vagas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $vaga->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $vaga->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Vaga <small><?= h($vaga->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Sala') ?></th>
            <td><?= $vaga->has('sala') ? $this->Html->link($vaga->sala->descricao, ['controller' => 'Salas', 'action' => 'view', $vaga->sala->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Usuario Cadastro') ?></th>
            <td><?= h($vaga->usuario_cadastro) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vaga->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Data') ?></th>
            <td><?= h($vaga->data) ?></td>
        </tr>
        <tr>
            <th><?= __('Horario') ?></th>
            <td><?= h($vaga->horario) ?></td>
        </tr>
        <tr>
            <th><?= __('Data Cadastro') ?></th>
            <td><?= h($vaga->data_cadastro) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Agendamentos" aria-controls="Agendamentos" role="tab" data-toggle="tab"><?= __('Related Agendamentos') ?></a></li>
  
  
</ul>
    
    


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane " id="Agendamentos">

	    	<?php if (!empty($vaga->agendamentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Situacao Id') ?></th>
		                <th><?= __('Sala Id') ?></th>
		                <th><?= __('Data Cadastro') ?></th>
		                <th><?= __('Data') ?></th>
		                <th><?= __('Sequencia') ?></th>
		                <th><?= __('Horario') ?></th>
		                <th><?= __('Duracao') ?></th>
		                <th><?= __('Paciente Prontuario') ?></th>
		                <th><?= __('Paciente Nome') ?></th>
		                <th><?= __('Paciente Fone1') ?></th>
		                <th><?= __('Paciente Fone2') ?></th>
		                <th><?= __('Paciente Nascimento') ?></th>
		                <th><?= __('Aih') ?></th>
		                <th><?= __('Observacao') ?></th>
		                <th><?= __('Medico Id') ?></th>
		                <th><?= __('Paciente Sexo') ?></th>
		                <th><?= __('Usuario Cadastro') ?></th>
		                <th><?= __('Vaga Id') ?></th>
		               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($vaga->agendamentos as $agendamentos): ?>
	            <?php 
	            	$class="";
	            	//if(!$agendamentos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($agendamentos->id) ?></td>
	                <td><?= h($agendamentos->situacao_id) ?></td>
	                <td><?= h($agendamentos->sala_id) ?></td>
	                <td><?= h($agendamentos->data_cadastro) ?></td>
	                <td><?= h($agendamentos->data) ?></td>
	                <td><?= h($agendamentos->sequencia) ?></td>
	                <td><?= h($agendamentos->horario) ?></td>
	                <td><?= h($agendamentos->duracao) ?></td>
	                <td><?= h($agendamentos->paciente_prontuario) ?></td>
	                <td><?= h($agendamentos->paciente_nome) ?></td>
	                <td><?= h($agendamentos->paciente_fone1) ?></td>
	                <td><?= h($agendamentos->paciente_fone2) ?></td>
	                <td><?= h($agendamentos->paciente_nascimento) ?></td>
	                <td><?= h($agendamentos->aih) ?></td>
	                <td><?= h($agendamentos->observacao) ?></td>
	                <td><?= h($agendamentos->medico_id) ?></td>
	                <td><?= h($agendamentos->paciente_sexo) ?></td>
	                <td><?= h($agendamentos->usuario_cadastro) ?></td>
	                <td><?= h($agendamentos->vaga_id) ?></td>
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
