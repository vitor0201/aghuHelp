
<div class="cirurgiasProcedimentos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $cirurgiasProcedimento->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $cirurgiasProcedimento->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Cirurgias Procedimento <small><?= h($cirurgiasProcedimento->id) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Agendamento') ?></th>
            <td><?= $cirurgiasProcedimento->has('agendamento') ? $this->Html->link($cirurgiasProcedimento->agendamento->id, ['controller' => 'Agendamentos', 'action' => 'view', $cirurgiasProcedimento->agendamento->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Procedimento') ?></th>
            <td><?= $cirurgiasProcedimento->has('procedimento') ? $this->Html->link($cirurgiasProcedimento->procedimento->descricao, ['controller' => 'Procedimentos', 'action' => 'view', $cirurgiasProcedimento->procedimento->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Resultado') ?></th>
            <td><?= $cirurgiasProcedimento->has('resultado') ? $this->Html->link($cirurgiasProcedimento->resultado->descricao, ['controller' => 'Resultados', 'action' => 'view', $cirurgiasProcedimento->resultado->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Observacao') ?></th>
            <td><?= h($cirurgiasProcedimento->observacao) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($cirurgiasProcedimento->id) ?></td>
        </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

 
  
</ul>
    
    


	<div class="tab-content">
		</div>

</div>
</div>
</div>
