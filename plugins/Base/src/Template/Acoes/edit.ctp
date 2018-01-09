<div class="panel panel-default acoes">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $acao->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $acao->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Ações
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($acao, ['horizontal' => true, 'id' => 'FormAcoes',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
         <?php
         	echo $this->Form->input('sistema_id', ['label'=>'Sistema', 'options'=>$sistemas,'disabled'=>'disabled', 'readonly'=>'readonly']);
            echo $this->Form->input('descricao', ['label'=>'Descrição']);
			echo $this->Form->input('prefix', ['label'=> ' Projeto']);
			echo $this->Form->input('controller', ['label'=> 'Controlador']);
			echo $this->Form->input('action', ['label'=> 'Ação']);
			echo $this->Form->input('tipo', ['label'=> 'Tipo', 'options'=>$tipos]);
			echo $this->Form->input('ativo', ['label'=> ' ATIVO']);
            echo $this->Form->input('grupos._ids', ['options' => $grupos, 'class'=>'select2']);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
	$('#FormAcoes').validate({   });
</script>
