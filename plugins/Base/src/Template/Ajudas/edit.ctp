<div class="panel panel-default ajudas">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $ajuda->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $ajuda->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Ajudas
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($ajuda, ['horizontal' => true, 
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
        <?php





             
					echo $this->Form->input('nome', ['label'=> ' nome']);
				





             
					echo $this->Form->input('conteudo', ['label'=> ' conteudo']);
				
            echo $this->Form->input('parent_id', ['options' => $parentAjudas]);





             
					echo $this->Form->input('ativo', ['label'=> ' ativo']);
				
            echo $this->Form->input('sistema_id', ['options' => $sistemas]);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
	$('#FormAjudas').validate({   });
</script>
