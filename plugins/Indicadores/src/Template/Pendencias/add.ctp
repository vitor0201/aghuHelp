<div class="panel panel-default pendencias">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left pull-right" aria-hidden="true"></span>&nbsp; '.__('Voltar'), ['action' => 'kanban','controller'=>'Estatisticas'], ['escape' => false]) ?></li>
			</ul>
		</div>


		<h3>
			Pendências <small> Cadastrar </small>
		</h3>
	</div>
    
   <?php

echo $this->Form->create($pendencia, [
    'horizontal' => true,
    'id' => 'FormPendencias',
    'cols' => [
        'label' => 2,
        'input' => 4,
        'error' => 6
    ]
]);
?>
    
   
   <div class="panel-body" style="position: relative;">  
        
        <?php
        echo $this->Form->input('tipo_pendencia_id', [
            'options' => $tipoPendencias->descricao,
            'label' => 'Tipo de Pendência'
        ]);
        
        echo $this->Form->input('observacao', [
            'label' => 'Observação',
            'type' => 'textarea'
        ]);

        // $this->Form->setHorizontal(true);
        
        ?>
  </div>
	<div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary'])?>
                
   </div>
    <?= $this->Form->end()?>
</div>

<script>
$(document).ready(function(){
	$('#FormPendencias').validate({   });
});
</script>
