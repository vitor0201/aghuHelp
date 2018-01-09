<?php 
//debug($url);
if(isset($procedimentos)): ?>
<script type="text/javascript">
var response = new Array();

</script>

    <div class="modal-content" id="ModalAjaxContent">
     
     
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="medical-medical84"></span>  <?php echo __('Procedimentos') ?> <small>aghu</small></h4>
      </div>
      <div class="modal-body" id="PanelBody">
    
    <div id="" class="">
            <?php
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilterProcedimentos',  
            		'inline' => true,
'cols' => [
		    		'label' => 2,
		    		'input' => 5,
		    		'error' => 6
		    	]]); ?>
				<?php 
				
				?>
                <?php echo $this->Form->input('filtro2', ['id'=>'FiltroNomeProcedimento','placeholder'=>'Descrição', 'label'=>false]) ?>
                <?php echo $this->Form->input('filtro1', ['id'=>'FiltroCodigoProcedimento','placeholder'=>'Código', 'label'=>false]);?>
            	
            	<?php echo $this->Form->button('Buscar', ['id'=>'FormFilterProcedimentoSubmit','class' => 'btn-primary']) ?>
            	<?php //echo $this->Form->input('filtro3', ['label'=>false, 'options'=>$status, 'empty'=>'-- escolha --' ]) ?>
                <?php //echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm ']); ?>
           

            <?php echo $this->Form->end(); ?>
           
             <script>
                jQuery("#FormFilterProcedimentoSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                                type:'POST',
                                async: true,
                                cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "procedimentos"]);?>',
                                
                                beforeSend: function(response) {
                                    jQuery('#PanelBody').fadeTo(300,0);
                                },
                                success: function(response) {
                                    jQuery('#ModalAjaxContent').html(response);
                                    jQuery('#PanelBody').fadeTo(100, 1);
                                },
                                data:jQuery('#FormFilterProcedimentos').serialize()
                            });
                            return false;
                        }
                );
            </script>
        </div>
            <table class="table table-hover table-condensed" cellpadding="0" cellspacing="0" style="margin-bottom: 5px">
                <thead>
                    <tr>
                    							<th class="ajax-pagination">Procedimento</th>
                                                <th class="ajax-pagination">Código</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    $i = 0;
                    foreach ($procedimentos as $procedimento):
                
                    $class="";
                    
//                     debug($medico);
                   
                    ?>
                    			<tr <?php echo $class; ?> style="cursor: pointer" id="response_<?php echo $i;?>">
                                                <td><?php echo h($procedimento->descricao); ?></td>
                                                <td><?php echo h($procedimento->cod_tabela) ?>
                                               	<script type="text/javascript">
												
                                                	
													
                                                	$( "#response_<?php echo $i;?>" ).click(function() {
                                                		ModalResponse({
    														'descricao':  '<?php echo str_replace(['"',"'","\\"],"", $procedimento->descricao); ?>',
    														'codigo': '<?php echo str_replace(['"',"'","\\"],"", $procedimento->cod_tabela); ?>',
    														'situacao': '<?php echo str_replace(['"',"'","\\"],"", $procedimento->ind_situacao); ?>',
    														'sexo': '<?php echo str_replace(['"',"'","\\"],"", $procedimento->sexo); ?>',
    														'idade_min': '<?php echo str_replace(['"',"'","\\"],"", $procedimento->idade_min); ?>',
    														'idade_max': '<?php echo str_replace(['"',"'","\\"],"", $procedimento->idade_max); ?>',

                                                            	});
                                                	});
                                                	
                                                	</script>
                                                	
                                                	
                                                </td>
                                                
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
              
                </tbody>
            </table>
              <?php if(!$procedimentos->count()):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>
<?php 

//debug($url);
//debug($this->request->query);

$anterior = $currentPage-1;
$proximo = $currentPage+1;

?>

<?php if($currentPage>1) echo $this->Html->link($this->Html->icon('chevron-left'),['action'=>'procedimentos', '?' => ['page' => ($currentPage-1)]],['class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
 
 <?php  echo $this->Html->link($this->Html->icon('chevron-right'),['action'=>'procedimentos', '?' => ['page' => ($currentPage+1)]],['class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
           <small>Página <?php echo $currentPage; ?> de <?php echo $maxPage  ?></small> 
      </div>
			
            
    </div><!-- /.modal-content -->
<script type="text/javascript">
$( "#FiltroNomePaciente" ).focus();
</script>
<?php else: ?>
  <div class="modal-content" id="ModalAjaxContent">
  <div class="modal-body" id="ModalAjaxContent">
   <?php echo $this->Flash->render() ?>
  <div ><b>Serviço temporariamente indisponível (acesso ao AGHU).</b><p>Por favor, tente novamente em alguns minutos.</p></div>
   <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
  </div>
  </div>
<?php endif; ?>