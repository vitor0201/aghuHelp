<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="dispositivos index large-9 medium-8 columns content"> 
<?php //echo date('d/m/Y H:i:s') ; ?>
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="FilterCollapse" class="collapsed" data-target="#collapseOne">
                  <span class="glyphicon glyphicon-search" ></span> Filtro <?php if(!empty($url)):?><span class="badge">aplicado</span> <?php endif;?>
                </a>
            </h4>
        </div>
        
        <div id="collapseOne" class="panel-collapse collapse ">
            <?php
           // $this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal' => true,
'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 4
		    	]]); ?>

            <div class="panel-body">                
            	
            	
            	 <div class="form-group text">
                    <label class="col-md-2 control-label"  for="username">Cadastro</label>

                    <div class="col-md-2"> 
                        <div class="input-group">
                            <input type="text" name="filtro_data_cadastro_inicio" class="form-control date"  id="filtro_data_cadastro_inicio" placeholder="Data inicio"
                                   value=" <?php echo isset($this->request->data['filtro_data_cadastro_inicio']) ? $this->request->data['filtro_data_cadastro_inicio'] : '' ?>"/>   
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>

                    <div class="col-md-2"> 
                        <div class="input-group">
                            <input type="text" name="filtro_data_cadastro_fim" class="form-control date"  id="filtro_data_cadastro_fim" placeholder="Data fim"
                                   value=" <?php echo isset($this->request->data['filtro_data_cadastro_fim']) ? $this->request->data['filtro_data_cadastro_fim'] : '' ?>"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>           
                    </div>
                </div>
                <div class="form-group text">
                    <label class="col-md-2 control-label"  for="username">Validade</label>

                    <div class="col-md-2"> 
                        <div class="input-group">
                            <input type="text" name="filtro_data_validade_inicio" class="form-control date"  id="filtro_data_validade_inicio" placeholder="Data inicio"
                                   value=" <?php echo isset($this->request->data['filtro_data_validade_inicio']) ? $this->request->data['filtro_data_validade_inicio'] : '' ?>"/>   
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>

                    <div class="col-md-2"> 
                        <div class="input-group">
                            <input type="text" name="filtro_data_validade_fim" class="form-control date"  id="filtro_data_validade_fim" placeholder="Data fim"
                                   value=" <?php echo isset($this->request->data['filtro_data_validade_fim']) ? $this->request->data['filtro_data_validade_fim'] : '' ?>"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>           
                    </div>
                </div>
                     		<?php echo $this->Form->input('rede_id', ['label'=>'Int./Rede', 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%']) ?>
                           
                                <?php echo $this->Form->input('tipo_dispositivo_id',['label'=>'Dispositivo', 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%']) ?>
                                
                                <?php echo $this->Form->input('situacao_id', ['label'=>'Situação', 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%']) ?>
                                <?php echo $this->Form->input('filtro_login', ['label'=>'Login']) ?>
                                <?php echo $this->Form->input('filtro_mac', ['label'=>'MAC']) ?>
                                <?php echo $this->Form->input('filtro_ip',['label'=>'IP']) ?>
                            </div>
            <div class="panel-footer">                
                <?php echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm']); ?>
                
            </div>

            <?php echo $this->Form->end(); ?>
            
             <script>
                jQuery("#FormFilterSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                                type:'POST',
                                async: true,
                                cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "index"]);?>',
                                
                                beforeSend: function(response) {
                                	
                                    jQuery('#FilterCollapse').click();
                                    
                                    jQuery('#PanelBody').fadeTo(300,0, function() {  });
                                },
                        
                                success: function(response) {
                                    
                                    jQuery('#AjaxContent').html(response);
                                    
                                    jQuery('#PanelBody').fadeTo(100, 1);
                                },
                                data:jQuery('#FormFilter').serialize()
                            });
                            return false;
                        }
                );
            </script>
        </div>
    </div>
  
 
    
    <div class="panel panel-default">
        <div class="panel-heading">
             <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Dispositivos') ?> <small>Listagem</small></h3>
        </div>
		<div id="no-more-tables" >
        <div id="PanelBody" >  
        
            <table class="table table-striped census" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    	
                    	<th class="actions">&nbsp;</th>
                                                
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('tipo_dispositivo_id','Dispositivo') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('internauta_id','Usuário') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('situacao_id','Situação') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('endereco_mac','MAC') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('endereco_ip','IP') ?></th>
                          <th class="ajax-pagination"><?php echo $this->Paginator->sort('rede_id','Rede') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('data_cadastro','Cadastro') ?></th>
                         <th class="ajax-pagination"><?php echo $this->Paginator->sort('data_validade','Validade') ?></th>
                                                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($dispositivos as $dispositivo):
                    $class="";
                    //if(!$dispositivo->ativo)
                    //	$class="class='text-danger'";
                    
                    ?>
                    <tr <?php echo $class;?>>
                   
                   		                   	<td class="action ">
                    	
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $dispositivo->id], ['escape' => false]); ?></li>
									    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $dispositivo->id], ['escape' => false]); ?></li>
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Enviar E-mail'), ['action' => 'enviarEmail', $dispositivo->id], ['escape' => false]); ?></li>
									   
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $dispositivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									  </ul>
							</div>
						</td>
                                                 
                   		
                        
                        <td data-title="Dispositivo"><?php echo h($dispositivo->tipo_dispositivo->descricao) ?>&nbsp;</td>
                                                 
                   		
                        
                        <td data-title="Usuário"><?php echo h($dispositivo->internauta->login); ?>&nbsp;</td>
                                                 
                   		
                        
                        <td data-title="Situação"><?php echo h($dispositivo->situacao->descricao); ?>&nbsp;</td>
                        <td data-title="MAC"><?php echo h($dispositivo->endereco_mac) ?>&nbsp;</td>
                        <td data-title="IP"><?php echo h($dispositivo->endereco_ip) ?>&nbsp;</td>
                        <td data-title="Int.Rede"><?php echo h($dispositivo->rede->nome); ?>&nbsp;</td>
                         <td data-title="Atualizado"><?php echo h(substr($dispositivo->data_cadastro,0,10)) ?>&nbsp;</td>
                        <td data-title="Atualizado"><?php echo h(substr($dispositivo->data_validade,0,10)) ?>&nbsp;</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($dispositivos->isEmpty()  && !empty($url) ):?>
              	<div class="panel-body">
	            	<div class="alert alert-warning" style="margin-bottom: 0">Nenhum registro encontrado.</div>
	            </div>
            <?php endif;?>
 </div>
 </div>
            
            <div class="panel-footer"> 
            	<div class="row ">
                  
                   <div class="col col-xs-8 ajax-pagination" style=" line-height: 40px;height: 40px;" >
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
                     <div class="btn-group pagination hidden-xs hidden-sm dropup">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <?php echo $active? $active : 15;?> / pág. <span class="caret"></span>
									  </button>
									 <ul class="dropdown-menu " style="min-width: 0px">
									 	<?php 
											foreach($paginas as $pag ){
												if($pag==$active){
													$class= 'active disabled';
												}
												echo "<li >" . $this->Html->link($pag, ['action'=>'index', '?' => ['limit' => $pag]],['class'=>' ']) . "</li>";
											}  
										?>
									  </ul>
									  
						</div> &nbsp;
						<small class="hidden-xs hidden-sm" >
	                 <?php echo $this->Paginator->counter(
								    'Página {{page}} de {{pages}} - Total: {{count}} registro(s)'
								);
		             ?>
		                </small>
				
                    </div>
                  </div>
                   <div class="col col-xs-4" style=" line-height: 40px;height: 40px;" >
                   	 <div class="btn-group pagination dropup pull-right">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-export"></span>
									  </button>
									 <ul class="dropdown-menu " style="min-width: 0px">
									 <li><?php echo $this->Html->link(''.__('Enviar E-mail (todos)'), ['action'=>'index', '?' => ['export' => 'mail']], ['class'=>'','escape' => false]);	?></li>
									 	<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'index', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
									  </ul>
									  
						</div>
                   </div>
                   
                </div>
							
            </div>       
    </div>
</div>
