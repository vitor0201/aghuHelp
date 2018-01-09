<?php 
$class="animated bounceInLeft";
if(isset($erro))
	$class="animated shake";
?>

<div class="col-md-4 col-md-offset-4" >
<div class="panel panel-default usuarios <?php echo $class;?> " id="PanelLoginId">
	<div class="panel-heading">
            <h3>
            Usuários
            <small>
                        login
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create(null, [ 'id'=>'FormUsuarios','autocomplete'=>"off",
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 10,
		    		'error' => 4
		    	]
			] );
     ?>
    
   
   <div  class="panel-body" style="position:relative;">  
        
        <?php
			echo $this->Form->input('login', ['id'=>'UsuarioLoginInput','required'=>'required','placeholder'=>'login','label'=> false,'prepend'=>$this->Html->icon('user')]);
			echo $this->Form->input('senha', ['nocache'=>"nocache",'id'=>'UsuarioSenhaInput','required'=>'required','placeholder'=>'senha','type'=>'password','label'=> false, 'prepend'=>$this->Html->icon('lock')]);
        ?>
        
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Fazer Login'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary btn-block']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormUsuarios').validate({ 
		invalidHandler: function(event, validator) {
			//alert('nao');
			$('#PanelLoginId').removeClass('<?php echo $class; ?>');
			$('#PanelLoginId').addClass('animated shake');
		}
	 });
	$("form :input").attr("autocomplete", "off");
});
</script>


</div>