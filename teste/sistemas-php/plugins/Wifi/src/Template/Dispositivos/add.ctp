<div class="panel panel-default dispositivos">
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
            Dispositivos
            <small>
                        Cadastrar
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

          <?php
          	
          // soma 18 meses
	        $validade =  date('d/m/Y', strtotime ( '+12 month' , strtotime ( date('Y-m-d') ) ) );
          
            echo $this->Form->input('tipo_dispositivo_id', ['options' => $tipoDispositivos]);
            echo $this->Form->input('internauta_id', ['options' => $internautas,'class'=>'select2','empty'=>'--- Escolha ---']);
            echo $this->Form->input('situacao_id', ['label'=>'Situação','options' => $situacoes]);
			echo $this->Form->input('endereco_mac', ['label'=> ' MAC', 'class'=>'mac_address', 'minlength'=>17,'maxlength'=>17]);
			echo $this->Form->input('justificativa', ['label'=> 'Justificativa', 'type'=>'textarea', 'rows'=>2,'maxlength'=>500]);
			echo $this->Form->input('data_recebimento', ['id'=>'DataRecebeId','label' => 'Recebimento Termo', 'prepend'=>$this->Form->button('Hoje', ['type'=>'button', 'onclick'=>"data_hoje()"]),'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
			echo $this->Form->input('data_validade', ['id'=>'DataValidadeId','label' => 'Validade','class'=>'date', 'type' => 'text','prepend'=>$this->Form->button('+12 meses', ['type'=>'button', 'onclick'=>"soma_meses()"]), 'append'=> $this->Html->icon('calendar') ]);
			
			echo $this->Form->input('descricao', ['label'=>'Descrição']);
			echo $this->Form->input('rede_id', ['label'=> 'Interface/Rede', 'options'=>$redes,'empty'=>'--- escolha ---', 'onchange'=>'realoadIP(this)']);
			echo $this->Form->input('endereco_ip', ['id'=>'EnderecoIPId','label'=> 'IP', 'options'=>array(),'empty'=>'--- escolha ---', 'class'=>'select2']);
				
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>

function soma_meses() {
    
    $('#DataValidadeId').val('<?php echo $validade; ?>');
    
}
function data_hoje() {
    
    $('#DataRecebeId').val('<?php echo date('d/m/Y'); ?>');
    
}
$(document).ready(function(){
	$('#FormDispositivos').validate({   });
});

function realoadIP(obj){
	var id = obj.value;
	
	$.ajax({
	    url: "<?php echo $this->Url->build(['plugin'=>'wifi',"controller" => "redes", "action" => "ips",]); ?>/"+id,
	    type: "POST",
	    dataType: "html",
	    data: jQuery('#FormDispositivos').serialize(),
	    beforeSend: function() {
	    	
	    },
	    success: function (response) {
		    
	    	$("#EnderecoIPId").select2("destroy");
	    	$('#EnderecoIPId').html(response);
	    	$("#EnderecoIPId").select2();
	    	
	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	    	
	        swal("Erro!", "Nao foi possível carregar a lista de IPs", "error");
	    }
	});
}


</script>
