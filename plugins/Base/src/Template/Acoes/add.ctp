<div class="panel panel-default acoes">
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
            Ações
            <small>
                        Cadastrar
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
         	echo $this->Form->input('sistema_id', ['required'=>'required','id'=>'AcaoSistemaId','label'=>'Sistema', 'options'=>$sistemas, 'empty'=>'-- Escolha --', 'onchange'=>'realoadGroups(this)']);
           	echo $this->Form->input('descricao', ['label'=>'Descrição']);
			echo $this->Form->input('prefix', ['label'=> ' Projeto']);
			echo $this->Form->input('controller', ['label'=> 'Controlador']);
			echo $this->Form->input('action', ['label'=> 'Ação']);
			echo $this->Form->input('tipo', ['label'=> 'Tipo', 'options'=>$tipos]);
			echo $this->Form->input('ativo', ['label'=> ' ATIVO', 'checked'=>'checked']);
            echo $this->Form->input('grupos._ids', ['class'=>'select2', 'id'=>'AcaoGruposInput']);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
               &nbsp;&nbsp; <input type="checkbox" name="continuar" checked='checked' value=1 ><small> Continuar cadastrando.</small>
   </div>
    <?= $this->Form->end() ?>
</div>

<script>


function realoadGroups(obj){
	var id = obj.value;
	
	$.ajax({
	    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "grupos", "action" => "groups",]); ?>/"+id,
	    type: "POST",
	    dataType: "html",
	    data: jQuery('#FormAcoes').serialize(),
	    beforeSend: function() {
	    	
	    },
	    success: function (response) {
	    	$("#AcaoGruposInput").select2("destroy");
	    	$('#AcaoGruposInput').html(response);
	    	$("#AcaoGruposInput").select2();
	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	    	
	        swal("Erro!", "Nao foi possível carregar a lista de grupos", "error");
	    }
	});
}

$(document).ready(function(){
	$('#FormAcoes').validate(
			{}	
	);

	realoadGroups($('#AcaoSistemaId'));
	
});


</script>
