<div class="panel panel-default procedimentos">
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
            Procedimentos
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($procedimento, ['horizontal' => true, 'id' => 'FormProcedimentos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 5,
		    		'error' => 4
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        <?php
					echo $this->Form->input('descricao', ['id'=>'ProcedimentoInput','label'=> 'Procedimento','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupProcedimentos()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupProcedimentos()"])]]);
					echo $this->Form->input('codigo', ['id'=>'CodigoInput','label'=> ' Código', 'readonly'=>'readonly']);
					echo $this->Form->input('ativo', ['id'=>'AtivoInput','label'=> ' Ativo']);
					echo $this->Form->input('sigla', ['label'=> ' Sigla']);
					echo $this->Form->input('descricao2', ['label'=> ' Descrição','id'=>'Descricao2']);
		            echo $this->Form->input('medicos._ids', ['label'=>'Incluir no Portifólio','help'=>'(opcional) Inclui o procedimento no portifólio dos médicos escolhidos','options' => $medicos,'class'=>'select2','style'=>'width:100%']);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormProcedimentos').validate({   });
});


function openLookupProcedimentos(){
	
	jQuery.ajax({
		    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "integracoes", "action" => "procedimentos"]); ?>",
		    type: "GET",
		    //dataType: "html",
	        async: true,
	        cache: false,
		    beforeSend: function() {
		    	$('#modalDefault').modal('show');
		    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> Carregando ...</div></div>');
		    },
		    success: function (response) {

		    	ModalResponse = function(data) {
			    	console.log(data);
			    	$('#ProcedimentoInput').val(data.descricao);
			    	$('#Descricao2').val(data.descricao);
			    	$('#CodigoInput').val(data.codigo);
			    	if(data.situacao=="A")
		    			$('#AtivoInput').iCheck('check');
		    		else
		    			$('#AtivoInput').iCheck('uncheck');

			    	$('#modalDefault').modal('hide');
		    	};
		    	
		    	$('#modalDefaultDialog').html(response);
		    	
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		    	$('#modalDefault').modal('hide');
		        swal("Erro!", "Nao foi possível carregar", "error");
		    }
		});
	}

	$( "#ProcedimentoInput" ).click(function() {
		openLookupProcedimentos();
	});

	function limparLookupProcedimentos() {
		$('#ProcedimentoInput').val('');
		$('#Descricao2').val('');
		//$('#UsuarioNomeInput').val('');
	}

</script>
