<div class="panel panel-default usuarios">
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
            Usuários
            <small>
                        Cadastrar
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
    
   
   <div  class="panel-body" style="position:relative;">  
        
        <?php
            echo $this->Form->input('sistema_id', ['options' => $sistemas, 'required'=>'required','class'=>'select2a', 'onchange'=>'realoadGroups(this)', 'empty'=>'-- Escolha --']);
			echo $this->Form->input('login', ['id'=>'UsuarioLoginInput','label'=> 'Usuário','readonly'=>'readonly','prepend'=>$this->Html->icon('user'), 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
			echo $this->Form->input('nome', ['id'=>'UsuarioNomeInput','label'=> 'Nome', 'readonly'=>'readonly']);
			echo $this->Form->input('ativo', ['id'=>'UsuarioAtivoInput','label'=> ' ATIVO', 'checked'=>'checked']);

		
            echo $this->Form->input('grupos._ids', ['label'=>'Grupos (perfis)','required'=>'required','options'=>$grupos,'id'=>'UsuarioGruposInput','class'=>'select2']);
        ?>
        
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>



<script>
$(document).ready(function(){
	$('#FormUsuarios').validate({   });
});
</script>


<script type="text/javascript">

var ModalResponse = function () {} ;
function openLookupUser(){
	
	$.ajax({
	    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "usuarios", "action" => "lookup_ldap_users"]); ?>",
	    type: "GET",
	    dataType: "html",
	    beforeSend: function() {
	    	$('#modalDefault').modal('show');
	    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> Carregando ...</div></div>');
	    },
	    success: function (response) {

	    	ModalResponse = function(data) {
		    	$('#UsuarioLoginInput').val(data.login);
		    	$('#UsuarioNomeInput').val(data.nome);
		    	if(data.ativo)
		    		$('#UsuarioAtivoInput').iCheck('check');
		    	else
		    		$('#UsuarioAtivoInput').iCheck('uncheck');

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

$( "#UsuarioLoginInput" ).click(function() {
	openLookupUser();
});

function limparLookupUser() {
	$('#UsuarioLoginInput').val('');
	$('#UsuarioNomeInput').val('');
}




function realoadGroups(obj){
	var id = obj.value;
	
	$.ajax({
	    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "grupos", "action" => "groups",]); ?>/"+id,
	    type: "POST",
	    dataType: "html",
	    data: jQuery('#FormUsuarios').serialize(),
	    beforeSend: function() {
	    	
	    },
	    success: function (response) {
	    	$("#UsuarioGruposInput").select2("destroy");
	    	$('#UsuarioGruposInput').html(response);
	    	$("#UsuarioGruposInput").select2();
	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	    	
	        swal("Erro!", "Nao foi possível carregar a lista de grupos", "error");
	    }
	});
}

</script>
