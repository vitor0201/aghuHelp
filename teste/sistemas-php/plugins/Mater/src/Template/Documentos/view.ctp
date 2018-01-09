
<div class="documentos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $documento->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $documento->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Documento</h3>
	</div>
     
    <table class="table">
        <tr>
            <th><?= __('Título') ?></th>
            <td><b><?= h($documento->titulo) ?></b></td>
        </tr>
        <tr>
            <th><?= __('Tipo') ?></th>
            <td><?= h($documento->arquivo_tipo) ?></td>
        </tr>
        <tr>
            <th><?= __('Arquivo') ?></th>
            <td><?= $this->Html->link($documento->arquivo_nome,['action'=>'download',$documento->id ]) ?></td>
        </tr>
       
                <tr>
            <th><?= __('Tamanho') ?></th>
            <td><?= h(human_filesize($documento->arquivo_tamanho) ) ?></td>
        </tr>
         <tr>
            <th><?= __('Usuário') ?></th>
            <td><?= h($documento->usuario_cadastro) ?></td>
        </tr>
        <tr>
            <th><?= __('Cadastro') ?></th>
            <td><?= h($documento->cadastro) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $documento->ativo ? $this->Html->label('SIM','info') : $this->Html->label('NÃO','danger'); ?></td>
         </tr>
    </table>
   
  
    

    <div class="panel-body">
    <h4>Procedimentos</h4>
	    	<?php if (!empty($documento->procedimentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Código') ?></th>
		                <th><?= __('Descrição') ?></th>
	            </tr>
	         </thead>
	            <?php foreach ($documento->procedimentos as $procedimentos): ?>
	            <?php 
	            	$class="";
	            	if(!$procedimentos->ativo)
	            		$class="text-danger";
	            ?>
	            <tr <?php echo $class;?>>
	              
	                <td><?= h($procedimentos->codigo) ?></td>
	                <td><?= h($procedimentos->descricao) ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum procedimento vinculado.</div>
	    <?php endif; ?>
	    </div>
    
    </div>
    


	

</div>
</div>

