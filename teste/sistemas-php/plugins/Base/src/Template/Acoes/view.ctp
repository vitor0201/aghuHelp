
<div class="acoes view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $acao->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $acao->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Ação <small><?= h($acao->prefix) ?>/<?= h($acao->controller) ?>/<?= h($acao->action) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Sistema') ?></th>
            <td><?= h($acao->sistema->nome); ?></td>
        </tr>
        <tr>
            <th><?= __('Projeto') ?></th>
            <td><?= h($acao->prefix) ?></td>
        </tr>
         <tr>
            <th><?= __('Controller') ?></th>
            <td><?= h($acao->controller) ?></td>
        </tr>
        <tr>
            <th><?= __('Action') ?></th>
            <td><?= h($acao->action) ?></td>
        </tr>
       
        <tr>
            <th><?= __('Tipo') ?></th>
            <td><?= h($acao->tipo) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $acao->ativo ? $this->Html->label('ATIVA','info') : $this->Html->label('INATIVA','danger'); ?></td>
         </tr>
         
           <tr>
            <th><?= __('Grupos') ?></th>
            <td>
            <?php 
				foreach($acao->grupos as $grupo){
					echo $this->Html->label($grupo->descricao, $grupo->ativo ? 'default': 'danger' )." ";	
				}
			?>
            </td>
         </tr>
    </table>
    </div>
</div>
</div>
