<?php if(isset($ldap_users)): ?>
<script type="text/javascript">
var response = new Array();

</script>

    <div class="modal-content" id="ModalAjaxContent">
     
     
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Usuarios LDAP/AD') ?> <small class="hidden-sm hidden-xs">Listagem</small></h4>
      </div>
      <div class="modal-body" id="PanelBody">
    
    <div id="" class="">
            <?php
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter',  
'cols' => [
		    		'label' => 2,
		    		'input' => 8,
		    		'error' => 6
		    	]]); ?>
				<?php 
				
				?>
                      
            	<?php echo $this->Form->input('filtro1', ['id'=>'FiltroNomeInput','required'=>'required','placeholder'=>'Nome do usuário', 'label'=>false, 'append'=>$this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn-primary'])]) ?>
            	<?php // echo $this->Form->input('filtro3', ['label'=>'Status', 'options'=>$status, 'empty'=>'-- Todos --' ]) ?>
            	<?php //echo $this->Form->input('filtro3', ['label'=>false, 'options'=>$status, 'empty'=>'-- escolha --' ]) ?>
                <?php //echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm ']); ?>
           

            <?php echo $this->Form->end(); ?>
            
             <script>
                jQuery("#FormFilterSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                                type:'POST',
                                async: true,
                                cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "lookup_ldap_users"]);?>',
                                
                                beforeSend: function(response) {
                                    jQuery('#PanelBody').fadeTo(300,0);
                                },
                                success: function(response) {
                                    jQuery('#ModalAjaxContent').html(response);
                                    jQuery('#PanelBody').fadeTo(100, 1);
                                },
                                data:jQuery('#FormFilter').serialize()
                            });
                            return false;
                        }
                );
            </script>
        </div>
 		<div id="no-more-tables" >        
            <table class="table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0" style="margin-bottom: 5px">
                <thead>
                    <tr>
                                                <th class="ajax-pagination">Nome</th>
                                                <th class="ajax-pagination">Login</th>
                                                <th class="ajax-pagination">Status</th>
                    </tr>
                </thead>
                <tbody>
                
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
                    			<tr <?php echo $class; ?> style="cursor: pointer" id="response_<?php echo $i;?>">
                                                <td data-title="Nome"><?php echo h($usuario->getDisplayName()) ?></td>
                                                <td data-title="Login"><?php echo h($usuario->samaccountname[0]); ?></td>
                                                <td data-title="Status"><?php //echo h($usuario->useraccountcontrol[0]) ?>
                                                <?php 
                                                $ativo = true;
                                                	foreach($sts as $key => $st){
                                                		if(in_array($key, $inactive_status))
                                                			$ativo = false;
                                                			//echo $this->Html->label($st, 'danger')." " ;
                                                			//echo $this->Html->label($st, 'info'). " " ;
                                                	}
                                                	echo  $this->Html->label(($ativo?'ATIVO':'INATIVO'), ($ativo? 'info' : 'danger'));
                                                	?>
                                                	
                                                	<script type="text/javascript">
												
                                                	

                                                	$( "#response_<?php echo $i;?>" ).click(function() {
                                                		ModalResponse({
    														'login': '<?php echo str_replace(['"',"'","\\"],"",$usuario->samaccountname[0]); ?>', 
    														'nome':  '<?php echo str_replace(['"',"'","\\"],"", $usuario->getDisplayName()); ?>',
    														'ativo': <?php echo $ativo ? 'true': 'false'; ?>
                                                            	});
                                                	});
                                                	
                                                	</script>
                                                	
                                                	
                                                </td>
                                                
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
              
                </tbody>
            </table>
            </div>
              <?php if(!$ldap_users->count()):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>

      
			
			<div class="row" >
                  
                   <div class="col col-xs-12" style="line-height: 40px;height: 40px;" >
                   <div class="btn-toolbar" role="toolbar" >
                   
                    <div class="btn-group">
                    <ul class="pagination pagination-sm">
                        <?php //echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false]) ?>
                    	<?php //echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false]) ?>
        
                        <?php 
                        $class="";
                        if($ldap_users->getCurrentPage()==0)
                        	$class = "disabled";
                        
                        echo "<li>".$this->Html->link($this->Html->icon('chevron-left'),['action'=>'lookupLdapUsers', '?' => ['page' => $ldap_users->getCurrentPage()-1]],['class'=>' ajax-link '.$class,'data-target'=>'#ModalAjaxContent', 'escape'=>false]) ."</li>"; ?>
                    	
                    	<?php  echo "<li>".$this->Html->link($ldap_users->getCurrentPage()+1,['action'=>'lookupLdapUsers', '?' => ['page' => $ldap_users->getCurrentPage()]],['class'=>' ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false])."</li>";?>
                    	  
                    	<?php
                    	$class=""; 
                    	if($ldap_users->getCurrentPage()==$ldap_users->getPages()-1)
                    		$class = "disabled";
                    	
                    	echo "<li>".$this->Html->link($this->Html->icon('chevron-right'),['action'=>'lookupLdapUsers', '?' => ['page' => $ldap_users->getCurrentPage()+1]],['class'=>' ajax-link '. $class,'data-target'=>'#ModalAjaxContent', 'escape'=>false])."</li>"; ?>
                    	
                    			
		
                    </ul>
                    </div>
	                   <?php 
							$paginas = [5,10];
							$active = $ldap_users->getPerPage();
							

						?>
						<!-- 
                     <div class="btn-group  hidden-xs hidden-sm dropup">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <?php echo $active? $active : 15;?> / pág. <span class="caret"></span>
									  </button>
									 <ul class="dropdown-menu " style="min-width: 0px">
									 	<?php 
											foreach($paginas as $pag ){
												$class="";
												if($pag==$active){
													$class= 'active disabled';
												}
// 												echo "<li >" . $this->Html->link($pag, ['action'=>'index', '?' => ['limit' => $pag]],['class'=>' ']) . "</li>";
												echo "<li >" . $this->Html->link($pag, ['action'=>'lookupLdapUsers', '?' => ['limit' => $pag]],['class'=>'ajax-link btn  '.$class,'data-target'=>'#ModalAjaxContent']) . "</li>";
											}  
										?>
									  </ul>
									  
						</div> &nbsp;
						 -->  &nbsp; 
						<small class="hidden-xs hidden-sm" >
	                 <?php echo "Total: " . $ldap_users->count() . ' / Páginas: '. $ldap_users->getPages();
		             ?>
		                </small>
				
                    </div>
                  </div>
                    
                </div>
                
			
		</div>	
			
           
    </div><!-- /.modal-content -->
<script type="text/javascript">
$( "#FiltroNomeInput" ).focus();
</script>
<?php else: ?>
  <div class="modal-content" id="ModalAjaxContent">
  <div class="modal-body" id="ModalAjaxContent">
   <?php echo $this->Flash->render() ?>
  <div ><b>Serviço temporariamente indisponível.</b><p>Por favor, tente novamente em alguns minutos.</p></div>
   <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
  </div>
  </div>
<?php endif; ?>