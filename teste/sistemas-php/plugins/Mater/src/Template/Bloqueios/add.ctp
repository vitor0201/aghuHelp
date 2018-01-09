<div class="panel panel-default bloqueios">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
									</ul>
			</div>
	
	
            <h3>
            Bloqueios de Agenda
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($bloqueio, ['horizontal' => true, 'id' => 'FormBloqueios',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
					$this->Form->setHorizontal(true);
					echo $this->Form->input('data', ['label' => 'Data', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
					echo $this->Form->input('data_fim', ['help'=>'<b>opcional</b>','label' => 'Data final', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
					
// 					echo $this->Form->input('usuario_cadastro', ['label'=> ' usuario_cadastro']);
// 					echo $this->Form->input('data_cadastro', ['label'=> ' data_cadastro']);
					$this->Form->colSize = ['label' => 2, 'input' => 4, 'error' => 6];
					$this->Form->setHorizontal(true);
					
					echo $this->Form->input('medico_id', ['label'=>'Médico','empty'=>' ','options' => $medicos,'class'=>'select2','style'=>'width:100%']);
					echo $this->Form->input('justificativa', ['label'=> ' Justificativa']);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormBloqueios').validate({   });
});
</script>
