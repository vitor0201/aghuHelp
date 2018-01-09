
<div class="recebidas view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $recebida->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $recebida->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Recebida <small><?= h($recebida->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Texto') ?></th>
            <td><?= h($recebida->texto) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($recebida->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Fone') ?></th>
            <td><?= $this->Number->format($recebida->fone) ?></td>
        </tr>
        <tr>
            <th><?= __('Data Hora') ?></th>
            <td><?= h($recebida->data_hora) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

 
  
</ul>
    
    


	<div class="tab-content">
		</div>

</div>
</div>
</div>
