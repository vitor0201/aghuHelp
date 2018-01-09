<?php echo $this->Html->script('fullcalendar.min.js', ['block' => true]); ?>
<?php echo $this->Html->script('full-calendar-pt-br.js', ['block' => true]); ?>
<?php echo $this->Html->css('fullcalendar.min.css',['block' => true] ); ?>
<style>
table {
	margin: 0;
}

.fc-event{
    cursor: pointer;
}
</style>

<div class="row">
	<div class="col-md-3">
		<!-- 
		<div style="margin: 0 0 10px 0">
	<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo agendamento'), ['action' => 'add'], ['escape' => false, 'class'=>'btn btn-primary btn-block'])?>
</div>
 -->

		<div class="panel panel-default">
		<div class="panel-heading">Opções de filtros <div class="signal pull-right" id="loaderCalendar"></div></div>
		<div class="panel-body">
			<div class="col-sm-12" style="margin-bottom: 2px">

					<div style="">
						<div style=" width: 25px; float:left;margin-right:5px; background-color: white; border: 1px solid #27a0c9">&nbsp;&nbsp;</div>Disponível</div>
				</div>
<?php foreach($legendas as $situacao): ?>
<div class="col-sm-12" style="margin-bottom: 2px">

					<div style="">
						<div style=" width: 25px; float:left;margin-right:5px; background-color: <?php echo $situacao->cor_agenda; ?>">&nbsp;&nbsp;</div><?php echo $situacao->descricao; ?> </div>
				</div>
<?php endforeach;?>
<div class="clearfix">&nbsp;</div>
				<div class="col-md-12">
<?php echo $this->Form->input('somente_vagas',['id'=>'SomenteVagas','label'=>false,'empty'=>'Todos', 'options'=>['v'=>'Vaga Disponível','a'=>'Agendamentos']])?>
 <?php echo $this->Form->input('sala_id',['style'=>'width:100%','id'=>'SalaId','label'=>'Sala','class'=>"select2", 'multiple'=>'multiple'])?>
 <?php echo $this->Form->input('situacao_id',['style'=>'width:100%','id'=>'SituacaoId','label'=>'Situação','class'=>"select2", 'multiple'=>'multiple'])?>
 <?php echo $this->Form->input('medico_id',['style'=>'width:100%','id'=>'MedicoId','label'=>'Médico/Preceptor','class'=>"select2", 'multiple'=>'multiple','options'=>$preceptor])?>
 <?php echo $this->Form->input('procedimento_id',['style'=>'width:100%','id'=>'ProcedimentoId','label'=>'Procedimento','class'=>"select2", 'multiple'=>'multiple'])?>
 <?php echo $this->Form->input('paciente_prontuario',['id'=>'ProntuarioPaciente','label'=>'Prontuário',])?>
 
 </div>
			</div>
			<div class="panel-footer">                
                <?php echo $this->Form->button('Buscar', ['id'=>'filtrarCalendar','class' => 'btn btn-primary btn-sm btn-block']); ?>
                
            </div>

		</div>
	</div>
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel panel-body">
				<div id='calendar'></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
   $(document).ready(function() {

	    // page is now ready, initialize the calendar...

	    $('#calendar').fullCalendar({
	        // put your options and callbacks here
	    	header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			
			locale: 'pt-br',
			height: 650,
			eventDurationEditable: false,
// 			eventResourceEditable: false,
			eventStartEditable: false,
			allDaySlot: false,
			defaultDate: '<?php echo $defaultDate; ?>',
			defaultView: 'month',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: false, // allow "more" link when too many events
			events: {
				url: '<?php echo $this->Url->build(['controller'=>'agendamentos','action'=>'eventos.json']);?>',
				error: function() {
// 					$('#script-warning').show();
					toastr["error"]("Falha ao carregar a agenda.") ;
				},
				data: function () { // a function that returns an object
					console.log($('#SomenteVagas')[0].checked);
	                return {
	                    situacao_id: $('#SituacaoId').val(),
	                    sala_id: $('#SalaId').val(),
	                    medico_id: $('#MedicoId').val(),
	                    prontuario: $('#ProntuarioPaciente').val(),
	                    procedimento_id: $('#ProcedimentoId').val(),
	                    somente_vagas: $('#SomenteVagas').val(),
	                };
	            }
			},
			loading: function(bool) {
				$('#loaderCalendar').toggle(bool);
			},
			 eventClick: function(calEvent, jsEvent, view) {
// 					console.log(calEvent.url);

					if(calEvent.url) return;
					
					openLookupEvent(calEvent.id)
			    }
	        
	    });
	    
	    $('#filtrarCalendar').click(function () {
	        $('#calendar').fullCalendar('refetchEvents');
	    });

	   

	});

   function openLookupEvent(id){
		
		jQuery.ajax({
			    url: "<?php echo $this->Url->build(['plugin'=>'mater',"controller" => "agendamentos", "action" => "view"]); ?>/"+id,
			    type: "GET",
		        async: true,
		        cache: false,
			    beforeSend: function() {
			    	$('#modalDefault').modal('show');
			    	$('#modalDefaultDialog').html('<div class="modal-content"><div class="modal-body"> <div class="signal pull-right"></div> Carregando ...</div></div>');
			    },
			    success: function (response) {

			    	/* ModalResponse = function(data) {
				    	console.log(data);
				    	$('#PacienteInput').val(data.prontuario);
				    	$('#PacienteNome').val(data.nome);
				    	$('#PacienteNascimento').val(data.data_nascimento);
				    	$('#PacienteFone1').val(data.fone_residencial);
				    	$('#PacienteFone2').val(data.fone_recado);
				    	$('#PacienteSexo').val(data.sexo);
				    	

				    	$('#modalDefault').modal('hide');
			    	}; */
			    	
			    	$('#modalDefaultDialog').html(response);
			    	
			    },
			    error: function (xhr, ajaxOptions, thrownError) {
			    	$('#modalDefault').modal('hide');
			    	toastr["error"]("Não foi possível exibir o agendamento.") ;
			    }
			});
		}
   </script>