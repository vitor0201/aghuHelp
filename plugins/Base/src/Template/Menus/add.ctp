<div class="panel panel-default menus">
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
            Menus
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($menu, ['horizontal' => true, 'id'=>'FormMenus',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        <?php
        echo $this->Form->input('sistema_id', ['options' => $sistemas,'value'=>$sistema_id,'empty'=>'---','id'=>'MenuSistemaId']);
        echo $this->Form->input('descricao', ['label'=> ' Descrição']);
        //echo $this->Form->input('prefix', ['label'=> ' Projeto']);
		//echo $this->Form->input('controller', ['label'=> ' Controller']);
		
		echo $this->Form->input('parent_id', ['label'=>'Filho de:','options' => $parentMenus, 'escape'=>false, 'empty'=>'-- Raiz --']);
		echo $this->Form->input('ativo', ['label'=> ' ATIVO', 'checked'=>'checked']);
		echo $this->Form->input('acao_id', ['label'=>'Ação','options' => $acoes, 'class'=>'select2', 'empty'=>'-- Nenhuma --']);
		echo $this->Form->input('action', ['label'=> ' URL']);
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormMenus').validate({   });
});

$('#MenuSistemaId').change(function() {
    window.location = '<?php echo $this->Url->build(['action'=>'add']) ?>/' + $(this).val();
});
</script>
