
<div class="cargos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $cargo->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $cargo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Cargo <small><?= h($cargo->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Cargo Descricao') ?></th>
            <td><?= h($cargo->cargo_descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('Cargo Codigo') ?></th>
            <td><?= h($cargo->cargo_codigo) ?></td>
        </tr>
        <tr>
            <th><?= __('Cargo Observacao') ?></th>
            <td><?= h($cargo->cargo_observacao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($cargo->id) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

 
  
</ul>
    
    


	<div class="tab-content">
		</div>

</div>
</div>
</div>
