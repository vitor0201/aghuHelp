

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="mensagens index large-9 medium-8 columns content"> 
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
		    		'input' => 3,
		    		'error' => 4
		    	]]); ?>

            <div class="panel-body">                
            	
                                <?php echo $this->Form->input('fone') ?>
                                <?php echo $this->Form->input('login') ?>
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Mensagem'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Mensagens') ?> <small>Enviadas</small></h3>
        </div>
		<div id="no-more-tables" >
        <div id="PanelBody" >  
        
            <table class="table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    	<th class="actions">&nbsp;</th>
                                             
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('fone') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('data_hora') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('login') ?></th>
                                                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($mensagens as $mensagem):
                    $class="";
                    //if(!$mensagem->ativo)
                    //	$class="class='text-danger'";
                    
                    ?>
                    <tr <?php echo $class;?>>
                   		                    	<td class="action">
                    	
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $mensagem->id], ['escape' => false]); ?></li>
									    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $mensagem->id], ['escape' => false]); ?></li>
									   
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $mensagem->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									  </ul>
							</div>
						</td>
                                                   <td data-title="fone"><?php echo h($mensagem->fone) ?>&nbsp;</td>
                                                <td data-title="data_hora"><?php echo h($mensagem->data_hora) ?>&nbsp;</td>
                                                <td data-title="login"><?php echo h($mensagem->login) ?>&nbsp;</td>
                                                 
                        <!-- 
                        <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $mensagem->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $mensagem->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $mensagem->id], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $mensagem->id], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $mensagem->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
                        </td>
                         -->
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($mensagens->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            <?php endif;?>
 </div>
 </div>
            
            <div class="panel-footer"> 
            	<div class="row ">
                  <div class="ajax-pagination">
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
								    'Página {{page}} de {{pages}} - Total: {{pages}} registro(s)'
								);
		             ?>
		                </small>
				
                    </div>
                    </div>
                  </div>
                   <div class="col col-xs-4" style=" line-height: 40px;height: 40px;" >
                   	 <div class="btn-group dropup pull-right">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-export"></span>
									  </button>
									 <ul class="dropdown-menu " style="min-width: 0px">
									 	<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'index', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
									  </ul>
									  
						</div>
                   </div>
                   
                </div>
							
            </div>       
    </div>
</div>

