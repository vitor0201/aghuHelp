<?php echo $this->Html->script('bootstrap-colorpicker.min.js', ['block' => true]); ?>
<?php echo $this->Html->css('bootstrap-colorpicker.min.css',['block' => true] ); ?>

<div class="panel panel-default criterios">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>

				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $criterio->id], ['escape' => false]) ?></li>
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $criterio->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
			</ul>
		</div>


		<h3>
			KANBAN Cores <small> Alterar </small>
		</h3>
	</div>
    
   <?php

echo $this->Form->create($criterio, [
    'horizontal' => true,
    'id' => 'FormCriterios',
    'cols' => [
        'label' => 2,
        'input' => 4,
        'error' => 6
    ]
]);
?>
    
   
   <div class="panel-body" style="position: relative;">  
        
        <?php
        
        echo $this->Form->input('inicio', [
            'label' => 'Início'
        ]);
        echo $this->Form->input('fim', [
            'label' => 'Fim'
        ]);
        echo $this->Form->input('cor', [
            'label' => 'Cor',
            'id' => 'cp1',
            'class' => 'colorpicker-component'
        ]);
        echo $this->Form->input('especialidade_id', [
            'label' => 'Especialidade',
            'empty' => 'Nenhum'
        ]);
        echo $this->Form->input('unidade_id', [
            'label' => 'Unidade',
            'empty' => 'Nenhum'  
        ]);
        echo $this->Form->input('movimento_id', [
        		'label' => 'Tipos Movimentacao' 
        ]);
        
        ?>
  </div>
	<div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary'])?>
                
   </div>
    <?= $this->Form->end()?>
</div>

<script>
    $(function() {
        $('#cp1').colorpicker({format: 'hex'});
    });
</script>

<script>
$(document).ready(function(){
	$('#FormCriterios').validate({   });
});
</script>


