<?php 

?>
<div class="panel panel-default internautas">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
				
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link(__('Voltar/Cancelar'), ['controller'=>'internautas','action' => 'dados'], ['escape' => false]) ?></li>
				</ul>
			</div>
				
            <h3>
            	Usuário
            <small>
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Seus Dados
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
	 
	 echo $this->Form->input('nome', ['label' => 'Nome', 'type' =>'text', 'minlength' => '5', 'disabled'=>'disabled']);
	 
	 if(!$internauta->id)
	 	echo $this->Form->input('cpf', ['label' => 'Seu CPF', 'class' => 'cpf']);
	 else
	 	echo $this->Form->input('cpf', ['label' => 'Seu CPF', 'class' => 'cpf', 'disabled'=>'disabled', 'readOnly'=>'readOnly']);
	 
	 echo $this->Form->input('data_nascimento', ['label' => 'Data Nascimento', 'class' => 'date', 'type' => 'text', 'append' => $this->Html->icon('calendar')]);
	  
	 
	 echo $this->Form->input('email', ['label' => ' Email', 'type' =>'email', 'minlength' => '5', 'help'=>'<b>Atenção!</b> Você será avisado através do e-mail.']);
	 echo $this->Form->input('setor', ['label' => ' Setor']);
	 
        
        echo $this->Form->input('contato', ['label' => 'Ramal/Celular']);
       
       
        ?>
	</div>
   	<div class="panel-footer"> 
    <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
        
	$(document).ready(function () {
	    $('#FormInternautas').validate({
	        rules: {
	            nome: {
	                required: true,
	          
	            },
	            cpf: {
	                required: true,
	                cpfBR: true            
	            } ,
	            setor:{
	                required: true,
	               
	            },
	             contato:{
	                required: true,
	                
	            },
	            data_nascimento:{
	                required: true,
	                date: true
	            }
	        }
	    });
	});

</script>
