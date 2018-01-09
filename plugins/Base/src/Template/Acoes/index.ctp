

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="acoes index large-9 medium-8 columns content"> 
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
             					<?php echo $this->Form->input('filtro_sistema', ['label'=>'Sistema','options'=>$sistemas, 'empty'=>'-- Todos --']) ?>
                                <?php echo $this->Form->input('filtro_prefix', ['label'=>'Projeto']) ?>
                                <?php echo $this->Form->input('filtro_controller', ['label'=>'Controller']) ?>
                                <?php echo $this->Form->input('filtro_action', ['label'=>'Action']) ?>
                                <?php echo $this->Form->input('filtro_tipo', ['label'=>'Tipo','options'=>$tipos, 'empty'=>'-- Todos --']) ?>
                                <?php echo $this->Form->input('filtro_ativo', ['label'=>'Status', 'options'=>[false=>'Inativo',true=>'Ativo'], 'empty'=>'-- Todos --' ]) ?>
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
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Nova Ação'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('Ações') ?> <small>Listagem</small></h3>
        </div>

        <div id="PanelBody" class="panel-body" style="position:relative;">  
        <div id="loader" ></div> 
            <table class="table table-hover tree" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                                                <th class="ajax-pagination">Ação</th>
                                                <th class="ajax-pagination">Tipo</th>
                                                <th class="ajax-pagination">Status</th>
                                                <th class="ajax-pagination">Grupos</th>
                                                <th class="actions">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    
                    $atual_sistema = "";
                    $atual_prefix = "";
                    $atual_controller = "";
                    
                    foreach ($acoes as $acao):
                    
                    $class="";
                    if(!$acao->ativo)
                    	$class= 'text-danger';
                    
                    ?>
                  
					
					<?php
						if($atual_sistema!=$acao->sistema_id):
					
					?>
					 <tr class="treegrid-<?php echo $acao->sistema_id; ?> treegrid-parent-" >
					 	<td colspan="6"> &nbsp; <b><?php echo h($acao->sistema->nome) ?></b></td>
                     </tr>                        
					<?php 
					$atual_sistema=$acao->sistema_id;
					endif; ?>
					
					<?php
						if($atual_prefix!=$acao->prefix):
					
					?>
					 <tr class="treegrid-<?php echo $acao->prefix; ?> treegrid-parent-<?php echo $acao->sistema_id; ?>" >
					 	<td colspan="6"> &nbsp; <b><?php echo h($acao->prefix) ?></b></td>
                     </tr>                        
					<?php 
					$atual_prefix = $acao->prefix;
					endif; ?>
					
					<?php
						if($atual_controller!=$acao->controller):
					
					?>
					 <tr class="treegrid-<?php echo $acao->controller; ?> treegrid-parent-<?php echo $acao->prefix; ?>" >
					 	<td colspan="6"><b> &nbsp; <?php echo h($acao->controller) ?></b></td>
                     </tr>                        
					<?php 
						$atual_controller = $acao->controller;
					endif; ?>
					
                    <tr class="treegrid-<?php echo $acao->id; ?> treegrid-parent-<?php echo $acao->controller; ?> <?php echo $class; ?>" >
                                                <td><?php echo h($acao->descricao) ?> &nbsp; <small><?php echo h($acao->prefix) ?>/<?php echo h($acao->controller) ?>/<?php echo h($acao->action) ?></small></td>
                                                <td><?php echo h($acao->tipo) ?></td>
                                                <td><?php echo ($acao->ativo? $this->Html->label('ATIVA','info'): $this->Html->label('INATIVA','danger')) ?></td>
                                                <td>
	                                                <?php 
															foreach($acao->grupos as $grupo){
																echo $this->Html->label($grupo->descricao, $grupo->ativo ? 'default': 'danger' )." ";	
															}
													?>
                                                </td>
                                                
                                                <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $acao->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $acao->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $acao->id], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $acao->id], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $acao->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($acoes->isEmpty()  && !empty($url) ):?>
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
					<button  class="btn btn-default btn-sm"  rel="popover" data-placement="right" data-popover-content="#myPopoverPag" data-container="body" data-toggle="popover"><?php echo $active? $active : 100;?></button>
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
                    <?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false]) ?>
                </ul>              
            </div>
             </div>       
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('.tree').treegrid({
    	 expanderExpandedClass: 'glyphicon glyphicon-minus',
         expanderCollapsedClass: 'glyphicon glyphicon-plus'
    });
  });
</script>