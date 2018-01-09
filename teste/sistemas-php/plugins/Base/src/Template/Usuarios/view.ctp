
<div class="usuarios view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $usuario->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $usuario->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Usuário <small><?= h($usuario->login) ?></small></h3>
	</div>
	
	
	<ul class="list-group">
    	<li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong><?= __('Sistema') ?></strong></div>
	    		<div class="col-sm-9"><?= $usuario->has('sistema') ? h($usuario->sistema->nome) : '' ?></div>
	    		
	    	</div>
	    </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Nome</strong></div>
	    		<div class="col-sm-9"><?= h($usuario->nome) ?></div>
	    		
	    	</div>
	    </li>
	    <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Ativo no Sistema</strong></div>
	    		<div class="col-sm-9"><?= $usuario->ativo ? $this->Html->label('ATIVO','info') : $this->Html->label('INATIVO','danger'); ?></div>
	    		
	    	</div>
	    </li>
	     <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Ativo no LDAP/AD</strong></div>
	    		<div class="col-sm-9"><?= $ldap_ad_status=='ATIVO' ? $this->Html->label('ATIVO','info') : $this->Html->label($ldap_ad_status,'danger'); ?></div>
	    		
	    	</div>
	    </li>
	     <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>LDAP/AD Status</strong></div>
	    		<div class="col-sm-9">
	    		<?php 
		         	 if($user_ldap) {
				         $num = $user_ldap->getUserAccountControl();
				         $sts = [];
				         foreach ($status as $key => $s){
				         	if($num & $key)
				         		$sts[$key] = $status[$key];
				         }
				         foreach($sts as $key => $st){
				         	if(in_array($key, $inactive_status))
				         		echo $this->Html->label("$key-$st", 'danger')." " ;
				         	else
				         		echo $this->Html->label("$key-$st", 'default'). " " ;
				         }
			         }
		         ?>
	    		</div>
	    		
	    	</div>
	    </li>
	     <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Perfil</strong></div>
	    		<div class="col-sm-9"><?php 
             	foreach($usuario->grupos as $grupo){
             		echo $this->Html->label($grupo->descricao, $grupo->ativo ? 'default': 'danger' )." ";
             	}
		         ?> &nbsp;</div>
	    		
	    	</div>
	    </li>
	     <li class="list-group-item" >
	    	<div class="row">
	    		<div class="col-sm-3"><strong>Último Acesso</strong></div>
	    		<div class="col-sm-9"><?php 
             	 echo ($usuario->ultimo_login ? h($usuario->ultimo_login) : '<i>nunca</i>');
		         ?> &nbsp;</div>
	    		
	    	</div>
	    </li>
	    
	</ul>
	
    <div class="panel-footer">
    <small>Data/hora atual: <?php echo date('d/m/Y H:i:s'); ?></small>
    </div>
	

</div>
</div>
