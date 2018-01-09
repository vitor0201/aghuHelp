<div class="panel panel-default disponibilidades">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $disponibilidade->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $disponibilidade->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Disponibilidades
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($disponibilidade, ['horizontal' => true, 'id' => 'FormDisponibilidades',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
            echo $this->Form->input('medico_id', ['options' => $medicos]);



						$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('dia_semana', ['label' => 'dia_semana', 'class'=>'integer', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				

             
					echo $this->Form->input('dia_semana', ['label'=> ' dia_semana']);
				
            echo $this->Form->input('periodo_id', ['options' => $periodos]);





             
					echo $this->Form->input('ativo', ['label'=> ' ativo']);
				
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormDisponibilidades').validate({   });
});
</script>
