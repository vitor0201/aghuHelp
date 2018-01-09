<div class="panel panel-default recebidas">
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
            Recebidas
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($recebida, ['horizontal' => true, 'id' => 'FormRecebidas',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php



						$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('fone', ['label' => 'fone', 'class'=>'integer', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				

             
					echo $this->Form->input('fone', ['label'=> ' fone']);
				





             
					echo $this->Form->input('texto', ['label'=> ' texto']);
				

				$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
				$this->Form->setHorizontal(true);
				echo $this->Form->input('data_hora', ['label' => 'data_hora', 'class'=>'datetime', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);




             
					echo $this->Form->input('data_hora', ['label'=> ' data_hora']);
				
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormRecebidas').validate({   });
});
</script>
