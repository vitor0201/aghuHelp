<?php 
use Cake\I18n\Time;
?>
<style>

td .form-group {
margin: 6px 0 0 0;
}
.form-group{
clear:both;
}
</style>

<div class="panel panel-default agendamentos">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Mapa'), ['action' => 'index'], ['escape' => false]) ?></li>
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-calendar pull-right" aria-hidden="true"></span>&nbsp; '.__('Agenda'), ['action' => 'calendar'], ['escape' => false]) ?></li>
				
			</ul>
		</div>


		<h3>
			Agendamentos <small> Cadastrar </small>
		</h3>
	</div>
    
   <?php
   
   $now = Time::now();
   $hoje = $now->format('Ymd');
   $data = $vaga->data->format('Ymd');
    
   $situacoes = $situacoes->toArray();
    
   if($data < $hoje ) {
   
   	unset($situacoes[2]);	// Remove a opção "AGENDADA" para cirurgias que ja aconteceram.
   	unset($situacoes[5]);	// Remove a opção "REMARCADA" para cirurgias que ja aconteceram.
   	
   }
   
   	if($data > $hoje){
		unset($situacoes[1]);
		unset($situacoes[5]);
		unset($situacoes[4]);
	}
			
echo $this->Form->create ( $agendamento, [ 
					'inline' => false,
					'id' => 'FormAgendamentos',
					'cols' => [ 
							'label' => 2,
							'input' => 4,
							'error' => 6 
					] 
			] );

// debug($agendamento);

			?>
    
   
   <div class="panel-body" style="position: relative;">
		<div class="col-md-2">
        	<?php 
        	if($data > $hoje)
        		echo $this->Form->input('situacao_id', ['value'=>2,'required'=>'required','label'=>'Situação','options' => $situacoes, 'class'=>'']); 
        	else 
        		echo $this->Form->input('situacao_id', ['value'=>1,'required'=>'required','label'=>'Situação','options' => $situacoes, 'class'=>'']);
        	?>
        </div>
		<div class="col-md-2	">
        	<?php echo $this->Form->input('data', ['disabled'=>'disabled','readOnly'=>'readOnly','id'=>'DataId','label' => 'Data', 'class'=>'', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]); ?>
        </div>
		<div class="col-md-2">
         <?php echo $this->Form->input('horario', ['disabled'=>'disabled','readOnly'=>'readOnly','label' => 'Horário', 'class'=>'', 'type' => 'text', 'append'=>$this->Html->icon('time')]); ?>
        </div>
		
		
		<div class="col-md-2">
        <?php   echo $this->Form->input('sala_id', ['disabled'=>'disabled','readOnly'=>'readOnly','label'=>'Sala','options' => $salas]); ?>
 		</div>
		
        <div class="col-md-2">
        <?php echo $this->Form->input('duracao', ['label' => 'Duração', 'class'=>'time', 'type' => 'text', 'append'=>$this->Html->icon('time')]); ?>
        </div>
		<div class="clearfix"></div>
		
		<div class="col-md-6">
		<?php
									echo $this->Form->input ( 'solicitante_id', [ 
											'label' => 'Preceptor Solicitante',
											'class' => 'select2',
											'style' => 'width:100%',
											'id' => 'MedicoSolicitanteID',
											'empty' => '',
											'options' => $preceptor ,
											'required'=>'required',
											'empty' =>' '
									] );
		?>
									
         <?php
									echo $this->Form->input ( 'medico_id', [ 
											'label' => 'Preceptor',
											'class' => 'select2',
											'style' => 'width:100%',
											'id' => 'MedicoId',
											'empty' => '',
											'options' => $preceptor ,
											'required'=>'required',
											'append' => '<span style="cursor:pointer" onclick="abrirAgenda()"><span class="glyphicon glyphicon-calendar"></span></span>',
											'empty' =>' '
									] );
									?>
											
									
									<?php
									
echo $this->Form->input ( 'medicos._ids', [ 
											'class' => "select2",
											'style' => 'width:100%',
											'label' => 'Residente Solicitante',
											'options' => $residentes 
									] );
									?>
									
         </div>
        
         <div class="col-md-6">
		<?php 
		echo $this->Form->input('portifolio', ['id'=>'PortifolioId','label'=>'Portifólio (procedimentos)','options'=>[], 'size'=>5, 'onchange'=>'inserirProcedimento(this)']);
		?>
		</div>
		
		<div class="clearfix"></div>
		<hr />
		<?php
		// echo $this->Form->input('periodo_id');
		// $this->Form->setHorizontal(true);
		//echo $this->Form->input('data_cadastro', ['label' => 'data_cadastro', 'class'=>'datetime', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
		// echo $this->Form->input('dia_semana', ['label'=> ' dia_semana']);
		
		?>
				<div class="col-md-3">
				<?php  echo $this->Form->input('paciente_prontuario', ['id'=>'PacienteInput','label'=> 'Prontuário','readonly'=>'readonly','prepend'=>'<i class="medical-health3"></i>', 'append'=>[$this->Form->button($this->Html->icon('remove'), ['type'=>'button', 'onclick'=>"limparLookupPacientes()"]),$this->Form->button($this->Html->icon('search'), ['type'=>'button', 'onclick'=>"openLookupPacientes()"])]]); ?>
				</div>
		<div class="col-md-3">
				<?php  echo $this->Form->input('paciente_nome', ['id'=>'PacienteNome','label'=> ' Paciente', 'readOnly'=>'readOnly']); ?>
				</div>
		<div class="col-md-2">
				<?php  echo $this->Form->input('paciente_nascimento', ['id'=>'PacienteNascimento','label'=> 'Dt. Nasc.', 'readOnly'=>'readOnly']); ?>
				</div>
		<div class="col-md-2">
				<?php  echo $this->Form->input('paciente_fone1', ['id'=>'PacienteFone1','label'=> 'Fone', 'readOnly'=>'readOnly']); ?>
				</div>
		<div class="col-md-2">
				<?php  echo $this->Form->input('paciente_fone2', ['id'=>'PacienteFone2','label'=> 'Fone', 'readOnly'=>'readOnly']); ?>
				<?php  echo $this->Form->input('paciente_sexo', ['id'=>'PacienteSexo','label'=> false,'type'=>'hidden', 'readOnly'=>'readOnly']); ?>
				</div>
		<div class="clearfix"></div>
		<hr />
		
		<div class="col-md-4">
       			<?php echo $this->Form->input('caso_clinico', ['label'=> ' Caso Clínico','type'=>'textarea','rows'=>4]); ?>
       	</div>
       	<div class="col-md-4">
       			<?php echo $this->Form->input('observacao_internacao', ['label'=> ' Observação/Internação','type'=>'textarea','rows'=>4]); ?>
       	</div>
       	<div class="col-md-4">
       			<?php echo $this->Form->input('material_especial', ['label'=> 'Material Especial','type'=>'textarea','rows'=>4]); ?>
       	</div>

			<div class="col-md-4">
       			<?php echo $this->Form->input('aih', ['label'=> ' AIH']); ?>
       			</div>
		
		<div class="col-md-12 column">
		
		<div class="clearfix"></div>
		<br />
			
			<table class="table  table-bordered table-condensed table-hover" id="tab_logic">
				<thead>
					<tr >
						
						<th class="active" width="400px">
							Procedimentos
						</th>
						<th class="active">
							Resultado/Motivos
						</th>
						
						<th class="active" width="180px">
							Observação
						</th>
						<th width="60px" class="active text-center">
						<a id="add_row" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span></a>
						</th>
					</tr>
					
				</thead>
				<tbody>
					<tr id='addr' style="display:none;visibility: false">
						
						<td width="300px">
						<?php echo $this->Form->input('procedimeto', ['class'=>'procedimento','required'=>'required','style'=>'width:100%','id'=>'procedimento','label'=> false, 'options'=>$procedimentos,'empty'=>' ']) ?>
						
						</td>
						<td>
						<?php echo $this->Form->input('resultado', ['class'=>'resultado','style'=>'width:100%','value'=>60,'id'=>'resultado','label'=> false, 'options'=>$resultados]) ?>
						   
						<?php echo $this->Form->input('motivo', ['class'=>'motivo','multiple'=>'multiple','style'=>'width:100%; margin-top:5px;','id'=>'motivo','label'=> false, 'options'=>$motivos,'empty'=>' ']) ?>
					
						</td>
						<td width="180px">
						<?php echo $this->Form->input('observacao', ['class'=>'observacao','style'=>'width:100%;','rows'=>3,'type'=>'textarea','id'=>'observacao','label'=> false]) ?>
						</td>
						<td width="60px" class="text-center">
						<a id="add_row" class="btn btn-danger btn-xs" onclick="delete_row(this)"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
					<?php 
					$i=0;
					if(isset($agendamento->cirurgias_procedimentos) && count($agendamento->cirurgias_procedimentos)):
					
					foreach($agendamento->cirurgias_procedimentos as $proc) :
					?>
					<tr id='addr<?php echo $i; ?>' style="">
						
						<td width="300px">
						<?php echo $this->Form->input('cirurgias_procedimentos.'.$i.'.procedimento_id', ['id'=>'cirurgias_procedimentos.'.$i.'.procedimento_id','value'=>$proc->procedimento_id,'required'=>'required', 'style'=>'width:100%','id'=>'procedimento','label'=> false, 'options'=>$procedimentos,'empty'=>' ','class'=>'select2 procedimento']) ?>
						
						</td>
						<td>
						<?php echo $this->Form->input('cirurgias_procedimentos.'.$i.'.resultado_id', ['id'=>'cirurgias_procedimentos.'.$i.'.resultado_id','value'=>$proc->resultado_id, 'style'=>'width:100%','id'=>'resultado','label'=> false, 'options'=>$resultados,'empty'=>' ', 'class'=>'select2 resultado']) ?>
						<?php echo $this->Form->input('cirurgias_procedimentos.'.$i.'.motivos._ids', ['id'=>'cirurgias_procedimentos.'.$i.'.motivo_id','value'=>$proc->motivo_id, 'multiple'=>'multiple', 'style'=>'width:100%','id'=>'resultado','label'=> false, 'options'=>$motivos,'empty'=>' ', 'class'=>'select2 motivo']) ?>
					
						</td>
						<td width="180px">
						<?php echo $this->Form->input('cirurgias_procedimentos.'.$i.'.observacao', ['id'=>'cirurgias_procedimentos.'.$i.'.observacao','rows'=>3,'type'=>'textarea','class'=>'observacao','value'=>$proc->observacao,'style'=>'width:100%','id'=>'observacao','label'=> false]) ?>
						</td>
						<td width="60px" class="text-center">
						<a id="add_row" class="btn btn-danger btn-xs" onclick="delete_row(this)"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
					<?php $i++; endforeach;?>
					<?php endif;?>
                  
				</tbody>
			</table>
		</div>
		

</div>
<div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar ...'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary'])?>
                
   </div>
<?= $this->Form->end()?>
</div>

<script>
$(document).ready(function(){
	$('#FormAgendamentos').validate({   });

});


$(document).ready(function(){
    var i= <?php echo $i; ?>;
   $("#add_row").click(function(){

	   
	   var $tr    = $('#addr');
	   var $clone = $tr.clone();
// 	   $clone.find(':text').val('');
	   
// 	   $tr.find('tr:last').after($clone);

		$("#tab_logic tr:last").after($clone);
	   
	   $clone.find('#procedimento').attr('id','cirurgias_procedimentos.'+i+'.procedimento_id').attr('name','cirurgias_procedimentos['+i+'][procedimento_id]').select2();
	   $clone.find('#resultado').attr('id','cirurgias_procedimentos.'+i+'.resultado_id').attr('name','cirurgias_procedimentos['+i+'][resultado_id]').select2({ placeholder: "Resultado"});
	   $clone.find('#motivo').attr('id','cirurgias_procedimentos.'+i+'.motivos._ids').attr('name','cirurgias_procedimentos['+i+'][motivos][_ids][]').select2({ placeholder: "Motivos ..."});
	   $clone.find('#observacao').attr('id','cirurgias_procedimentos.'+i+'.observacao').attr('name','cirurgias_procedimentos['+i+'][observacao]');
	   $clone.find('#addr').attr('id','addr'+i);
		  
	   $clone.show();

    i++; 

});

   <?php if($i==0):?>
   $("#add_row").click();
   <?php endif;?>

});

function delete_row(btn){
	var rowCount = $('#tab_logic tr').length;
	if(rowCount>3){

		   swal({
			   	title: "",
	              text: "Confirma a remoção?",
                 showCancelButton: true,
                 confirmButtonColor: "#DD6B55",
                 confirmButtonText: "Sim",
                 cancelButtonText: "Não",
                 closeOnConfirm: true
             }, function (isConfirm) {
                 if (!isConfirm) return;
                 $(btn).closest("tr").remove();
             });
	}
	else {
		toastr["error"]("Informe pelo menos um procedimento.") ;
	}
}


function abrirAgenda(){
	var id = $("#MedicoId").val();
	if(!id){
		toastr["error"]("Escolha um médico.") ;
		return ;
	}
	jQuery.ajax({
		    url: "<?php echo $this->Url->build(['plugin'=>'mater',"controller" => "bloqueios", "action" => "view"]); ?>/"+id,
		    type: "GET",
	        async: true,
	        cache: false,
		    beforeSend: function() {
		    	$('#modalDefault').modal('show');
		    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> Carregando ...</div></div>');
		    },
		    success: function (response) {

		    	console.log(response);
		    	$('#modalDefaultDialog').html(response);
		    	
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		    	$('#modalDefault').modal('hide');
		    	toastr["error"]("Não foi possível carregar a agenda do médico.") ;
		    }
		});
	}

function openLookupPacientes(){
	
	jQuery.ajax({
		    url: "<?php echo $this->Url->build(['plugin'=>'base',"controller" => "integracoes", "action" => "pacientes"]); ?>",
		    type: "GET",
	        async: true,
	        cache: false,
		    beforeSend: function() {
		    	$('#modalDefault').modal('show');
		    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> Carregando ...</div></div>');
		    },
		    success: function (response) {

		    	ModalResponse = function(data) {
			    	console.log(data);
			    	$('#PacienteInput').val(data.prontuario);
			    	$('#PacienteNome').val(data.nome);
			    	$('#PacienteNascimento').val(data.data_nascimento);
			    	$('#PacienteFone1').val(data.fone_residencial);
			    	$('#PacienteFone2').val(data.fone_recado);
			    	$('#PacienteSexo').val(data.sexo);
			    	

			    	$('#modalDefault').modal('hide');
		    	};
		    	
		    	$('#modalDefaultDialog').html(response);
		    	
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		    	$('#modalDefault').modal('hide');
		    	toastr["error"]("Não foi possível carregar a listagem.") ;
		    }
		});
	}


	$( "#PacienteInput" ).click(function() {
		openLookupPacientes();
	});

	function limparLookupPacientes() {
		$('#PacienteInput').val('');
    	$('#PacienteNome').val('');
    	$('#PacienteNascimento').val('');
    	$('#PacienteFone1').val('');
    	$('#PacienteFone2').val('');
    	$('#PacienteSexo').val('');
	}

	
	 $('#MedicoId').on("change", function(e) {
// 	       alert("you selected :" + $(this).val());
	       realoadPortifolio($(this).val());
	   });
	
	function realoadPortifolio(id){
// 		var id = obj.value;
		if(!id) return;
		
		$.ajax({
		    url: "<?php echo $this->Url->build(['plugin'=>'mater',"controller" => "medicos", "action" => "portifolio",]); ?>/"+id,
		    type: "POST",
		    dataType: "html",
		    data: jQuery('#FormAgendamentos').serialize(),
		    beforeSend: function() {
		    	
		    },
		    success: function (response) {
		    	$('#PortifolioId').html(response);
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		        swal("Erro!", "Nao foi possível carregar o portifólio do médico.", "error");
		    }
		});
	}

	
	
	function inserirProcedimento(obj){
		  swal({
              title: "",
              text: "Deseja inserir este procedimento?",
              showCancelButton: true,
              confirmButtonColor: "#5cb85c",
              confirmButtonText: "Sim",
              cancelButtonText: "Não",
              closeOnConfirm: true
          }, function (isConfirm) {
              if (!isConfirm) return;
              _insertProcedimento(obj.value);
              toastr["success"]("Procedimento inserido na lista.") ;
              
          });
		
	}
	
	function _insertProcedimento(value){
		var proced = $("#tab_logic tr:last").find('.procedimento');
		console.log(proced);
// 		return;
 		if(proced.val()==""){
			
 			_setProcedimento(proced, value);
 		}
 		else{
			$("#add_row").click();
			var proced = $("#tab_logic tr:last").find('.procedimento');
// 			console.log(proced);
			_setProcedimento(proced, value)
 		}
	}
	function _setProcedimento(proc, value){
		$(proc).select2("destroy");
		proc.val(value);
		$(proc).select2();
	}

	realoadPortifolio($("#MedicoId").val());
</script>
