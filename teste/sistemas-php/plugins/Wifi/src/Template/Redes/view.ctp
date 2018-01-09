<?php //$this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="redes view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $rede->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $rede->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Rede <small><?= h($rede->nome) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($rede->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Faixa Ip') ?></th>
            <td><?= h($rede->faixa_ip) ?></td>
        </tr>
        <tr class="hidden-xs hidden-sm">
            <th><?= __('Cont/Arq.DHCP') ?></th>
            <td><pre><?= h($rede->conteudo) ?></pre></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $rede->ativo ? $this->Html->label('ATIVO','info') :  $this->Html->label('INATIVO','danger'); ?></td>
         </tr>
    </table>
   
   
   <h3>Dispositivos <?php echo $this->Paginator->counter('({{count}})');  ?></h3>
	    	<?php if (!empty($dispositivos)): ?>
	    	<div id="no-more-tables" >
	        <table table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
	         <thead>
	            <tr>
		                <th class="actions">&nbsp;</th>
		                <th><?= __('Tipo') ?></th>
		                <th><?= __('Internauta') ?></th>
		                
		                <th><?= __('Situação') ?></th>
		                <th><?= __('MAC') ?></th>
		                
		                <th><?= __('Cadastro') ?></th>
		                <th><?= __('Recebimento') ?></th>
		                <th><?= __('Validade') ?></th>
		                <th><?= __('IP') ?></th>
		               
	            </tr>
	         </thead>
	            <?php foreach ($dispositivos as $dispositivos): ?>
	            <?php 
	           	//debug($dispositivos);
	            	$class="";
	            	if(!$dispositivos->situacao_id != 3)
	            		$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	                <td class="action">
						                    	
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['controller'=>'dispositivos','action' => 'view', $dispositivos->id], ['escape' => false]); ?></li>
								    <li><?php echo $this->Html->link(__('Alterar'), ['controller'=>'dispositivos','action' => 'edit', $dispositivos->id], ['escape' => false]); ?></li>
								   
								    <li role="separator" class="divider"></li>
								    <li><?php echo $this->Html->link(__('Remover'), ['controller'=>'dispositivos','action' => 'delete', $dispositivos->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
								  </ul>
						</div>
					</td>
					
	                <td data-title="Dispositivo"><?= h($dispositivos->tipo_dispositivo->descricao) ?></td>
	                <td data-title="Dispositivo"><?= h($dispositivos->internauta->login) ?></td>
	                <td data-title="Situação"><?= h($dispositivos->situacao->descricao) ?></td>
	                <td data-title="MAC"><?= h($dispositivos->endereco_mac) ?></td>
	                
	                <td data-title="Cadastro"><?= h(substr($dispositivos->data_cadastro,0,10)) ?>&nbsp;</td>
	                <td data-title="Receb."><?= h(substr($dispositivos->data_recebimento,0,10)) ?>&nbsp;</td>
	                 <td data-title="Receb."><?= h(substr($dispositivos->data_validade,0,10)) ?>&nbsp;</td>
	                <td data-title="IP"><?= h($dispositivos->endereco_ip) ?>&nbsp;</td>
	               
	            </tr>
	            <?php endforeach; ?>
	        </table>
	        </div>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum dispositivo associado.</div>
	    <?php endif; ?>


</div>

<div class="panel-footer"> 
            	<div class="row ajax-pagination">
                  
                   <div class="col col-xs-8" style=" line-height: 40px;height: 40px;" >
                   <div class="btn-toolbar" role="toolbar" aria-label="...">
                   <div class="btn-group">
	                  <ul class="pagination pagination-sm hidden-xs ">
	                  	<?php echo $this->Paginator->numbers() ?>
	                    </ul>
                    </div>
                    <div class="btn-group">
                    <ul class="pagination  pagination-sm">
                        <?php echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false]) ?>
                    	<?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false]) ?>
                    </ul>
                    </div>
	                   <?php 
							$paginas = [15,25,50,75,100];
							$active = $this->Paginator->param('limit');
						?>
                      &nbsp;
						<small class="hidden-xs hidden-sm" >
	                 <?php echo $this->Paginator->counter(
								    'Página {{page}} de {{pages}} - Total: {{count}} registro(s)'
								);
		             ?>
		                </small>
				
                    </div>
                  </div>
                   
                   
                </div>
							
            </div>   

</div>
</div>
