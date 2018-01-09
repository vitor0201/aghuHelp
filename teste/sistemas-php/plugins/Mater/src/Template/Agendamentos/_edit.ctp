<div class="panel panel-default agendamentos">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $agendamento->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $agendamento->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Agendamentos
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($agendamento, ['horizontal' => true, 'id' => 'FormAgendamentos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
          <?php
            echo $this->Form->input('periodo_id', ['options' => $periodos]);
            echo $this->Form->input('situacao_id', ['options' => $situacoes]);
            echo $this->Form->input('sala_id', ['options' => $salas]);
// 				$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
// 				$this->Form->setHorizontal(true);
				echo $this->Form->input('data_cadastro', ['label' => 'data_cadastro', 'class'=>'datetime', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				echo $this->Form->input('data', ['label' => 'data', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				echo $this->Form->input('dia_semana', ['label'=> ' dia_semana']);
				echo $this->Form->input('sequencia', ['label'=> ' sequencia']);
				echo $this->Form->input('horario', ['label'=> ' horario','type'=>'text']);
				echo $this->Form->input('duracao', ['label' => 'duracao', 'class'=>'time', 'type' => 'text', 'append'=>$this->Html->icon('time')]);
				echo $this->Form->input('paciente_prontuario', ['label'=> ' paciente_prontuario']);
				echo $this->Form->input('prontuario', ['label'=> ' prontuario']);
				echo $this->Form->input('paciente_nome', ['label'=> ' paciente_nome']);
				echo $this->Form->input('paciente_fone1', ['label'=> ' paciente_fone1']);
				echo $this->Form->input('paciente_fone2', ['label'=> ' paciente_fone2']);
				echo $this->Form->input('paciente_nascimento', ['label'=> ' paciente_nascimento']);
				echo $this->Form->input('aih', ['label'=> ' aih']);
				echo $this->Form->input('observacao', ['label'=> ' observacao']);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormAgendamentos').validate({   });
});
</script>
