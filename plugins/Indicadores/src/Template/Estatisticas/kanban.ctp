<?php echo $this->Html->script('html2canvas.js', ['block' => true]); ?>
<?php
use Cake\I18n\Time;
use Indicadores\Model\Entity\Pendencia;
use Indicadores\Controller\PendenciasController;
?>


<div id="AjaxContent"
	class="dispositivos index large-9 medium-8 columns content">


	<div class="panel panel-default" id="panel1">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" id="FilterCollapse" class="collapsed"
					data-target="#collapseOne"> <span
					class="glyphicon glyphicon-search"></span> Filtro <?php if(!empty($url)):?><span
					class="badge">aplicado</span> <?php endif;?>
                </a>
			</h4>
		</div>

		<div id="collapseOne" class="panel-collapse collapse ">
            <?php
												// $this->Form->templates($CustomConfig['FormFilter.Template']);
												?>
                       
            <?php
												
												echo $this->Form->create ( '', [ 
														'id' => 'FormFilter',
														'horizontal' => true,
														'cols' => [ 
																'label' => 2,
																'input' => 4,
																'error' => 4 
														] 
												] );
												?>

            <div class="panel-body">                
            	
	                     		<?php echo $this->Form->input('data_internacao', ['label'=>'Data', 'id'=>'dataInternacao', 'required'=>'required'])?>
                          <script>
                          $('#dataInternacao').datetimepicker({     
                              format: 'DD/MM/YYYY ', showClear: true, useCurrent: false, showTodayButton: true ,
                              maxDate: new Date() 
                                });
                          
                          </script>
                                <?php echo $this->Form->input('unidade_id',['label'=>'Unidades','options'=>$unidades, 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%'])?>
                                <?php echo $this->Form->input('nome_paciente',['label'=>'Nome' ])?>
                                <?php echo $this->Form->input('especialidade_id',['label'=>'Especialidades','options'=>$especialidade, 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%'])?>
                              
                                <?php //echo $this->Form->input('cid',['id'=>'CidId','label'=>'CID','style'=>'color: #d9534f; font-weight: bold'])?>
                         		
                                <?php //echo $this->Form->input('sexo', ['required'=>'required','label'=>'É uma receita:','type'=>'radio', 'escape'=>false,'options'=>array('M'=>' recebida ','F'=>' a receber ')])?>
                                <?php echo $this->Form->input('sexo', ['label'=>'Sexo', 'options'=>array('M'=>'Masculino','F'=>'Feminino'),'empty'=>'-- Todos --'])?>
                            
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
                                url: '<?php echo $this->Url->build([ "action" => "kanban"]);?>',
                                
                                beforeSend: function(response) {
                                	
                                    jQuery('#FilterCollapse').click();
                                    
                                    jQuery('#PanelBody').fadeTo(300,0, function() {  });
                                },
                        
                                success: function(response) {
                                    
                                    jQuery('#AjaxContent').html(response);
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

			<!-- div class="dropdown pull-right">
				< button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo'), ['action' => 'add'], ['escape' => false]) ?></li>
				</ul>
			</div-->
			<h3><?php echo __('KANBAN') ?> <small>Pacientes Internados</small>
			</h3>

		</div>
		<div id="">
			<div id="PanelBody">

				<table class="table table-bordered table-hover " cellpadding="0"
					cellspacing="0" style="margin: 0; padding: 0; font-size: 90%; background: #FFFFFF" id="tabela" >


					<!-- TABLE HEAD -->
					<thead>
						<tr >
							<th style="border-bottom: 1px solid #A9A9A9	;" class="actions">&nbsp;</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="ajax-pagination">Paciente / Internação</th>
							<th style="border-bottom: 1px solid #A9A9A9	;">Especialidade</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="ajax-pagination">Dias</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="ajax-pagination" style="border-right: 3px solid #ddd">Pendências</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="ajax-pagination">Data</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="text-center ">Dias</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="ajax-pagination">Unidade</th>
							<th style="border-bottom: 1px solid #A9A9A9	;" class="actions">&nbsp;</th>
						</tr>
					</thead>

					<!-- TABLE BODY -->
					<tbody>
                    <?php
																				$mapa_internados = array ();
																				foreach ( $internados as $internado ) {
																					$mapa_internados [$internado->prontuario] ++;
																				}

																				
																				$i = 0;
																				$anterior = "";
																				$data_anterior = "";
																				foreach ( $internados as $internado ) :
																					$atual = $internado->prontuario;
																					
			
																					// Create from a string datetime.
																					$data_atual = new Time ( $internado ['Movimentos'] ['entrada'] );
																					//debug($data_atual);
																					if ($anterior != $atual) {
																						
																
																						
																						$data_anterior = Time::now ();
																					}
																			
																					
																					$diff = $data_anterior->diff ( $data_atual );																																				
																					$data_anterior = $data_atual;
																					$cor = "";
																					$tempo_minutos = ($diff->days * 1440) + ($diff->h * 60) + ($diff->i); // d-ay h-our i-segundos
																					                                                                      // debug($tempo_minutos);
																					foreach ( $criterios as $crit ) {
																						// debug($crit);
																						// busca criterio de tempo especifico para uma unidade
																						if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ($crit->unidade_id == $internado ['Movimentos'] ['unf_seq'])) {
																							// debug($crit);
																							$cor = $crit->cor;
																							break;
																						}
																						// busca criterio de tempo especifico para uma especialidade
																						if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ($crit->especialidade_id == $internado ['Especialidades'] ['seq'])) {
																							$cor = $crit->cor;
																							break;
																						}
																						// busca criterio de tempo que não seja especifico (geral)
																						if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ! $crit->especialidade_id && ! $crit->unidade_id) {
																							$cor = $crit->cor;
																							break;
																						}
																					}
																					
																					?>
                    
					<!-- Cria as classes para os TR -->
            		<?php ($anterior!=$atual)? $trHide = "hideOn".$internado->prontuario : $trHide = "hideOn".$internado->prontuario."b" ?>
                  		 	
                    		<tr style=" <?= ($anterior!=$atual)? "border-top: 0.22em solid #808080 ;" : "display:none;"?>" class="<?= $trHide ?>">
        
                    			
                   			<?php if($anterior!=$atual):  			?>
                   			
                   			<?php
																						// dentro do if($anterior!=$atual):
																						
																						?>
                   			
                   			<!-- BOTÃO -->
							<td>
								

								<div class="btn-group ">
									<button type="button"
										class="btn btn-xs btn-info dropdown-toggle"
										data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="glyphicon glyphicon-menu-hamburger"
											aria-hidden="true"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-form animated flipInY">
										<li><?php
																						
																						echo $this->Html->Link ( '<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; ' . __ ( 'Pendência ' ), [ 
																								'controller' => 'Pendencias',
																								'plugin' => 'Indicadores',
																								'action' => 'add',
																								$internado ['prontuario'] 
																						], [ 
																								'escape' => false 
																						] )?></li>



										<li><?php
																						
																						echo $this->Html->Link ( '<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; ' . __ ( 'Detalhes ' ), [ 
																								'controller' => 'Estatisticas',
																								'plugin' => 'Indicadores',
																								'action' => 'historico',
																								$internado->prontuario
																						], [ 
																								'escape' => false 
																						] )?></li>

									</ul>
								</div> <script>
								// Allow Bootstrap dropdown menus to have forms/checkboxes inside, 
								// and when clicking on a dropdown item, the menu doesn't disappear.
								$(document).on('click', '.dropdown-menu.dropdown-menu-form ', function(e) {
								  e.stopPropagation();
								});	
							</script>
							</td>


							<td
								
								data-title="Nome" width="35%" style="display: table-cell;">
								<div class="row">
								

									<div class="col-md-12">
										<b><?php echo h($internado->nome) ?></b> <small>(<?php echo h($internado->sexo=="M"?  'Masc.':'Fem.') ?>, <?php echo h($internado->idade) ?>)</small>
									</div>
									<div class="col-md-12">Pront. <?php echo h($internado->prontuario); ?></div>
									<!-- <div class="col-md-12">CID: <?php echo h($internado['Cids']['codigo']); ?></div>-->

									<!--<div class="col-md-12">
										<small><?php echo h($internado['Procedimentos']['descricao']);?></small>
									</div>-->
									<div class="col-md-12">Dr(a) <?php echo h($internado['Pessoas']['nome']); ?>&nbsp;</div>
								</div>
								<div class="col-md-12" style="font-weight: 900;">LEITO: <?php echo h($internado['Internacoes']['lto_lto_id']); ?></div>
							</td>

							<td
								
								data-title="Especialidade"><?php echo h($internado['Especialidades']['nome_especialidade']); ?>&nbsp;</td>
							<td
								
								data-title="Tempo" class="text-center"><?php echo $this->Html->badge(h($internado['Internacoes']['permanencia'])); ?></td>

							<!-- PENDÊNCIAS -->
							<td 
								
								data-title="Pendências">
															
							<?php
																						foreach ( $kanb as $value ) {
																							if ($value ['internacao_id'] == $internado ['prontuario'] && $value ['data_remocao'] == null) {
																								// echo $this->Html->Label($value->tipo_pendencia->descricao, 'default') . ' ';
																								echo $this->Html->link ( $value->tipo_pendencia->descricao, [ 
																										'action' => 'edit',
																										'controller' => 'Pendencias',
																										'plugin' => 'Indicadores',
																										$value->id 
																								], [ 
																									'class' => 'label label-default',
																									'style' => 'display: block; border: solid #ffffff 0.2px' 
																								] );
																								// debug($value);
																								// echo('<br>');
																							}
																						}
																						?></td>
						<?php $internado; ?>
						<?php $anterior=$atual; ?>
						<!-- Preenche as colunas em branco // as primeiras [Paciente / Internação, Especialidade, Dias, Pendências] -->
						<?php elseif($anterior==$atual):?>
						<td colspan="5" >&nbsp;</td>
						<?php endif;?>
                                                 
                   		<?php
																					// debug($crit)
																					// $datas = Time::createFromFormat('yyyy-MM-dd HH:mm:ss',$internado['Internacoes']['dthr_internacao']);
																					// $internado['Movimentos']['entrada'] 																					?>
																				
							<!-- Coluna Data -->													                      		
							<td onclick="toggle(this)" data-title="Internação" style="display: table-cell; background-color: <?php echo $cor; ?>; " >
								<?php echo substr(formatDate($internado['Movimentos']['entrada']),0,10);?> 
								<small><?php echo substr($internado['Movimentos']['entrada'],11,5)  ;?></small>
							</td>
							<!-- Coluna Dias -->
							<td onclick="toggle(this)" data-title="Permanência" style="display: table-cell; background-color: <?php echo $cor; ?>">
								<?php echo $this->Html->label($diff->days.'d, '.$diff->h.'h '.$diff->i.'m'); ?>&nbsp;
							</td>
							<!-- Coluna Unidade -->
							<td onclick="toggle(this)" data-title="Unidade" style="background-color: <?php echo  $cor; ?>">
								<?php echo h($internado['Unidades']['descricao']); ?>&nbsp;
							</td>			
							<!-- Coluna Modal -->				
							<td style="display: table-cell; background-color: <?php echo  $cor; ?> ;">
								<button type="button" class="btn btn-default btn-xs"><span  onclick="callAjax(<?= $internado['Movimentos']['unf_seq'] ?>)"
								class="glyphicon glyphicon-modal-window"></span></button>
							</td>

						</tr>

                 <?php endforeach; ?>
    </tbody>
				</table>
              <?php if($internados->isEmpty()  /*&& !empty($url)*/ ):?>
              	<div class="panel-body">
					<div class="alert alert-warning" style="margin-bottom: 0">Nenhum
						registro encontrado.</div>
				</div>
            <?php endif;?>
 </div>
		</div>

		<div class="panel-footer">
			<div class="row ">
				<div class="col col-xs-8 ajax-pagination"
					style="line-height: 40px; height: 40px;">
					<div class="btn-toolbar" role="toolbar" aria-label="...">
						<div class="btn-group">
							<ul class="pagination pagination-sm hidden-xs ">
	                  	<?php echo $this->Paginator->numbers()?>
	                    </ul>
						</div>
						<div class="btn-group">
							<ul class="pagination  pagination-sm">
                        <?php echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false])?>
                    	<?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false])?>
                    </ul>
						</div>

						<small class="hidden-xs hidden-sm">
	                 <?php																		
																		echo $this->Paginator->counter ( 'Página {{page}} de {{pages}} - Total: {{count}} registro(s)' );
																		?>
		                </small>

					</div>
				</div>
				<div class="col col-xs-4" style="line-height: 40px; height: 40px;">
					<div class="btn-group pagination dropup pull-right">

						<button type="button" class="btn  btn-sm dropdown-toggle"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-export"></span>
						</button>
						<ul class="dropdown-menu " style="min-width: 0px">
							<li><?php echo $this->Html->link(''.__('Enviar E-mail (todos)'), ['action'=>'index', '?' => ['export' => 'mail']], ['class'=>'','escape' => false]);	?></li>
							<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'kanban', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
							<li id="print" style="text-align: center;"><a href=# onclick="printTabela();">Exportar para PNG</a></li>
						</ul>


					</div>
				</div>

			</div>

		</div>
	</div>
</div>
<!-- Script para exibir o modal -->
<script>
function callAjax(id)
{
$.ajax({
	url: "<?= $this->Url->build(['plugin'=>'Indicadores',"controller" => "Criterios", "action" => "lookupcriterios"]);?>/" + id,
	type: "get",
	dataType: "text",
	success: function(response)
	{
		$('#modalDefaultDialog').html(response);
		$('#modalDefault').modal('show');
	}

});};//FIM AJAX
</script>

<script>
function printTabela()
{
	   html2canvas($('#tabela'), 
			    {
			      onrendered: function (canvas) {
	                    var img = canvas.toDataURL("image/png");
	                    window.open(img);
			      }
			    });
}
</script>

<script>
function toggle(param)
{
	var esconde = $(param).parent().attr('class');
	console.log( esconde + 'b');
$( '.' + esconde + 'b' ).toggle();
}
</script>





















