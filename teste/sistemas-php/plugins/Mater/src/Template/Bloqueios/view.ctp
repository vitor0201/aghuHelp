<style>
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    background: #ddd;
    color: #ccc;
    cursor: not-allowed;
    
}

</style>
<div class="bloqueios view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading">

			<h3>
				<?php echo $medico->nome?> <small></small>
			</h3>
		</div>
		<div class="">
		
		
		
		
		
		 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  
  <div class="panel panel-default" style="margin: 0;border-bottom: 1px solid #ddd" >
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Disponibilidade
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="">
        
        <?php if (!empty($medico->disponibilidades)): ?>
	    	
	    	<div class="col-md-12">
        	&nbsp;
        	<table class="table  table-bordered">
        		<tr>
        			<th>&nbsp;</th>
        			<?php $dia_semana = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb']?>
        			<?php foreach($dia_semana as $dia => $semana): ?>
        			<th class="text-center"><?php echo $semana; ?></th>
        			<?php endforeach; ?>
        		</tr>
        		<?php $i=0; ?>
        		<?php foreach($periodos as $periodo_id => $periodo): ?>
	        		<tr>
	        				<th style="vertical-align: middle; text-align: center;">
			        			<?php echo $periodo; ?>
			        		</th>
			        		<?php  $d=0; ?>
	        				<?php foreach($dia_semana as $dia => $semana): ?>
	        					<?php
	        					$estaDisponivel = false;
	        					foreach ($medico->disponibilidades as $disponibilidades){
									if(	$disponibilidades['dia_semana']==$dia &&  
										$disponibilidades['periodo_id']==$periodo_id &&
										$disponibilidades['ativo']
										){
										$estaDisponivel = true;
										break;
									}
								}
	        					?>
	        				
			        			<td class="text-center">
			        			<?php if($estaDisponivel): ?>
			        			<div class="icheckbox_square-blue checked" style="cursor: auto;" ></div>
			        			<?php else: ?>
			        			<div class="icheckbox_square-blue " style="cursor: auto;" ></div>
			        			<?php endif;?>
			        			</td>
	        				<?php endforeach;?>
	        		</tr>
        		<?php endforeach; ?>
        	</table>
        </div>
	    	 <?php else: ?>
	    <div class="alert alert-warning">Disponibilidade não cadastrada</div>
	    <?php endif; ?>
	    <div class="clearfix" ></div>
        
      </div>
    </div>
  </div>
  
  <div class="panel panel-default" style="margin: 0;border-bottom: 1px solid #ddd" >
    <div class="panel-heading" role="tab" id="headingZero">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
          Bloqueios de Agenda
        </a>
      </h4>
    </div>
    <div id="collapseZero" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingZero">
      <div class="panel-body">
        <div style="overflow: hidden;">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12	">
							<div id="datetimepicker12"></div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true,
                format: 'DD/MM/YYYY', showClear: false, useCurrent: false, showTodayButton: false,
                disabledDates: [
//                                 moment("12/25/2013"),
//                                 new Date(2013, 11 - 1, 21),
//                                 "11/22/2013 00:53"
					<?php
					$blc = [];
					foreach ( $medico->bloqueios as $bloq ) {
						$blc[] = 'new Date('.$bloq->data->format('Y').','.$bloq->data->format('m')."-1,".$bloq->data->format('d').")";
					}
					echo implode(",", $blc);
					?>
                 ]
            });
           
        });
    </script>
			</div>
      </div>
    </div>
  </div>
  
  </div>
  

			    	
			
		</div>
	</div>
</div>
