
<div class="internautas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $internauta->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $internauta->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Internauta <small><?= h($internauta->login) ?></small></h3>
	</div>
    <div class="panel-body">  
    
     <ul class="list-group">
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Nome</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->nome) ?></div>
	    		
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
	    		<div class="col-sm-9"><?= h(substr($internauta->data_nascimento,0,10)) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Setor</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->setor) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Login</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->login) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Cadastro</strong></div>
	    		<div class="col-sm-9"><?= h(substr($internauta->data_cadastro,0,10)) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Atualização</strong></div>
	    		<div class="col-sm-9"><?= h(substr($internauta->data_atualizacao,0,10)) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Qtd. Dispositivos</strong></div>
	    		<div class="col-sm-9"><?= h($internauta->quantidade_dispositivos) ?> (máximo)</div>
	    		
	    	</div>
	    	
    	</li>
    </ul>
  <h3>Dispositivos</h3>
	    	<?php if (!empty($internauta->dispositivos)): ?>
	    	<div id="no-more-tables" >
	        <table table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
	         <thead>
	            <tr>
		                <th class="actions">&nbsp;</th>
		                <th><?= __('Dispositivo') ?></th>
		                
		                <th><?= __('Situação') ?></th>
		                <th><?= __('MAC') ?></th>
		                
		                <th><?= __('Cadastro') ?></th>
		                <th><?= __('Recebimento') ?></th>
		                <th><?= __('Validade') ?></th>
		                <th><?= __('IP') ?></th>
		               
	            </tr>
	         </thead>
	            <?php foreach ($internauta->dispositivos as $dispositivos): ?>
	            <?php 
	           	//debug($dispositivos);
	            	$class="";
	            	//if(!$dispositivos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td class="action">
						                    	
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['controller'=>'dispositivos','action' => 'view', $dispositivos->id], ['escape' => false]); ?></li>
								    <li><?php echo $this->Html->link(__('Alterar'), ['controller'=>'dispositivos','action' => 'edit', $dispositivos->id], ['escape' => false]); ?></li>
								   
								    <li role="separator" class="divider"></li>
								    <li><?php echo $this->Html->link(__('Remover'), ['controller'=>'dispositivos','action' => 'delete', $dispositivos->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
								  </ul>
						</div>
					</td>
	                <td data-title="Dispositivo"><?= h($dispositivos->tipo_dispositivo->descricao) ?></td>
	                <td data-title="Situação"><?= h($dispositivos->situacao->descricao) ?></td>
	                <td data-title="MAC"><?= h($dispositivos->endereco_mac) ?></td>
	                
	                <td data-title="Cadastro"><?= h(substr($dispositivos->data_cadastro,0,10)) ?>&nbsp;</td>
	                <td data-title="Receb."><?= h(substr($dispositivos->data_recebimento,0,10)) ?>&nbsp;</td>
	                 <td data-title="Receb."><?= h(substr($dispositivos->data_validade,0,10)) ?>&nbsp;</td>
	                <td data-title="IP"><?= h($dispositivos->endereco_ip) ?>&nbsp;</td>
	               
	            </tr>
	            <?php endforeach; ?>
	        </table>
	        </div>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum dispositivo associado.</div>
	    <?php endif; ?>
	 

</div>
</div>
</div>
