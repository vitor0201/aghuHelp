<div class="panel panel-default tipoPendencias">
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
			Tipo Pendências <small> Cadastrar </small>
		</h3>
	</div>
    
   <?php

echo $this->Form->create($tipoPendencia, [
    'horizontal' => true,
    'id' => 'FormTipo Pendencias',
    'cols' => [
        'label' => 2,
        'input' => 4,
        'error' => 6
    ]
]);
?>
    
   
   <div class="panel-body" style="position: relative;">  
        
        <?php
        
        echo $this->Form->input('descricao', [
            'label' => 'Descrição'
        ]);
        
        echo $this->Form->input('ativo', [
            'label' => 'Ativo',
            'value' => true,
            'checked' => true,
            'hiddenField' => true
        ]);
        
        ?>
  </div>
	<div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary'])?>
   </div>

    <?= $this->Form->end()?>
</div>

<script>
$(document).ready(function(){
	$('#FormTipo Pendencias').validate({   });
});
</script>
