

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
            	<?php echo $this->Form->input('filtro_sistema', ['label'=>'Sistema','options'=>$sistemas,'empty'=>'todos']) ?>          
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
                                url: '<?php echo $this->Url->build([ "action" => "listar"]);?>',
                                
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Usuário'), ['action' => 'cadastrar'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Usuários') ?> <small>Listagem</small></h3>
        </div>

        <div id="PanelBody" class="panel-body" style="position:relative;">  
        <div id="loader" ></div> 
            <table class="table table-hover" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>						
                    							<th class="ajax-pagination"><?php echo $this->Paginator->sort('sistema_id') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('nome') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('login') ?></th>
                                                <th class="ajax-pagination"><?php echo $this->Paginator->sort('ativo','Status') ?></th>
                                                <th class="ajax-pagination">Perfil</th>
                                                <th class="actions">&nbsp;</th>
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
                     							<td><?php echo h($usuario->sistema->nome) ?></td>
                                                <td><?php echo h($usuario->nome) ?></td>
                                                <td><?php echo h($usuario->login) ?></td>
                                                <td><?php echo ($usuario->ativo ? $this->Html->label('ATIVO', 'info'):$this->Html->label('INATIVO', 'danger')) ?></td>
                                                <td>
                                                	<?php 
														foreach($usuario->grupos as $grupo){
															echo $this->Html->label($grupo->descricao, $grupo->ativo ? 'default': 'danger' )." ";	
														} 
													?>
                                                
                                                </td>
                                                <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $usuario->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $usuario->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $usuario->id], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $usuario->id], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $usuario->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($usuarios->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>
 </div>
            
            <div class="panel-footer"> 
				<button  class="btn btn-default btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopoverExport" data-container="body" data-toggle="popover"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></button>
				<div id="myPopoverExport" class="hide">
						<?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'index', '?' => ['export' => 'csv']], ['class'=>'btn btn-primary btn-block','escape' => false]);	?>  
				</div>
				
            <div class="paginator ajax-pagination">
                <ul class="pagination pagination-sm">
                
					<?php 
						$paginas = [15,25,50,75,100];
						$active = $this->Paginator->param('limit');
					?>
					 &nbsp;
					<button  class="btn btn-default btn-sm"  rel="popover" data-placement="right" data-popover-content="#myPopoverPag" data-container="body" data-toggle="popover"><?php echo $active? $active : 15;?></button>
					<div id="myPopoverPag" class="hide">
							<?php 
								
								foreach($paginas as $pag ){
									$class = 'btn-default';
									if($pag==$active){
										$class= ' btn-primary active disabled';
									}
									echo $this->Html->link($pag, ['action'=>'index', '?' => ['limit' => $pag]],['class'=>'btn  '.$class]) . " ";
								}  
							?>
					</div>
                		<li> 
						 <small>
						 
	               		<?php echo $this->Paginator->counter(
							    '{{page}}/{{pages}} - Total: {{count}}'
							);
	               		?>
	               		
	               		</small>
	               		</li>
                
                    <?php echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false]) ?>
                    <?php echo $this->Paginator->numbers() ?>
                    <?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false, 'style'=>'font-family:monospace']) ?>
                </ul>              
            </div>
            </div>       
    </div>
</div>

