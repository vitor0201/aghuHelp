<?php 
//debug($url);
if(isset($medicos)): ?>
<script type="text/javascript">
var response = new Array();

</script>

    <div class="modal-content" id="ModalAjaxContent">
     
     
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="medical-medical84"></span>  <?php echo __('Médicos') ?> <small>aghu</small></h4>
      </div>
      <div class="modal-body" id="PanelBody">
    
    <div id="" class="">
            <?php
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilterMedicos',  
            		'inline' => true,
'cols' => [
		    		'label' => 2,
		    		'input' => 5,
		    		'error' => 6
		    	]]); ?>
				<?php 
				
				?>
                <?php echo $this->Form->input('filtro1', ['id'=>'FiltroNomeMedico','placeholder'=>'Nome', 'label'=>false]);?>
            	<?php echo $this->Form->input('filtro2', ['id'=>'FiltroCrmMedico','placeholder'=>'Nº Consenho', 'label'=>false]) ?>
            	<?php echo $this->Form->button('Buscar', ['id'=>'FormFilterMedicoSubmit','class' => 'btn-primary']) ?>
            	<?php //echo $this->Form->input('filtro3', ['label'=>false, 'options'=>$status, 'empty'=>'-- escolha --' ]) ?>
                <?php //echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm ']); ?>
           

            <?php echo $this->Form->end(); ?>
           
             <script>
                jQuery("#FormFilterMedicoSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                                type:'POST',
                                async: true,
                                cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "medicos"]);?>',
                                
                                beforeSend: function(response) {
                                    jQuery('#PanelBody').fadeTo(300,0);
                                },
                                success: function(response) {
                                    jQuery('#ModalAjaxContent').html(response);
                                    jQuery('#PanelBody').fadeTo(100, 1);
                                },
                                data:jQuery('#FormFilterMedicos').serialize()
                            });
                            return false;
                        }
                );
            </script>
        </div>
            <table class="table table-hover table-condensed" cellpadding="0" cellspacing="0" style="margin-bottom: 5px">
                <thead>
                    <tr>
                    							<th class="ajax-pagination">Nome</th>
                                                <th class="ajax-pagination">CRM</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    $i = 0;
                    foreach ($medicos as $medico):
                
                    $class="";
                    
//                     debug($medico);
                   
                    ?>
                    			<tr <?php echo $class; ?> style="cursor: pointer" id="response_<?php echo $i;?>">
                                                <td><?php echo h($medico->nome); ?></td>
                                                <td><?php echo h($medico['q']['nro_reg_conselho']) ?>
                                               	<script type="text/javascript">
												
                                                	
													
                                                	$( "#response_<?php echo $i;?>" ).click(function() {
                                                		ModalResponse({
    														'nome':  '<?php echo str_replace(['"',"'","\\"],"", $medico->nome); ?>',
    														'crm': '<?php echo $medico['q']['nro_reg_conselho']; ?>',
    														'cpf': '<?php echo $medico->cpf; ?>',
    														'dt_nascimento': '<?php echo $medico->dt_nascimento; ?>',
    														'sexo': '<?php echo $medico->sexo; ?>',

                                                            	});
                                                	});
                                                	
                                                	</script>
                                                	
                                                	
                                                </td>
                                                
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
              
                </tbody>
            </table>
              <?php if(!$medicos->count()):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	<script> /*jQuery('#FilterCollapse').click();*/ </script>
            <?php endif;?>
<?php 

//debug($url);
//debug($this->request->query);

$anterior = $currentPage-1;
$proximo = $currentPage+1;

?>

<?php if($currentPage>1) echo $this->Html->link($this->Html->icon('chevron-left'),['action'=>'medicos', '?' => ['page' => ($currentPage-1)]],['class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
 
 <?php  echo $this->Html->link($this->Html->icon('chevron-right'),['action'=>'medicos', '?' => ['page' => ($currentPage+1)]],['class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
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