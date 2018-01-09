
<div class="coletas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $coleta->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $coleta->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Coleta <small><?= h($coleta->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Codigo') ?></th>
            <td><?= h($coleta->codigo) ?></td>
        </tr>
        <tr>
            <th><?= __('Descricao') ?></th>
            <td><?= h($coleta->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Lote') ?></th>
            <td><?= h($coleta->lote) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($coleta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantidade') ?></th>
            <td><?= $this->Number->format($coleta->quantidade) ?></td>
        </tr>
        <tr>
            <th><?= __('Validate') ?></th>
            <td><?= h($coleta->validate) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

 
  
</ul>
    
    


	<div class="tab-content">
		</div>

</div>
</div>
</div>
