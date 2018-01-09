

<?php  $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="grupos index large-9 medium-8 columns content"> 
<?php //echo date('d/m/Y H:i:s') ; ?>
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="FilterCollapse" class="collapsed" data-target="#collapseOne">
                   Filtro <?php if(!empty($url)):?><span class="badge">aplicado</span> <?php endif;?>
                </a>
            </h4>
        </div>
        
        <div id="collapseOne" class="panel-collapse collapse ">
            <?php
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal'=>true, 'cols' => ['label' => 2,'input' => 3,'error' => 6 	]]); ?>

            <div class="panel-body">      
            	<?php echo $this->Form->input('filtro_sistema', ['label'=>'Sistema','options'=>$sistemas, 'empty'=>'-- Todos --']) ?>     
            	<?php echo $this->Form->input('filtro_descricao', ['label'=>'Descrição']); ?>
				<?php echo $this->Form->input('filtro_ativo', ['label'=>'Status', 'options'=>[0=>'Inativo',1=>'Ativo'], 'empty'=>'-- Todos --']); ?>
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
                                    
                                    jQuery('#PanelBody').fadeTo(300,0, function() { jQuery('#loader').show(); });
                                },
                        
                                success: function(response) {
                                    
                                    jQuery('#AjaxContent').html(response);
                                    jQuery('#loader').hide();
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Grupo'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Grupos') ?> <small> Listagem </small></h3>
        </div>

        <div id="PanelBody" >  
      	<div id="no-more-tables" >
            <table class="table   table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    							<th class="actions " width="80px">&nbsp;</th>
                    							 <th class="ajax-pagination "><?php echo $this->Paginator->sort('sistema_id','Sistema') ?></th>
                                                <th class="ajax-pagination "><?php echo $this->Paginator->sort('descricao','Descrição') ?></th>
                                                <th class="ajax-pagination "><?php echo $this->Paginator->sort('sigla') ?></th>
                                                <th class="ajax-pagination "><?php echo $this->Paginator->sort('ativo') ?></th>
                                               
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($grupos as $grupo):
                    ?>
                    <?php 
                    $class="";
                    if(!$grupo->ativo)
                    	$class="class='text-danger'";
                    ?>
                    <tr <?php echo $class?>>
						                    <td class="action">
						                    		<div class="btn-group ">
															  <button type="button" class="btn btn-info  btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
															  </button>
															 <ul class="dropdown-menu ">
															    <li>
															    <?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $grupo->id], ['escape' => false]); ?></li>
															    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $grupo->id], ['escape' => false]); ?></li>
															   
															    <li role="separator" class="divider"></li>
															    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span> '.__(' Remover'), ['action' => 'delete', $grupo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
															  </ul>
													</div>
							
                                                
						                        </td>
						                        <td data-title="Descrição"><?php echo h($grupo->sistema->nome) ?></td>
                                                <td data-title="Descrição"><?php echo h($grupo->descricao) ?></td>
                                                <td data-title="Sigla"><?php echo h($grupo->sigla) ?></td>
                                                <td data-title="Ativo"><?php echo h($grupo->ativo? 'SIM': 'NÃO') ?></td>
                                                
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($grupos->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>
 		</div>
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
                   <div class="col col-xs-4" style=" line-height: 40px;height: 40px;" >
                   	 <div class="btn-group pagination dropup pull-right">
                     
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


