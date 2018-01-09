<?php 
//debug($url);
if(isset($pacientes)): ?>
<script type="text/javascript">
var response = new Array();

</script>

    <div class="modal-content" id="ModalAjaxContent">
     
     
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="medical-health3"></span>  <?php echo __('Pacientes') ?> <small>AGHU</small></h4>
      </div>
      <div class="modal-body" id="PanelBody">
    
   
            <?php
            //$this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilterPaciente',  
            		'inline' => true,
'cols' => [
		    		'label' => 2,
		    		'input' => 5,
		    		'error' => 6
		    	]]); ?>
				<?php 
				
				?>
                      <?php echo $this->Form->input('filtro2', ['id'=>'FiltroNomePaciente','placeholder'=>'Nome', 'label'=>'Nome']);?>
            	 <?php echo $this->Form->input('filtro1', ['id'=>'FiltroNomePaciente','placeholder'=>'Prontuário', 'label'=>'Prontuário']) ?>
            	<?php echo $this->Form->button('Buscar', ['id'=>'FormFilterPacienteSubmit','class' => 'btn-primary']) ?>
            	<?php //echo $this->Form->input('filtro3', ['label'=>false, 'options'=>$status, 'empty'=>'-- escolha --' ]) ?>
                <?php //echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm ']); ?>
           

            <?php echo $this->Form->end(); ?>
           
             <script>
                jQuery("#FormFilterPacienteSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                            	 type:'POST',
                                 async: true,
                                 cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "pacientes"]);?>',
                                
                                beforeSend: function(response) {
                                    jQuery('#PanelBody').fadeTo(300,0);
                                },
                                success: function(response) {
                                    jQuery('#ModalAjaxContent').html(response);
                                    jQuery('#PanelBody').fadeTo(100, 1);

                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                        	    	//$('#modalDefault').modal('hide');
                        	        swal("Erro!", "Nao foi possível carregar", "error");
                        	    },
                                data:jQuery('#FormFilterPaciente').serialize()
                            });
                            return false;
                        }
                );
            </script>
       
        	<div id="no-more-tables" class="" >
        	<br/>
            <table class="table table-striped table-condensed " cellpadding="0" cellspacing="0" style="margin-bottom: 5px">
                <thead>
                    <tr>
                    							<th  class="ajax-pagination">Prontuário</th>
                    							<th  class="ajax-pagination">Nome</th>
                                                
                                                <th class="ajax-pagination hidden-sx hidden-sm" >Mãe</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    $i = 0;
                    foreach ($pacientes as $paciente):
                
                    $class="";
                   
                    ?>
                    			<tr <?php echo $class; ?> style="cursor: pointer" id="response_<?php echo $i;?>">
                                                <td data-title="Prontuário"><?php echo h($paciente->prontuario) ?>
                                                <td class=""  data-title="Nome"><?php echo h($paciente->nome); ?></td>
                                                
                                                 <td  class="hidden-xs hiden-sm " data-title="Mãe"><?php echo h($paciente->nome_mae) ?>
                                               	<script type="text/javascript">
												
                                                	

                                                	$( "#response_<?php echo $i;?>" ).click(function() {
                                                		ModalResponse({
    														'sexo': '<?php echo str_replace(['"',"'","\\"],"",$paciente->sexo); ?>', 
    														'nome':  '<?php echo str_replace(['"',"'","\\"],"", $paciente->nome); ?>',
    														'fone_residecial':  '<?php echo str_replace(['"',"'","\\"],"", $paciente->ddd_fone_residencial); ?> <?php echo str_replace(['"',"'","\\"],"", $paciente->fone_residencial); ?>',
    														'fone_recado':  '<?php echo str_replace(['"',"'","\\"],"", $paciente->ddd_fone_recado); ?> <?php echo str_replace(['"',"'","\\"],"", $paciente->fone_recado); ?>',
    														'prontuario': '<?php echo $paciente->prontuario ?>',
    														'data_nascimento':  '<?php echo str_replace(['"',"'","\\"],"", substr($paciente->dt_nascimento,0,10)); ?>',
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
              <?php if(!$pacientes->count()):?>
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            <?php endif;?>
            
<?php 

//debug($url);
//debug($this->request->query);

$anterior = $currentPage-1;
$proximo = $currentPage+1;

?>
<div class="">
<br/>
<?php if($currentPage>1) echo $this->Html->link($this->Html->icon('chevron-left'),['action'=>'pacientes', '?' => ['page' => ($currentPage-1)]],['id'=>'ModalPreviousPage','class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
 
 <?php if($proximo<=$maxPage) echo $this->Html->link($this->Html->icon('chevron-right'),['action'=>'pacientes', '?' => ['page' => ($currentPage+1)]],['id'=>'ModalNextPage','class'=>'btn btn-sm btn-default ajax-link','data-target'=>'#ModalAjaxContent', 'escape'=>false]);?>
           <small>Página <?php echo $currentPage; ?> de <?php echo $maxPage  ?></small> 
      </div>
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