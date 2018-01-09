<?php echo $this->Html->script('bootstrap-colorpicker.min.js', ['block' => true]); ?>
<?php echo $this->Html->css('bootstrap-colorpicker.min.css',['block' => true] ); ?>
<div class="panel panel-default medicos">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $medico->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $medico->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Médicos
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($medico, ['horizontal' => true, 'id' => 'FormMedicos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
         <?php
// debug($medico->disponibilidades);
        			echo $this->Form->input('nome', ['id'=>'MedicoInput','label'=> 'Médico','readonly'=>'readonly','prepend'=>'<i class="medical-medical84"></i>']);
					echo $this->Form->input('crm', ['id'=>'CrmId','label'=> ' CRM', 'readonly'=>'readonly']);
					echo $this->Form->input('residente', ['label'=> ' Residente']);
					echo $this->Form->input('preceptor', ['label'=> ' Preceptor']);
					echo $this->Form->input('ativo', ['label'=> ' Ativo']);
				
            echo $this->Form->input('procedimentos._ids', ['class'=>"select2",'style'=>'width:100%','label'=>'Procedimentos','help'=>'<i>Portifólio de procedimentos</i>','options' => $procedimentos]);
        ?>
        <div class="form-group">
        <label class="control-label col-md-2">Disponibilidade</label>
        
        <div class="col-md-5">
        	
        	<table class="table table-condensed table-bordered">
        		<tr>
        			<th>&nbsp;</th>
        			<?php $dia_semana = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb']?>
        			<?php foreach($dia_semana as $dia): ?>
        			<th class="text-center"><?php echo $dia?></th>
        			<?php endforeach; ?>
        		</tr>
        		<?php $i=0; ?>
        		<?php foreach($periodos as $periodo_id => $periodo): ?>
	        		<tr>
	        				<th style="vertical-align: middle; text-align: center;">
			        			<?php echo $periodo; ?>
			        		</th>
			        	
	        				<?php foreach($dia_semana as $d => $dia): ?>
			        			<td class="text-center">
			        			<?php 
			        			$estaDisponivel = false;
	        					foreach ($medico->disponibilidades as $disponibilidades){
									if(	$disponibilidades['dia_semana']==$d &&  
										$disponibilidades['periodo_id']==$periodo_id &&
										$disponibilidades['ativo']
										){
										$estaDisponivel = true;
										break;
									}
								}
			        			?>
			        			
			        			<?php echo $this->Form->input('Disponibilidades.'.$i.'.medico_id', ['type'=> 'hidden', 'value'=>$medico->id]); ?>
			        			<?php echo $this->Form->input('Disponibilidades.'.$i.'.dia_semana', ['type'=> 'hidden' ,'value'=>$d]); ?>
			        			<?php echo $this->Form->input('Disponibilidades.'.$i.'.periodo_id', ['type'=> 'hidden', 'value'=>$periodo_id]); ?>
			        			<?php 
			        			if($estaDisponivel) {
			        				echo $this->Form->input('Disponibilidades.'.$i.'.ativo', ['type'=> 'checkbox','checked'=>'checked','label'=>false, 'legend'=>false,]);
// 			        				echo 'OK'; 
			        			} 
			        			else {         				
// 									echo "NOK";
			        				echo $this->Form->input('Disponibilidades.'.$i.'.ativo', ['type'=> 'checkbox','label'=>false, 'legend'=>false,]);
			        			}
			        			?>
			        			<?php $i++; ?>
			        			</td>
	        				<?php endforeach;?>
	        		</tr>
        		<?php endforeach; ?>
        	</table>
        </div>
        </div>
         <?php 
        echo $this->Form->input('cor_agenda', [
        		'label' => 'Cor na Agenda',
        		'id' => 'cp1',
        		'class' => 'colorpicker-component',
				'append'=>'<div id="setColor" style="width:20px; background: '.$medico->cor_agenda.'"> &nbsp; </div>'
        		]);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormMedicos').validate({   });
});

$(function() {
    $('#cp1').colorpicker({format: 'hex'}).on('changeColor', function(e) {
        $('#setColor')[0].style.backgroundColor = e.color.toHex();
    });
});

</script>
