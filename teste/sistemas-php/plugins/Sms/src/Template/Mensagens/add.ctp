<div class="panel panel-default mensagens">
	<div class="panel-heading">
	<!-- 
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
									</ul>
			</div>
	 -->
	
            <h3>
            Mensagens
            <small>
                        Enviar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($mensagem, ['horizontal' => true, 'id' => 'FormMensagens',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
   <?php if(!$permite_envio):?>
   		<div class="alert alert-warning"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> O envio de SMS não está temporariamente desativado.</div>
   		</div>
   <?php else: ?>
  
   
        <?php
			echo $this->Form->input('ddd', ['label' => 'DDD', 'options'=>$ddds,'value'=>$ddd ]);
			echo $this->Form->input('fone', ['label' => 'Celular', 'onblur'=>'validaCelular(this)','class'=>'integer','maxlength'=>9,'minlength'=>8,'required'=>'required', 'type' => 'text', 'append'=>$this->Html->icon('phone')]);
			echo $this->Form->input('texto', ['label'=> ' Mensagem','onkeyup'=>"countChar(this)",'help'=>'<span id="charNum">0/160</span> caracteres','type'=>'textarea','maxlength'=>160,'required'=>'required']);
        ?>
        
  </div>
   <div class="panel-footer"> 
               <?= $this->Form->button(__('Enviar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
   </div>
    <?= $this->Form->end() ?>
     <?php endif;?>
</div>

<script>
$(document).ready(function(){
	$('#FormMensagens').validate({   });
});

function validaCelular(obj){
	c1 = obj.value.substring(0, 1);

	if(obj.value.length <=7 )
		return;
	
	if(c1=="") return;
	
	if(c1!="9" && c1!="8" && c1!="7" && c1!="6"){
		obj.value="";
		alert('Telefone celular inválido.'); 
	}
}

function countChar(val) {
    var len = val.value.length;
    $('#charNum').text((len)+'/160' );
    
  };
</script>
