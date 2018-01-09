<div class="panel panel-default parametros">
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
            Parametros
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($parametro, ['horizontal' => true, 'id'=>'FormParametros',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
        <?php
            //echo $this->Form->input('sistema_id', ['options' => $sistemas]);





             
					echo $this->Form->input('descricao', ['label'=> ' Descrição']);
				





             
					echo $this->Form->input('chave', ['label'=> ' Chave']);
				





             
					echo $this->Form->input('valor', ['label'=> ' Valor', 'type'=>'textarea']);
				



					$tipos = [
						'string'	=> 'string',
						'int'		=> 'int',
						'float'		=> 'float',
						'list'		=> 'list',
						'boolean'	=> 'boolean',
						'textarea'	=> 'textarea',
						'html'		=> 'html'
					];

             
					echo $this->Form->input('tipo', ['label'=> ' Tipo', 'options'=> $tipos ]);
				





             
					echo $this->Form->input('ativo', ['label'=> ' ativo']);
				
            echo $this->Form->input('grupos._ids', ['options' => $grupos, 'class'=>'select2']);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormParametros').validate({   });
});
</script>
