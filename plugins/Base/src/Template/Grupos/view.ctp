
<div class="grupos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $grupo->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $grupo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Grupo <small><?= h($grupo->descricao) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Sistema') ?></th>
            <td><?= h($grupo->sistema->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Desrição') ?></th>
            <td><?= h($grupo->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Atividade/Obs:') ?></th>
            <td><?= h($grupo->atividade) ?></td>
        </tr>
        <tr>
            <th><?= __('Sigla') ?></th>
            <td><?= h($grupo->sigla) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
             <td><?= $grupo->ativo ? $this->Html->label('ATIVO','info') : $this->Html->label('INATIVO','danger'); ?></td>
         </tr>
            <tr>
            <th><?= __('Tipo') ?></th>
             <td><?= $grupo->is_public ? $this->Html->label('PUBLIC','info') : $this->Html->label('PRIVATE','warning'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Acoes" aria-controls="Acoes" role="tab" data-toggle="tab"><?= __('Ações') ?>(<?php echo count($grupo->acoes)?>)</a></li>
  <li role="presentation" class=""><a href="#Parametros" aria-controls="Parametros" role="tab" data-toggle="tab"><?= __('Parâmetros') ?> (<?php echo count($grupo->parametros)?>)</a></li>
  <li role="presentation" class=""><a href="#Usuarios" aria-controls="Usuarios" role="tab" data-toggle="tab"><?= __('Usuários') ?> (<?php echo count($grupo->usuarios)?>)</a></li>
  
  
</ul>
    
    </div>

	<div class="panel-body">
	<div class="tab-content">

	<div role="tabpanel" class="tab-pane active" id="Acoes">
			
	    	<?php if (!empty($grupo->acoes)): ?>
	    	
	        <table cellpadding="0" cellspacing="0" class="table">
	            <tr >
		                <th><?= __('Projeto') ?></th>
		                <th><?= __('Controller') ?></th>
		                <th><?= __('Action') ?></th>
		               
		                <th><?= __('Ativo') ?></th>
		                <th><?= __('Tipo') ?></th>
	            </tr>
	            <?php foreach ($grupo->acoes as $acoes): ?>
	             <?php 
		            $class="";
		            if(!$acoes->ativo)
		            	$class="class='text-danger'";
		        ?>
	            <tr <?php echo $class; ?>>
	                <td><?= h($acoes->prefix) ?></td>
	                <td><?= h($acoes->controller) ?></td>
	                <td><?= h($acoes->action) ?></td>
	                <td><?= h($acoes->ativo ? 'Ativo': 'Inativo') ?></td>
	                <td><?= h($acoes->tipo) ?></td>
	            </tr>
	            
	            <?php endforeach; ?>
	        </table>
	     <?php else: ?>
			<div class="alert alert-warning">Nenhuma ação vinculada.</div>	
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Parametros">
	    
	      
	        <?php if (!empty($grupo->parametros)): ?>
	        
	        <table cellpadding="0" cellspacing="0" class="table">
	            <tr>
		                <th><?= __('Descrição') ?></th>
		                <th><?= __('Chave') ?></th>
		                <th><?= __('Tipo') ?></th>
		                <th><?= __('Ativo') ?></th>
	            </tr>
	            <?php foreach ($grupo->parametros as $parametros): ?>
	            <?php 
		            $class="";
		            if(!$parametros->ativo)
		            	$class="class='text-danger'";
		        ?>
	            <tr <?php echo $class; ?>>
	                <td><?= h($parametros->descricao) ?></td>
	                <td><?= h($parametros->chave) ?></td>
	                <td><?= h($parametros->tipo) ?></td>
	                <td><?= h($parametros->ativo ? 'Ativo': 'Inativo') ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	         <?php else: ?>
			<div class="alert alert-warning">Nenhum parâmetro vinculado.</div>	
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Usuarios">
	    
	      
	        <?php if (!empty($grupo->usuarios)): ?>
	        <table cellpadding="0" cellspacing="0" class="table">
	         <thead>
	            <tr>
		                <th><?= __('Nome') ?></th>
		                <th><?= __('Login') ?></th>
		                <th><?= __('Ativo') ?></th>
	            </tr>
	           </thead>
	            <?php foreach ($grupo->usuarios as $usuarios): ?>
	            <?php 
		            $class="";
		            if(!$usuarios->ativo)
		            	$class="class='text-danger'";
		        ?>
	            <tr  <?php echo $class; ?>>
	                <td><?= h($usuarios->nome) ?></td>
	                <td><?= h($usuarios->login) ?></td>
	                <td><?= h($usuarios->ativo ? 'Ativo': 'Inativo') ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	         <?php else: ?>
			<div class="alert alert-warning">Nenhum usuário faz parte do grupo.</div>	
	    <?php endif; ?>
	    </div>
		</div>
	</div>
</div>
</div>
