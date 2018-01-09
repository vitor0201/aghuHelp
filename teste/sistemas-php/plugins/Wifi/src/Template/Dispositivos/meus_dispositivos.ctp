<div id="AjaxContent" class="dispositivos index large-9 medium-8 columns content"> 
<?php //echo date('d/m/Y H:i:s') ; ?>
   
    <div class="panel panel-default">
        <div class="panel-heading">
             <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Dispositivo'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Meus Dispositivos') ?> <small>(<?php echo $dispositivos->count() ?>)</small></h3>
        </div>
		<div id="no-more-tables" >
        <div id="PanelBody" >  
        
            <table class="table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    						<th class="actions">&nbsp;</th>
                                                <th class="ajax-pagination">Dispositivo</th>
                                                
                                                <th class="ajax-pagination">MAC</th>
                                                <th class="ajax-pagination">Situação</th>
                                                <th class="ajax-pagination">Data</th>
                                                
                                                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($dispositivos as $dispositivo):
                    $class="";
                    //if(!$dispositivo->ativo)
                    //	$class="class='text-danger'";
                    //debug($dispositivo);
                    
                    ?>
                    <tr <?php echo $class;?>>
                   		                    	<td class="action">
                    		
                    		<div class="btn-group ">
									  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									  
									  
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $dispositivo->id], ['escape' => false]); ?></li>
									    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $dispositivo->id], ['escape' => false]); ?></li>
									   
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $dispositivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									  </ul>
							</div>
						</td>
                        
                        <td data-title="Dispositivo"><?php echo h($dispositivo->tipo_dispositivo->descricao); ?>&nbsp;</td>
                   		 <td data-title="MAC"><?php echo h($dispositivo->endereco_mac) ?>&nbsp;</td>
                        
                        <td data-title="Situação"><?php echo h($dispositivo->situacao->descricao) ?>&nbsp;</td>
                                         
                                                <td data-title="Data"><?php echo h($dispositivo->data_cadastro) ?>&nbsp;</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($dispositivos->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            <?php endif;?>
 </div>
 </div>
            
            <div class="panel-footer"> 
            	Ao incluir ou alterar um dispositivo é necessário imprimir e enviar o Termo de Responsabilidade ao SGPTI.
							
            </div>       
    </div>
</div>

