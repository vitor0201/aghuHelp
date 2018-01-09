

<?php // $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="menus index large-9 medium-8 columns content"> 
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo Menu'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Menus') ?> <small>Listagem</small></h3>
        </div>

        <div id="PanelBody">  
        <div id="no-more-tables" >
            <table class="table tree table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    							
                                                <th class="ajax-pagination">Menu Item</th>
                                                <th class="ajax-pagination">Ativo</th>
                                                <th class="actions">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($menus as $menu):
                    
                    $id = "treegrid-".$menu->id;
                    $parent_id = "treegrid-parent-".$menu->parent_id;
                    
                    $class="$id $parent_id";
                    
                    if(!$menu->ativo)
                    	$class.=" text-danger";
                    
                    
                    ?>
                    <tr class="<?php echo $class?>" >
                    
                                             
                                                <td>&nbsp;&nbsp; <?php echo h($menu->descricao) ?> &nbsp;
                                                		 <small>
                                                			<?php if($menu->acao) echo h("(".$menu->acao->descricao.")") ?> <?php if($menu->acao) echo h($menu->acao->prefix) ?>/<?php if($menu->acao) echo h($menu->acao->controller) ?>/<?php if($menu->acao) echo h($menu->acao->action) ?>
                                                		</small>
                                                </td>
                                                <td><?php echo ($menu->ativo? $this->Html->label('ATIVO','info'): $this->Html->label('INATIVO','danger')) ?></td>
                                                 <td class="action">
                    	
						                    		<div class="btn-group ">
															  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
															  </button>
															 <ul class="dropdown-menu ">
															    <li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $menu->id], ['escape' => false]); ?></li>
															    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $menu->id], ['escape' => false]); ?></li>
															   <li role="separator" class="divider"></li>
																<li><?php echo $this->Html->link('Mover p/ Cima', ['action' => 'moveUp', $menu->id], ['class'=>'', 'escape' => false]) ?></li>
								  								<li><?php echo $this->Html->link('Mover p/ Baixo', ['action' => 'moveDown', $menu->id], ['class'=>'', 'escape' => false]) ?></li>
															   
															    <li role="separator" class="divider"></li>
															    <li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $menu->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
															  </ul>
													</div>
												</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
              <?php if($menus->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	
            <?php endif;?>
 </div>
             
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.tree').treegrid({
     
    });
  });
</script>