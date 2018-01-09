<div class="panel panel-default dispositivos">
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
            Dispositivos
            <small>
                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($dispositivo, ['horizontal' => true, 'id' => 'FormDispositivos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        <div class="alert alert-info">Atenção! Após alterar, o dispositivo ficará "pendente" até que o novo termo seja assinado e entregue ao Setor de TI.</div>
        <?php
            echo $this->Form->input('tipo_dispositivo_id', ['options' => $tipoDispositivos, 'label'=>'Dispositivo']);
			echo $this->Form->input('endereco_mac', ['label'=> ' MAC']);
			echo $this->Form->input('justificativa', ['label'=> ' Justificativa', 'type'=>'textarea']);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormDispositivos').validate({   });
});
</script>
