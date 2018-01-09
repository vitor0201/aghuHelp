<div class="panel panel-default internautas">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $internauta->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $internauta->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Internautas
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($internauta, ['horizontal' => true, 'id' => 'FormInternautas',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
         <?php
	 
	 	echo $this->Form->input('login', ['id'=>'UsuarioLoginInput','label'=> 'Usuário','readonly'=>'readonly']);
	 	echo $this->Form->input('nome', ['id'=>'UsuarioNomeInput','label'=> 'Nome', 'readonly'=>'readonly']);
	 
	 	//echo $this->Form->input('nome', ['label' => 'Nome', 'type' =>'text', 'minlength' => '5', 'readonly'=>'readonly']);
		 
	 	echo $this->Form->input('cpf', ['label' => 'CPF', 'class' => 'cpf']);
		 
		 echo $this->Form->input('data_nascimento', ['label' => 'Data Nascimento', 'class' => 'date','required'=>'required', 'type' => 'text', 'append' => $this->Html->icon('calendar')]);
		  
		 
		 echo $this->Form->input('email', ['label' => ' Email', 'type' =>'email', 'minlength' => '5']);
		 echo $this->Form->input('setor', ['label' => ' Setor']);
		 
	        
	     echo $this->Form->input('contato', ['label' => 'Ramal/Celular']);
	     
	     echo $this->Form->input('quantidade_dispositivos', ['label' => 'Qtd. Dispositivos','class'=>'int','required'=>'required', 'maxlength'=>2]);
     ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormInternautas').validate({   });
});
</script>
