<div class="panel panel-default configuracao">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>

			</ul>
		</div>


		<h3>
			Configuracao <small> Novo </small>
		</h3>
	</div>
    
   <?php
			
			echo $this->Form->create ( $configuracao, [ 
					'horizontal' => true,
					'id' => 'FormConfiguracao',
					'cols' => [ 
							'label' => 2,
							'input' => 4,
							'error' => 6 
					] 
			] );
			?>
    
   
   <div class="panel-body" style="position: relative;">  
        
        <?php
								$this->Form->colSize = [ 
										'label' => 2,
										'input' => 2,
										'error' => 4 
								];
// 								$this->Form->setHorizontal ( true );
								echo $this->Form->input ( 'data', [ 
										'label' => 'Data',
										'class' => 'date',
										'type' => 'text',
										'append' => $this->Html->icon ( 'calendar' ) 
								] );
								?>
								<script>
								$('#data').datetimepicker({
									format: '01/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true ,
									maxDate: new Date()
								});
								</script>
								<?php
								
								echo $this->Form->input ( 'valor', [ 
										'label' => ' Valor' 
								] );
								
								echo $this->Form->input ( 'indicador_id', [ 
										'options' => $indicadores 
								] );
								?>
  </div>
	<div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormConfiguracao').validate({   });
});
</script>
