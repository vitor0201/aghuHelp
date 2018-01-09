
<div class="internautas view large-9 medium-8 columns content">
<div class="panel panel-default" id="accordion" >

	<div class="panel-heading"> 
		
		 <div class="dropdown pull-right">
		 
		 <?php if(!$internauta->id):?>
		 <span class="label label-danger">Complete seu cadastro »</span>
		 <?php endif; ?>
		  <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['controller'=>'internautas','action' => 'meusDados'], ['data-toggle'=>"tooltip", 'data-placement'=>"bottom", 'title'=>'Alterar seus Dados' ,'class'=>'btn btn-sm btn-default','escape' => false]) ?>
                               
                </div>
              
          <h3>
          <a  data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Usuário</a> <small>(<?= h($login['login']) ?>)</small> </h3>  
          
		 
	</div>
	
	<?php 
	$collapse_in = $internauta->id ? '' : 'in';
	?>
	<div id="collapseOne" class="panel-collapse collapse <?php echo $collapse_in?>" role="tabpanel">
	 <ul class="list-group">
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Nome</strong></div>
	    		<div class="col-sm-9"><?= h($login['nome']) ?></div>
	    		
	    	</div>
	    </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>CPF</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->cpf) ?></div>
	    		
	    	</div>
	     </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>E-mail</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->email) ?></div>
	    		
	    	</div>
	     </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Contato/Fone</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->contato) ?></div>
	    		
	    	</div>
	     </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Nascimento</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->data_nascimento) ?></div>
	    		
	    	</div>
	    	
    	</li>
    </ul>
    </div>
    
    </div>
    <div class="panel panel-default" id="accordion2" >
    <div class="panel-heading"> 
		
		
		 <div class=" pull-right">
                                <?php 
                                $class="";
                                $message = "Adicionar Dispositivo";
                                if($meus_dispositivos->count() < $internauta->quantidade_dispositivos) 
									echo $this->Html->link('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp; '.__('Cadastrar'), ['controller'=>'dispositivos','action' => 'cadastrar'], ['data-toggle'=>"tooltip", 'data-placement'=>"bottom", 'title'=>$message ,'class'=>'btn btn-sm btn-default','escape' => false]) ?>
                </div>
                
          <h3><a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Meus Dispositivos</a> <small>(<?= ($meus_dispositivos->count()) ?>)</small></h3>
	</div>
	<?php 
		$collapse_in = $internauta->id && ($meus_dispositivos->count()) ? 'in' : '';
	
	?>
    <div id="collapseTwo" class="panel-collapse collapse <?php echo $collapse_in ?>" role="tabpanel">
 	    	<?php if ($meus_dispositivos->count()): ?>
	    	<div id="no-more-tables" >
	        <table class="table table-striped " cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
	         <thead>
	            <tr>	<th class="actions">&nbsp;</span></th>
		                
		                <th><?= __('Dispositivo') ?></th>
		                <th><?= __('MAC') ?></th>
		                <th><?= __('Situação') ?></th>
		                
		                <th><?= __('Data ') ?></th>
		                
	            </tr>
	         </thead>
	         <?php $has_pendente=false; ?>
	            <?php foreach ($meus_dispositivos as $dispositivos): ?>
	            <?php 
	            //debu($ativo_id);
	            	if($dispositivos->situacao->id !=$ativo_id){
	            		$class="danger";
	            		$has_pendente = true;
	            	}
	            	else{
						$class="primary";
					}
	            	
	            ?>
	            <tr <?php echo $class;?> style="font-size: 110%">
	            <td class="action">
                    		
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-sm  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									  
									  
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Imprimir Termo de Responsabilidade'), ['controller'=>'dispositivos','action' => 'termo', $dispositivos->id], ['escape' => false]); ?></li>
									    <li><?php echo $this->Html->link(__('Alterar'), ['controller'=>'dispositivos','action' => 'alterar', $dispositivos->id], ['escape' => false]); ?></li>
									   
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Remover'), ['controller'=>'dispositivos','action' => 'remover', $dispositivos->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									  </ul>
							</div>
						</td>
	                <td data-title="Dispositivo"><?= h($dispositivos->tipo_dispositivo->descricao) ?></td>
	                <td data-title="MAC"><?= h($dispositivos->endereco_mac) ?></td>	
	                <td data-title="Situação"><span class="label label-<?php echo $class; ?>"><?= h($dispositivos->situacao->descricao) ?></span></td>
	                
	                <td data-title="Data"><?= h(substr($dispositivos->data_cadastro,0,10)) ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	        </div>
	    <?php else: ?>
	    <div class="panel-body">
	    <div class="alert alert-warning" style="margin-bottom: 0">Nenhum aparelho cadastrado.</div>
	    </div>
	    <?php endif; ?>
</div>
<div class="panel-footer"><span class="glyphicon glyphicon-hand-up" style="padding-left: 15px"></span> <small> <span class="text-<?php echo $has_pendente ? "danger" : 'info'; ?>"><span class="glyphicon glyphicon-info-sign"></span> Após cadastrar um aparelho, é necessário imprimir e enviar o <b>Termo de Responsabilidade</b> ao setor de TI e aguardar a liberação.</span></small></div>
</div>
</div>
