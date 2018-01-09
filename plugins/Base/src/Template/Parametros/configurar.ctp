<div class="panel panel-default parametros">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $parametro->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $parametro->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Parametros
            <small>
                        Configurar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($parametro, ['horizontal' => true, 
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
        <?php
           // echo $this->Form->input('sistema_id', ['options' => $sistemas]);





             
					//echo $this->Form->input('descricao', ['label'=> ' descricao']);
				





             
					//echo $this->Form->input('chave', ['label'=> ' chave']);
				





             
					echo $this->Form->input('valor', ['label'=> ' valor', 'type'=>'textarea']);
				



					$tipos = [
						'string'	=> 'string',
						'int'		=> 'int',
						'float'		=> 'float',
						'list'		=> 'list',
						'boolean'	=> 'boolean',
						'textarea'	=> 'textarea',
						'html'		=> 'html'
					];

             
					//echo $this->Form->input('tipo', ['label'=> ' Tipo', 'options'=> $tipos]);
				



					

             
					//echo $this->Form->input('ativo', ['label'=> ' ATIVO' ]);
				
            // echo $this->Form->input('grupos._ids', ['options' => $grupos]);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
	$('#FormParametros').validate({   });
</script>
