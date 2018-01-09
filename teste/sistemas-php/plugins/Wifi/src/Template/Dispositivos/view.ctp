
<div class="dispositivos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $dispositivo->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $dispositivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Dispositivo <small><?= h($dispositivo->tipo_dispositivo->descricao) ?> / <?= h($dispositivo->endereco_mac) ?></small></h3>
	</div>
    <div class="panel-body">  
    
    <ul class="list-group">
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Dispositivo</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->tipo_dispositivo->descricao) ?></div>
	    		
	    	</div>
	    </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Internauta</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->internauta->nome) ?></div>
	    		
	    	</div>
	     </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>MAC</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->endereco_mac) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>IP</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->endereco_ip) ?>&nbsp;</div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Interface/Rede</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->rede->nome) ?>&nbsp;</div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Cadastro</strong></div>
	    		<div class="col-sm-9"><?= h(substr($dispositivo->data_cadastro,0,10)) ?>&nbsp;</div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Recebimento</strong></div>
	    		<div class="col-sm-9"><?= h(substr($dispositivo->data_recebimento,0,10)) ?>&nbsp;</div>
	    		
	    	</div>
	    	
    	</li>
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Validade</strong></div>
	    		<div class="col-sm-9"><?= h(substr($dispositivo->data_validade,0,10)) ?>&nbsp;</div>
	    		
	    	</div>
	    	
    	</li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Situação</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->situacao->descricao) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	 
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Justificativa</strong></div>
	    		<div class="col-sm-9"><?= h($dispositivo->justificativa) ?></div>
	    		
	    	</div>
	    	
    	</li>
    	
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong><i>Created</i></strong></div>
	    		<div class="col-sm-9"><i><?= h($dispositivo->created) ?></i></div>
	    		
	    	</div>
	    	
    	</li>
    	
    	 <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong><i>Modified</i></strong></div>
	    		<div class="col-sm-9"><i><?= h($dispositivo->modified) ?></i></div>
	    		
	    	</div>
	    	
    	</li>
    	 
    </ul>
    

</div>
</div>
</div>
