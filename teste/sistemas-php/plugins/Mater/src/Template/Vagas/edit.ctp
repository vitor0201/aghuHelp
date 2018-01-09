<div class="panel panel-default vagas">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $vaga->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $vaga->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Vagas
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($vaga, ['horizontal' => true, 'id' => 'FormVagas',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
            echo $this->Form->input('sala_id', ['options' => $salas]);
					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
					$this->Form->setHorizontal(true);
					echo $this->Form->input('data', ['label' => 'data', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);






						$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('horario', ['label' => 'horario', 'class'=>'time', 'type' => 'text', 'append'=>$this->Html->icon('time')]);
				


             
					echo $this->Form->input('horario', ['label'=> ' horario']);
				

				$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
				$this->Form->setHorizontal(true);
				echo $this->Form->input('data_cadastro', ['label' => 'data_cadastro', 'class'=>'datetime', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);




             
					echo $this->Form->input('data_cadastro', ['label'=> ' data_cadastro']);
				





             
					echo $this->Form->input('usuario_cadastro', ['label'=> ' usuario_cadastro']);
				
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormVagas').validate({   });
});
</script>
