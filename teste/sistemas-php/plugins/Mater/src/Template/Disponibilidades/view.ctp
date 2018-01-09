
<div class="disponibilidades view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $disponibilidade->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $disponibilidade->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Disponibilidade <small><?= h($disponibilidade->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Medico') ?></th>
            <td><?= $disponibilidade->has('medico') ? $this->Html->link($disponibilidade->medico->id, ['controller' => 'Medicos', 'action' => 'view', $disponibilidade->medico->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Periodo') ?></th>
            <td><?= $disponibilidade->has('periodo') ? $this->Html->link($disponibilidade->periodo->id, ['controller' => 'Periodos', 'action' => 'view', $disponibilidade->periodo->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($disponibilidade->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Dia Semana') ?></th>
            <td><?= $this->Number->format($disponibilidade->dia_semana) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $disponibilidade->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

 
  
</ul>
    
    


	<div class="tab-content">
		</div>

</div>
</div>
</div>
