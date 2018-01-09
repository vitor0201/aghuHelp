<ul class="nav nav-pills nav-justified">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
</ul>
<br/>
<br/>
<br/>

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
            Exemplos
            <small>
                        Integração AGHU, LDAP/AD
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create(null, ['horizontal' => true, 'id'=>'FormExemplo',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div  class="panel-body" style="position:relative;">  
        
        <?php
           echo $this->Form->input('login', ['id'=>'UsuarioLoginInput','label'=> 'Usuário LDAP/AD','readonly'=>'readonly','prepend'=>$this->Html->icon('user'), 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
           echo $this->Form->input('paciente', ['id'=>'PacienteInput','label'=> 'Paciente','readonly'=>'readonly','prepend'=>'<i class="medical-health3"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupPacientes()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupPacientes()"])]]);
           echo $this->Form->input('paciente', ['id'=>'PacienteInput','label'=> 'Paciente Internado','readonly'=>'readonly','prepend'=>'<i class="medical-health3"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupPacientes()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupPacientes()"])]]);
           echo $this->Form->input('medico', ['id'=>'MedicoInput','label'=> 'Médico','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupMedicos()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupMedicos()"])]]);
           echo $this->Form->input('medico_esp', ['id'=>'MedicoInput','label'=> 'Médico/Especialidade','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
           echo $this->Form->input('especialidade', ['id'=>'MedicoInput','label'=> 'Especialidades','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
           echo $this->Form->input('unidades', ['id'=>'MedicoInput','label'=> 'Unid. Funcionais','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
           echo $this->Form->input('cids', ['id'=>'MedicoInput','label'=> 'CID','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
           echo $this->Form->input('procedimentos', ['id'=>'ProcedimentoInput','label'=> 'Procedimentos','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupProcedimentos()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupProcedimentos()"])]]);
            
           echo $this->Form->input('leitos', ['id'=>'MedicoInput','label'=> 'Leitos','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupUser()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupUser()"])]]);
            
         ?>
        
  </div>
   <div class="panel-footer"> 
               <?php // $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
               Salvar...
                
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
	    //dataType: "html",
        async: true,
        cache: false,
	    beforeSend: function() {
	    	$('#modalDefault').modal('show');
	    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> Carregando ...</div></div>');
	    },
	    success: function (response) {

	    	ModalResponse = function(data) {
		    	$('#UsuarioLoginInput').val(data.login);
		    	//$('#UsuarioNomeInput').val(data.nome);
		    	

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


function openLookupPacientes(){
	
jQuery.ajax({
	    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "integracoes", "action" => "pacientes"]); ?>",
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
		    	$('#PacienteInput').val(data.nome);
		    	//$('#UsuarioNomeInput').val(data.nome);

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

$( "#PacienteInput" ).click(function() {
	openLookupPacientes();
});

function limparLookupPacientes() {
	$('#PacienteInput').val('');
	//$('#UsuarioNomeInput').val('');
}


function openLookupMedicos(){
	
	jQuery.ajax({
		    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "integracoes", "action" => "medicos"]); ?>",
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
			    	$('#MedicoInput').val(data.nome);
			    	//$('#UsuarioNomeInput').val(data.nome);

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

	$( "#MedicoInput" ).click(function() {
		openLookupMedicos();
	});

	function limparLookupMedicos() {
		$('#MedicoInput').val('');
		//$('#UsuarioNomeInput').val('');
	}


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
				    	$('#ProcedimentoInput').val(data.descricao);
				    	//$('#UsuarioNomeInput').val(data.nome);

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
			//$('#UsuarioNomeInput').val('');
		}
</script>
