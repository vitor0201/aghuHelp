<div class="panel panel-default dispositivos">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link(__('Voltar/Cancelar'), ['controller'=>'internautas','action' => 'dados'], ['escape' => false]) ?></li>
				</ul>
			</div>
	
	
            <h3>
            Dispositivos
            <small>
                        Cadastrar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($dispositivo, ['horizontal' => true, 'id' => 'FormDispositivos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        <?php 
        
        $descubra = '<span data-toggle="tooltip" data-placement="bottom" title="Encontre o MAC de seu aparelho.">Não sabe o MAC </span>'.  $this->Html->icon('question-sign') .' <a href="#"  data-toggle="modal" data-target="#modalMAC" > Clique aqui '.  "</a>";
        
        ?>
        <?php
            echo $this->Form->input('tipo_dispositivo_id', ['options' => $tipoDispositivos, 'label'=>'Aparelho','empty'=>'-- Escolha --']);
            //echo $this->Form->input('internauta_id', ['options' => $internautas]);
            //echo $this->Form->input('situacao_id', ['options' => $situacoes]);
			echo $this->Form->input('endereco_mac', ['help'=>$descubra,'label'=> 'MAC do Aparelho','class'=>'mac_address', 'minlength'=>17,'maxlength'=>17]);
             
			echo $this->Form->input('justificativa', ['label'=> 'Justificativa', 'type'=>'textarea', 'minlength'=>30,'maxlength'=>500]);
				
        ?>
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalMAC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
         <ul class="nav nav-pills ">
        
		  <li role="presentation" class="active"><a href="#primeiro" data-toggle="tab">Android</a></li>
		  <li role="presentation" class=""><a href="#iphone" data-toggle="tab">Iphone</a></li>
		  <li role="presentation"><a href="#segundo" data-toggle="tab">Tablet</a></a></li>
		  <li role="presentation"><a href="#terceiro" data-toggle="tab">Notebook</a></li>
		</ul>
      </div>
      <div class="modal-body" style="padding-bottom: 0">
      
       
       
		
		<p style="margin-top: 5px" class="hidden-xs hidden-sm">MAC é a sigla de Media Access Control. É um endereço único, com 12 dígitos hexadecimais, que identifica a placa de rede do seu aparelho.</p>
		
		<div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="primeiro">
            
            <p style="text-align: center; padding:0">
            <?php echo $this->Html->image('mac01.png',['class'=>"img-responsive"])?>
            <?php //echo $this->Html->image('mac02.png',['width'=>'175'])?>
            <?php //echo $this->Html->image('mac03.png',['width'=>'175'])?>
            </p>
            
        </div>
         <div class="tab-pane" id="iphone">
             <p style="text-align: center; padding: 0"><?php echo $this->Html->image('iphone-mac.jpg',['class'=>"img-responsive"])?></p>
        </div>
        <div class="tab-pane" id="segundo">
             <p style="text-align: center; padding: 0"><?php echo $this->Html->image('ipad-mac.png',['class'=>"img-responsive"])?></p>
        </div>
        <div class="tab-pane" id="terceiro">
             <p style="text-align: center; padding: 0"><?php echo $this->Html->image('mac-pc.png',[ 'class'=>"img-responsive"])?></p>
        </div>
        
   	 </div>
      </div>
      
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	$('#FormDispositivos').validate({   });
});
</script>
