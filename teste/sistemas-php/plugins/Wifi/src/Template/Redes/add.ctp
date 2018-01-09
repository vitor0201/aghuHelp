<div class="panel panel-default redes">
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
            Redes
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($rede, ['horizontal' => true, 'id' => 'FormRedes',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 6,
		    		'error' => 4
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php

            
					echo $this->Form->input('nome', ['label'=> 'Nome/Label']);
					echo $this->Form->input('faixa_ip', ['label'=> 'Faixa IP']);
 					echo $this->Form->input('conteudo', ['label'=> 'Cont.Arquivo/DHCP', 'type'=>'textarea','rows'=>12,'style'=>'font-family:courier;font-size:12px']);
 					echo $this->Form->input('ativo', ['label'=> ' Ativo']);
				
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormRedes').validate({   });
});
</script>
