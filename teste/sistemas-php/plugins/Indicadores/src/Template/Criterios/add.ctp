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

			</ul>
		</div>


		<h3>
			KANBAN Cores <small> Cadastrar </small>
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
            'label' => 'Início',
            'help' => 'Em minutos',
            'class' => 'integer'
        ]);
        
        echo $this->Form->input('fim', [
            'label' => 'Fim',
            'help' => 'Em minutos',
            'class' => 'integer'
        ]);
        echo $this->Form->input('cor', [
            'label' => 'Cor',
            'id' => 'cp1',
            'class' => 'colorpicker-component'
        ]);
        echo $this->Form->input('especialidade_id', [
            'label' => ' Especialidade',
            'class' => 'select2',
            'empty' => 'Nenhum'
        ]);
        echo $this->Form->input('unidade_id', [
            'label' => 'Unidade',
            'class' => 'select2',
            'empty' => 'Nenhum'
        ]);
        echo $this->Form->input('movimento_id', [
        		'label' => 'Tipos Movimentação',
        		'class' => 'select2',
        		'value' => '16',
        		'onchange' => 'hideSelect(this)'
        ]);
        
        ?>

	</div>
	<div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary'])?>
                
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

<script type="text/javascript">

function hideSelect(i)
{
  	var x = $(i).val();
	console.log(x);
	if (x != 16)
	{
		$( 'select' ).not(i).prop( "disabled", true );
		$( 'select' ).not(i).val("").change();			
	}else
	{
		$( 'select' ).prop( "disabled", false );
	}
}
</script> 
