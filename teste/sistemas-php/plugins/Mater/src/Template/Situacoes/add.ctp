<?php echo $this->Html->script('bootstrap-colorpicker.min.js', ['block' => true]); ?>
<?php echo $this->Html->css('bootstrap-colorpicker.min.css',['block' => true] ); ?>

<div class="panel panel-default situacoes">
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
            Situações
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($situacao, ['horizontal' => true, 'id' => 'FormSituacoes',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php





             
					echo $this->Form->input('descricao', ['label'=> ' Descrição']);
				





             
					echo $this->Form->input('ativo', ['label'=> ' Ativo']);
				
        ?>
         <?php 
        echo $this->Form->input('cor_agenda', [
        		'label' => 'Cor na Agenda',
        		'id' => 'cp1',
        		'class' => 'colorpicker-component',
				'append'=>'<div id="setColor" style="width:20px"> &nbsp; </div>'
        		]);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormSituacoes').validate({   });
});

$(function() {
    $('#cp1').colorpicker({format: 'hex'}).on('changeColor', function(e) {
        $('#setColor')[0].style.backgroundColor = e.color.toHex();
    });
});

</script>
