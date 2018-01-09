

<?php //$this->Paginator->options(['url' => $url]); 


 

?>

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
           // $this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal'=>true]); ?>

            <div class="panel-body">                
            	<?php echo $this->Form->input('filtro1', ['label'=>'Nome']) ?>
            	<?php echo $this->Form->input('filtro2', ['label'=>'Login']) ?>
            	<?php echo $this->Form->input('filtro3', ['label'=>'Status', 'options'=>$status, 'empty'=>'-- Todos --' ]) ?>
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
                                url: '<?php echo $this->Url->build([ "action" => "ldap_users"]);?>',
                                
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
            
            <h3><?php echo __('Usuarios LDAP/AD') ?> <small>Listagem</small></h3>
        </div>

        <div id="PanelBody" class="panel-body" style="position:relative;">  
        <div id="loader" ></div> 
            <table class="table table-hover" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                                                <th class="ajax-pagination">Nome</th>
                                                <th class="ajax-pagination">Login</th>
                                                <!--<th class="ajax-pagination">E-mail</th> -->
                                                <th class="ajax-pagination">Status</th>
                                                
                                                <th class="actions">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($ldap_users)):?>
                    <?php
                    $i = 0;
                    foreach ($ldap_users as $usuario):
                    
                    $num = $usuario->getUserAccountControl();
                    
                    $sts = [];
                   
                    foreach ($status as $key => $s){ 
                    	if($num & $key) 
                    		$sts[$key] = $status[$key];
                    
                    	
                    		
                    }
                    $class="";
                    foreach($sts as $key => $st)
                    	if(in_array($key, $inactive_status))
                    		$class='class="text-danger"';
                    
                    
                   // debug($usuario);
                    ?>
                    			<tr <?php echo $class; ?>>
                                                <td><?php echo h($usuario->getDisplayName()) ?></td>
                                                <td><?php echo h($usuario->samaccountname[0]); ?></td>
                                                <!-- <td><?php echo h($usuario->mail[0]) ?></td> -->
                                                <td><?php //echo h($usuario->useraccountcontrol[0]) ?>
                                                <?php 
                                                	foreach($sts as $key => $st){
                                                		if(in_array($key, $inactive_status))
                                                			echo $this->Html->label($st, 'danger')." " ;
                                                		else
                                                			echo $this->Html->label($st, 'info'). " " ;
                                                	}
                                                	?>
                                                </td>
                                                
                                <td>
                       		<!-- 
                            <a href="#" class="btn btn-info btn-xs pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $usuario->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $usuario->id ?>" class="hide">
								  <?php //echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $usuario->id], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php //echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $usuario->id], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php //echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $usuario->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
							 -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
              <?php if(!isset($ldap_users) || !$ldap_users->count()):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>
 </div>
            
            <div class="panel-footer"> 
              <?php if(isset($ldap_users)): ?>
				<button  class="btn btn-default btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopoverExport" data-container="body" data-toggle="popover"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></button>
				<div id="myPopoverExport" class="hide">
						<?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'ldap_users', '?' => ['export' => 'csv']], ['class'=>'btn btn-primary btn-block','escape' => false]);	?>  
				</div>
				
            <div class="paginator ajax-pagination">
          
					<?php 
						$active = $ldap_users->getPerPage();
						$paginas = [15,25,50,75,100];
						
					?>
					
					<div id="myPopoverPag" class="hide">
							<?php 
								
								foreach($paginas as $pag ){
									$class = 'btn-default';
									if($pag==$active){
										$class= ' btn-primary active disabled';
									}
									echo $this->Html->link($pag, ['action'=>'ldap_users', '?' => ['limit' => $pag]],['class'=>'btn  '.$class]) . " ";
								}  
							?>
					</div>
                <?php 
                
               
                
                $paginas = [];
                $i= $ldap_users->getCurrentPage();
                
                $max =  $i+5 > $ldap_users->getPages() ? $ldap_users->getPages() : $i+5;
                $min = 	$i-5 < 0 ? 0 : $i-5;
                
                
                $paginas[] = $this->Html->link($this->Html->icon('step-backward'),['action'=>'ldap_users', '?' => ['page' => 0]],['class'=>'btn btn-default btn-sm', 'escape'=>false]);
                
                for($k=$min;  $k<$max ; $k++){
					$class="btn-default";
					if($i==$k)
						$class="btn-primary";
					$paginas[] = $this->Html->link($k+1,['action'=>'ldap_users', '?' => ['page' => $k]],['class'=>'btn btn-sm '.$class]);
				}
                
				$paginas[] = $this->Html->link($this->Html->icon('step-forward'),['action'=>'ldap_users', '?' => ['page' => $ldap_users->getPages()-1]],['class'=>'btn btn-sm btn-default', 'escape'=>false]);
				
				
				$btn_pages[] = $this->Form->button('Exibir: '.$active, ['class'=>'btn btn-default btn-sm', 'rel'=>'popover', 'data-placement'=>"right" ,'data-popover-content'=>"#myPopoverPag", 'data-container'=>"body" ,'data-toggle'=>"popover"]);
				
                echo $this->Form->buttonToolbar([
                		$this->Form->buttonGroup($paginas),
						$this->Form->buttonGroup($btn_pages),
						$this->Form->buttonGroup(["<p><small>Total: ".$ldap_users->count()."</small></p>"])
                		]) ;
                
                
                ?>
                
               

                <?php //echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false]) ?>
                    <?php //echo $this->Paginator->numbers() ?>
                    <?php //echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false]) ?>
                           
            
            </div>
            <?php endif; ?>
            </div>       
    </div>
</div>


