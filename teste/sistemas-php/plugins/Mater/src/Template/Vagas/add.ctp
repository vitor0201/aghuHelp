<div class="panel panel-default vagas">
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
            Vagas
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($vaga, ['horizontal' => true, 'id' => 'FormVagas',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
            echo $this->Form->input('sala_id', ['options' => $salas]);
// 					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
// 					$this->Form->setHorizontal(true);
					echo $this->Form->input('data', ['label' => 'Data', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
					echo $this->Form->input('data_final', ['label' => 'Data Final','help'=>"<i>(opcional)</i>", 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
					echo $this->Form->input('horario', ['label' => 'Horário', 'class'=>'time', 'type' => 'text', 'append'=>$this->Html->icon('time')]);
					
// 					$this->Form->colSize = ['label' => 2, 'input' =>4 , 'error' => 6];
// 					$this->Form->setHorizontal(true);
					echo $this->Form->input('dias', ['label'=>'Dias da semana','help'=>'<i>(opcional)</i> Deixe vazio para incluir todos os dias','class'=>'select2','multiple'=>'multiple','options'=>['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado']]);
					
					
					
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormVagas').validate({   });
});
</script>
