
<div class="procedimentos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $procedimento->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $procedimento->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Procedimento <small><?= h($procedimento->codigo) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Código') ?></th>
            <td><?= h($procedimento->codigo) ?></td>
        </tr>
        <tr>
            <th><?= __('Descrição AGHU') ?></th>
            <td><?= h($procedimento->descricao) ?></td>
        </tr>
         <tr>
            <th><?= __('Descrição') ?></th>
            <td><?= h($procedimento->descricao2) ?></td>
        </tr>
         <tr>
            <th><?= __('Sigla') ?></th>
            <td><?= h($procedimento->sigla) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $procedimento->ativo ? $this->Html->label('SIM','info') : $this->Html->label('NÃO','danger'); ?></td>
         </tr>
    </table>
		    
	    <div role="tabpanel" class="tab-pane " id="Documentos">
			<h4>Documentos (arquivos associados)</h4>
	    	<?php if (!empty($procedimento->documentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		            
		            
		                <th><?= __('TÍtulo') ?></th>
		                <th><?= __('Arquivo') ?></th>
		                <th><?= __('Ativo') ?></th>
	            </tr>
	         </thead>
	            <?php foreach ($procedimento->documentos as $documentos): ?>
	            <?php 
	            	$class="";
	            	if(!$documentos->ativo)
	            		$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($documentos->titulo) ?></td>
	                <td><?= h($documentos->arquivo_nome) ?></td>
	                <td><?= h($documentos->ativo ? 'SIM' : 'NÃO') ?></td>
				</tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum registro encontrado.</div>
	    <?php endif; ?>
	    </div>
		    
	    <div role="tabpanel" class="tab-pane " id="Medicos">
			
			<h4>Médicos (portifólio)</h4>
	    	<?php if (!empty($procedimento->medicos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Nome') ?></th>
		                <th><?= __('CRM') ?></th>
		                <th><?= __('Residente') ?></th>
		                <th><?= __('Preceptor') ?></th>
		                <th><?= __('Ativo') ?></th>
	            </tr>
	         </thead>
	            <?php foreach ($procedimento->medicos as $medicos): ?>
	            <?php 
	            	$class="";
	            	if(!$medicos->ativo)
	            		$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td><?= h($medicos->nome) ?></td>
	                <td><?= h($medicos->crm) ?></td>
	                <td><?= h($medicos->residente ? 'SIM' : 'NÃO') ?></td>
	                <td><?= h($medicos->preceptor ? 'SIM' : 'NÃO') ?></td>
	                <td><?= h($medicos->ativo ? 'SIM' : 'NÃO') ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum registro encontrado.</div>
	    <?php endif; ?>
	    </div>
		</div>

</div>
</div>
