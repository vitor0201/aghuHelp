
<div class="parametros view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $parametro->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $parametro->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Parâmetro <small><?= h($parametro->chave) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Sistema') ?></th>
            <td><?= $parametro->has('sistema') ? h($parametro->sistema->nome) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Descrição') ?></th>
            <td><?= h($parametro->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Chave') ?></th>
            <td><?= h($parametro->chave) ?></td>
        </tr>
        
        <tr>
            <th><?= __('Valor') ?></th>
            <td><?= h($parametro->valor) ?></td>
        </tr>
        <tr>
            <th><?= __('Tipo') ?></th>
            <td><?= h($parametro->tipo) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $parametro->ativo ? $this->Html->label('Ativo', 'info') : $this->Html->label('Inativo', 'danger'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#Grupos" aria-controls="Grupos" role="tab" data-toggle="tab"><?= __('Grupos (perfis)') ?></a></li>
</ul>
    
	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane active" id="Grupos">
	    
	        <?php if (!empty($parametro->grupos)): ?>
	        <table cellpadding="0" cellspacing="0" class="table">
	        <thead>
	            <tr>
		                <th><?= __('Nome do Grupo') ?></th>
		                <th><?= __('Sigla') ?></th>
		                <th><?= __('Ativo') ?></th>
		                
	            </tr>
	           </thead>
	            <?php foreach ($parametro->grupos as $grupos): ?>
	            <?php 
		            $class="";
		            if(!$grupos->ativo)
		            	$class="class='text-danger'";
		        ?>
	            <tr <?php echo $class; ?> >
	                <td><?= h($grupos->descricao) ?></td>
	                <td><?= h($grupos->sigla) ?></td>
	                <td><?= h($grupos->ativo ? 'SIM' : 'NÃO') ?></td>
	              
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-danger">Nenhum grupo associado.</div>
	    <?php endif; ?>
	    </div>
		</div>
	</div>
</div>
</div>
