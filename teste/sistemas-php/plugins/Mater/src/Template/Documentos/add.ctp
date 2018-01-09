
<div class="panel panel-default documentos">
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
            Documentos
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($documento, ['horizontal' => true, 'enctype' => 'multipart/form-data','id' => 'FormDocumentos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 6,
		    		'error' => 4
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        
        
        <?php
        $documento->ativo = true;
        
        echo $this->Form->input('titulo', ['label'=> ' Título']);
        ?>
        <div class="clearfix"></div>
        <?php 
        echo $this->Form->input('ativo', ['label'=> ' Ativo']);
        ?>
                <div class="clearfix"></div>
                <?php 
       	echo $this->Form->input('procedimentos._ids', ['id'=>'e1','options' => $procedimentos, 'class' => 'select2', 'style'=>'width:100%','append'=>'<small><input type="checkbox" id="checkbox" > Todos</small>']);
       	?>
       	                <div class="clearfix"></div>
       	                <br/>
       	                <?php 
       	echo  $this->Form->input('upload', ['type' => 'file','label'=>'Arquivo' , 'required'=>'required']);     
				
        ?>

  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormDocumentos').validate({   });
});


$("#checkbox").on("ifChanged", function(){
	
	if(this.checked){
		$("#e1 > option").prop("selected","selected");
        $("#e1").trigger("change");
	}
	else{
		 $("#e1 > option").removeAttr("selected");
      	$("#e1").trigger("change");
	}
	
});




</script>
