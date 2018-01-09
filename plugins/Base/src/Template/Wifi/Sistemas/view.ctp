
<div class="sistemas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $sistema->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $sistema->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Sistema <small><?= h($sistema->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($sistema->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Versao') ?></th>
            <td><?= h($sistema->versao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($sistema->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Criado Em') ?></th>
            <td><?= h($sistema->criado_em) ?></td>
        </tr>
        <tr>
            <th><?= __('Atualizado Em') ?></th>
            <td><?= h($sistema->atualizado_em) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $sistema->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Acoes" aria-controls="Acoes" role="tab" data-toggle="tab"><?= __('Related Acoes') ?></a></li>
   <li role="presentation" class="active"><a href="#Ajudas" aria-controls="Ajudas" role="tab" data-toggle="tab"><?= __('Related Ajudas') ?></a></li>
   <li role="presentation" class="active"><a href="#Grupos" aria-controls="Grupos" role="tab" data-toggle="tab"><?= __('Related Grupos') ?></a></li>
   <li role="presentation" class="active"><a href="#Menus" aria-controls="Menus" role="tab" data-toggle="tab"><?= __('Related Menus') ?></a></li>
   <li role="presentation" class="active"><a href="#Parametros" aria-controls="Parametros" role="tab" data-toggle="tab"><?= __('Related Parametros') ?></a></li>
   <li role="presentation" class="active"><a href="#Usuarios" aria-controls="Usuarios" role="tab" data-toggle="tab"><?= __('Related Usuarios') ?></a></li>
  
  
</ul>
    
    </div>


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane" id="Acoes">
	    
	        <h4><?= __('Related Acoes') ?></h4>
	        <?php if (!empty($sistema->acoes)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th><?= __('Prefix') ?></th>
		                <th><?= __('Action') ?></th>
		                <th><?= __('Controller') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th><?= __('Tipo') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->acoes as $acoes): ?>
	            <tr>
	                <td><?= h($acoes->id) ?></td>
	                <td><?= h($acoes->sistema_id) ?></td>
	                <td><?= h($acoes->prefix) ?></td>
	                <td><?= h($acoes->action) ?></td>
	                <td><?= h($acoes->controller) ?></td>
	                <td><?= h($acoes->ativo) ?></td>
	                <td><?= h($acoes->tipo) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Acoes', 'action' => 'view', $acoes->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Acoes', 'action' => 'edit', $acoes->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Acoes', 'action' => 'delete', $acoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $acoes->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Ajudas">
	    
	        <h4><?= __('Related Ajudas') ?></h4>
	        <?php if (!empty($sistema->ajudas)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Nome') ?></th>
		                <th><?= __('Conteudo') ?></th>
		                <th><?= __('Lft') ?></th>
		                <th><?= __('Rght') ?></th>
		                <th><?= __('Parent Id') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->ajudas as $ajudas): ?>
	            <tr>
	                <td><?= h($ajudas->id) ?></td>
	                <td><?= h($ajudas->nome) ?></td>
	                <td><?= h($ajudas->conteudo) ?></td>
	                <td><?= h($ajudas->lft) ?></td>
	                <td><?= h($ajudas->rght) ?></td>
	                <td><?= h($ajudas->parent_id) ?></td>
	                <td><?= h($ajudas->ativo) ?></td>
	                <td><?= h($ajudas->sistema_id) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Ajudas', 'action' => 'view', $ajudas->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Ajudas', 'action' => 'edit', $ajudas->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Ajudas', 'action' => 'delete', $ajudas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ajudas->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Grupos">
	    
	        <h4><?= __('Related Grupos') ?></h4>
	        <?php if (!empty($sistema->grupos)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th><?= __('Descricao') ?></th>
		                <th><?= __('Atividade') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th><?= __('Sigla') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->grupos as $grupos): ?>
	            <tr>
	                <td><?= h($grupos->id) ?></td>
	                <td><?= h($grupos->sistema_id) ?></td>
	                <td><?= h($grupos->descricao) ?></td>
	                <td><?= h($grupos->atividade) ?></td>
	                <td><?= h($grupos->ativo) ?></td>
	                <td><?= h($grupos->sigla) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Grupos', 'action' => 'view', $grupos->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Grupos', 'action' => 'edit', $grupos->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Grupos', 'action' => 'delete', $grupos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grupos->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Menus">
	    
	        <h4><?= __('Related Menus') ?></h4>
	        <?php if (!empty($sistema->menus)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Prefix') ?></th>
		                <th><?= __('Controller') ?></th>
		                <th><?= __('Action') ?></th>
		                <th><?= __('Parent Id') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th><?= __('Lft') ?></th>
		                <th><?= __('Rght') ?></th>
		                <th><?= __('Parent Id 1') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->menus as $menus): ?>
	            <tr>
	                <td><?= h($menus->id) ?></td>
	                <td><?= h($menus->prefix) ?></td>
	                <td><?= h($menus->controller) ?></td>
	                <td><?= h($menus->action) ?></td>
	                <td><?= h($menus->parent_id) ?></td>
	                <td><?= h($menus->ativo) ?></td>
	                <td><?= h($menus->lft) ?></td>
	                <td><?= h($menus->rght) ?></td>
	                <td><?= h($menus->parent_id_1) ?></td>
	                <td><?= h($menus->sistema_id) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Menus', 'action' => 'view', $menus->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Menus', 'action' => 'edit', $menus->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Menus', 'action' => 'delete', $menus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menus->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Parametros">
	    
	        <h4><?= __('Related Parametros') ?></h4>
	        <?php if (!empty($sistema->parametros)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th><?= __('Descricao') ?></th>
		                <th><?= __('Chave') ?></th>
		                <th><?= __('Valor') ?></th>
		                <th><?= __('Tipo') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->parametros as $parametros): ?>
	            <tr>
	                <td><?= h($parametros->id) ?></td>
	                <td><?= h($parametros->sistema_id) ?></td>
	                <td><?= h($parametros->descricao) ?></td>
	                <td><?= h($parametros->chave) ?></td>
	                <td><?= h($parametros->valor) ?></td>
	                <td><?= h($parametros->tipo) ?></td>
	                <td><?= h($parametros->ativo) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Parametros', 'action' => 'view', $parametros->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Parametros', 'action' => 'edit', $parametros->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Parametros', 'action' => 'delete', $parametros->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parametros->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane" id="Usuarios">
	    
	        <h4><?= __('Related Usuarios') ?></h4>
	        <?php if (!empty($sistema->usuarios)): ?>
	        <table cellpadding="0" cellspacing="0">
	            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Sistema Id') ?></th>
		                <th><?= __('Nome') ?></th>
		                <th><?= __('Login') ?></th>
		                <th><?= __('Ativo') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($sistema->usuarios as $usuarios): ?>
	            <tr>
	                <td><?= h($usuarios->id) ?></td>
	                <td><?= h($usuarios->sistema_id) ?></td>
	                <td><?= h($usuarios->nome) ?></td>
	                <td><?= h($usuarios->login) ?></td>
	                <td><?= h($usuarios->ativo) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Usuarios', 'action' => 'view', $usuarios->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Usuarios', 'action' => 'edit', $usuarios->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Usuarios', 'action' => 'delete', $usuarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuarios->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		</div>

</div>
</div>
