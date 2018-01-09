<div class="panel panel-default usuarios">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $usuario->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $usuario->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Usuários
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($usuario, ['horizontal' => true, 'id'=>'FormUsuarios',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
        
        <?php
            echo $this->Form->input('sistema_id', ['value'=>$usuario->sistema->nome, 'disabled'=>'disabled', 'readOnly'=>'readOnly','class'=>'disabled','type'=>'text', ]);
			echo $this->Form->input('login', ['id'=>'UsuarioLoginInput','label'=> 'Usuário','readonly'=>'readonly', 'disabled'=>'disabled','prepend'=>$this->Html->icon('user')]);
			echo $this->Form->input('nome', ['id'=>'UsuarioNomeInput','label'=> 'Nome', 'readonly'=>'readonly','disabled'=>'disabled']);
			echo $this->Form->input('ativo', ['id'=>'UsuarioAtivoInput','label'=> ' ATIVO']);
				
            echo $this->Form->input('grupos._ids', ['label'=>'Grupos (perfis)','required'=>'required','id'=>'UsuarioGruposInput','options' => $grupos, 'class'=>'select2']);
        ?>
       
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormUsuarios').validate({   });
});
</script>
