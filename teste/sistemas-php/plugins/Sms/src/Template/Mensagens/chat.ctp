<?php 
$nome = !empty($paciente) ? $paciente['nome'] : '';
//debug($paciente);

$primeiro_nome = '';
if($nome){
	$primeiro_nome = explode(' ',$nome);
	$primeiro_nome = $primeiro_nome[0];
}
?>

<div class="col-md-6 col-md-offset-3">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Editar Telefone'), ['action' => 'edit', $mensagem->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $mensagem->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3><small><?php echo $fone; ?></small> <b><?php echo $nome?></b></h3>
	</div>
    <div class="panel-body" id="chat_body" style="max-height: 500px;overflow-y: scroll;">  
   
   
  	<?php foreach($msgs as $msg): ?>
  	
  	<?php 
  		$class="left";
  		$class2="right";
  		if($msg->tipo=="R" ) { $class="right"; $class2="left"; }
  	?>
  	
  	<div class="popover <?php echo $class?>" style="max-width:85%; display: block; position:relative; float:<?php echo $class2?>; margin-bottom: 10px"> <div class="arrow"></div><div class="popover-content"><small class="<?php echo $msg->tipo=='R' ? 'text-warning' : 'text-info'; ?>"><b><?php echo $primeiro_nome &&  $msg->tipo=='R' ? $msg->contato .' '.$primeiro_nome : $msg->contato; ?></b>  &nbsp;  <?php echo substr($msg->data_hora,0,16); ?></small> <p style="font-size: 16px; margin:5px 0 0 0"><?php echo $msg->texto; ?></p> </div> </div>
  	<div class="clearfix"></div>
  	<!-- 
  	<div class="well well-sm">
  		<div class="">
	  		
	  			<div class="<?php if($msg->tipo=="R")echo "text-right"; ?>">
		  			<small><b><?php echo $msg->contato; ?></b> <i> &nbsp; <span class="glyphicon glyphicon-time"></span> <?php echo $msg->data_hora; ?></i></small>
		  			
		  			<div class="clearfix" style="margin-bottom: 5px;"></div>
		  			
		  			<span style="font-size: 17px"><b><?php echo $msg->texto; ?></b></span>
		  			<div class="clearfix"></div>
	  			</div>
  		</div>
  	</div>
  	 -->
  	<?php endforeach; ?>
	<?php if(!$msgs->count()): ?>
	<center><div class="label label-default">Nenhuma mensagem</div></center>
	<?php endif;?>
		
	</div>
	<div class="panel-footer" style="padding-bottom: 2px" >
	
	<?php echo $this->Form->create($mensagem, ['horizontal' => true, 'id' => 'FormMensagens','url'=>['controller'=>'mensagens','action'=>'add'],
	    		'cols' => [
		    		'label' => 12,
		    		'input' => 12,
		    		'error' => 5
		    	]
			] );
     ?>
   
        <?php
        echo $this->Form->input('ddd', ['label' => false, 'type' => 'hidden','value'=>'' ]);
        echo $this->Form->input('fone', ['label' => false, 'type' => 'hidden', 'value'=>str_replace("+55","",$fone)]);
        
        	$send = $this->Form->button(__('Enviar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']);	
			echo $this->Form->input('texto', ['label'=> false,'type'=>'text', 'required'=>'required','onkeyup'=>"countChar(this)" ,'maxlength'=>160,'prepend'=>$this->Form->button('0/160', ['type'=>'button','id'=>'charNum']),'append'=> [ $send ]]);
        ?>

   
    <?= $this->Form->end() ?>
	
	
	
	</div>
</div>
</div>
<script>
var objDiv = document.getElementById("chat_body");
objDiv.scrollTop = objDiv.scrollHeight;

function countChar(val) {
    var len = val.value.length;
    $('#charNum').text((len)+'/160' );
    
  };

 

</script>


