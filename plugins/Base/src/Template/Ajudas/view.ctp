
<div class="ajudas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $ajuda->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $ajuda->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Ajuda <small><?= h($ajuda->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($ajuda->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Conteudo') ?></th>
            <td><?= h($ajuda->conteudo) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Ajuda') ?></th>
            <td><?= $ajuda->has('parent_ajuda') ? $this->Html->link($ajuda->parent_ajuda->id, ['controller' => 'Ajudas', 'action' => 'view', $ajuda->parent_ajuda->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Sistema') ?></th>
            <td><?= $ajuda->has('sistema') ? $this->Html->link($ajuda->sistema->id, ['controller' => 'Sistemas', 'action' => 'view', $ajuda->sistema->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ajuda->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($ajuda->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rght') ?></th>
            <td><?= $this->Number->format($ajuda->rght) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $ajuda->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Ajudas" aria-controls="Ajudas" role="tab" data-toggle="tab"><?= __('Related Ajudas') ?></a></li>
  
  
</ul>
    
    </div>


	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane" id="Ajudas">
	    
	        <h4><?= __('Related Ajudas') ?></h4>
	        <?php if (!empty($ajuda->child_ajudas)): ?>
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
	            <?php foreach ($ajuda->child_ajudas as $childAjudas): ?>
	            <tr>
	                <td><?= h($childAjudas->id) ?></td>
	                <td><?= h($childAjudas->nome) ?></td>
	                <td><?= h($childAjudas->conteudo) ?></td>
	                <td><?= h($childAjudas->lft) ?></td>
	                <td><?= h($childAjudas->rght) ?></td>
	                <td><?= h($childAjudas->parent_id) ?></td>
	                <td><?= h($childAjudas->ativo) ?></td>
	                <td><?= h($childAjudas->sistema_id) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => 'Ajudas', 'action' => 'view', $childAjudas->id]) ?>

	                    <?= $this->Html->link(__('Alterar'), ['controller' => 'Ajudas', 'action' => 'edit', $childAjudas->id]) ?>

	                    <?= $this->Form->postLink(__('Remover'), ['controller' => 'Ajudas', 'action' => 'delete', $childAjudas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAjudas->id)]) ?>

	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php endif; ?>
	    </div>
		</div>

</div>
</div>
