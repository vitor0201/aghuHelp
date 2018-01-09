

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="usuarios index large-9 medium-8 columns content"> 
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
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal' => true,
'cols' => [
		    		'label' => 2,
		    		'input' => 3,
		    		'error' => 4
		    	]]); ?>

            <div class="panel-body">      
            	<?php //echo $this->Form->input('filtro_sistema', ['label'=>'Sistema','options'=>$sistemas,'empty'=>'todos']) ?>          
				<?php echo $this->Form->input('filtro_nome', ['label'=>'Nome']) ?>
            	<?php echo $this->Form->input('filtro_login', ['label'=>'Login']) ?>
            	<?php echo $this->Form->input('filtro_status', ['label'=>'Status', 'options'=>[false=>'Inativo',true=>'Ativo'], 'empty'=>'-- Todos --' ]) ?>
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Usuário'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Usuários') ?> <small>Listagem</small></h3>
        </div>

        <div id="PanelBody" >  
       <div id="no-more-tables" >
            <table class="table   table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>						
                    							<th class="actions " width="80px">&nbsp;</th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('nome') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('login') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('ativo','Status') ?></th>
                                                <th class="ajax-pagination">Perfil</th>
                                              
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($usuarios as $usuario):
                    $class="";
                    if(!$usuario->ativo)
                    	$class="class='text-danger'";
                  
                    ?>
                    
                    <tr <?php echo $class; ?>>
                     							<td class="action">
						                    		<div class="btn-group ">
															  <button type="button" class="btn btn-info  btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
															  </button>
															 <ul class="dropdown-menu ">
															    <li>
															    <?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $usuario->id], ['escape' => false]); ?></li>
															    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $usuario->id], ['escape' => false]); ?></li>
															   
															    <li role="separator" class="divider"></li>
															    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span> '.__(' Remover'), ['action' => 'delete', $usuario->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
															  </ul>
													</div>
							
                                                
						                        </td>
                                                <td data-title="Nome"><?php echo h($usuario->nome) ?></td>
                                                <td data-title="Login"><?php echo h($usuario->login) ?></td>
                                                <td data-title="Status"><?php echo ($usuario->ativo ? $this->Html->label('ATIVO', 'info'):$this->Html->label('INATIVO', 'danger')) ?></td>
                                                <td data-title="Perfil">
                                                	<?php 
														foreach($usuario->grupos as $grupo){
															echo $this->Html->label($grupo->descricao, $grupo->ativo ? 'default': 'danger' )." ";	
														} 
													?>
                                                
                                                </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
              <?php if($usuarios->isEmpty()  && !empty($url) ):?>
              <div class="panel-body">
            	<div class="alert alert-warning" style="margin-bottom: 0">Nenhum registro encontrado.</div>
            	<script> jQuery('#FilterCollapse').click(); </script>
            </div>
            <?php endif;?>
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
									 	<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'index', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
									  </ul>
									  
						</div>
                   </div>
                  
                    
                </div>
            </div>       
    </div>
</div>

