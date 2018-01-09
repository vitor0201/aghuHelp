<?php echo $this->Html->script('html2canvas.js', ['block' => true]); ?>
<style>
.horizon-swiper {
	/* background: #c65b71; */
	
}

.horizon-item {
	border-left: 1px solid #fff;
}

div.horizon-item:last-child {
	border-right: 1px solid #fff;
}

div.card {
	width: 100%;
	padding: 5px;
	font-size: 12px;
	/* background: #c65b71; */
	/*  color: #fff; */
	color: #000;
	text-align: center;
}
</style>

<div id="AjaxContent"
	class="dispositivos index large-9 medium-8 columns content">

	<div class="hidden panel panel-default" id="panel1">
		<!-- <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="FilterCollapse" class="collapsed" data-target="#collapseTwo">
                  <span class="glyphicon glyphicon-search" ></span> Gráficos 
                </a>
            </h4>
        </div>
         -->
		<div id="collapseTwo" class="panel-collapse collapse in">

			<div class="panel-body">
				<div class="row">

					<div class="col-md-3 text-center">
						<b>Total Internados</b>
						<div id="donut-example3"
							style="height: 180px; padding: 0; margin: 0"></div>
						<script>
				 Morris.Donut({
				  element: 'donut-example3',
				  data: [
				    {label: "Pacientes", value: <?php echo $this->Paginator->counter('{{count}}'); ?>},
				    
				   
				  ],
				  labelColor: '#23527c',
				  colors: [
				    '#23527c',
// 				    '#39B580',
// 				    '#67C69D',
// 				    '#95D7BB'
				  ],
				});
				 </script>
					</div>

					<div class="col-md-3 text-center">
						<b>Média Permanência</b>
						<div id="donut-example4"
							style="height: 180px; padding: 0; margin: 0"></div>
						<script>
				 Morris.Donut({
				  element: 'donut-example4',
				  data: [
				    {label: "Dias", value: 12},
				   
				   
				  ],
				  labelColor: '#23527c',
				  colors: [
				    '#23527c',
// 				    '#39B580',
// 				    '#67C69D',
// 				    '#95D7BB'
				  ],
				});
				 </script>
					</div>
					<div class="col-md-3 text-center">
						<b>Unidades</b>
						<div id="donut-example"
							style="height: 180px; padding: 0; margin: 0"></div>
						<span id="morrisDonutChartSpan"></span>
						<script>



 Morris.Donut({
  element: 'donut-example',
  data: [
    {label: "Download Sales", value: 12},
    {label: "In-Store Sales", value: 30},
    {label: "Mail-Order Sales", value: 20}
  ],
  formatter: function (x) { return x + "%"},
//   backgroundColor: '#ccc',
  
});

 $( "#donut-example" ).mouseover(function() {
     prepareMorrisDonutChart();
 });

 $( document ).ready(function() {
     prepareMorrisDonutChart();
 });

 function prepareMorrisDonutChart() {
     $("#donut-example tspan:first").css("display","none");
     $("#donut-example tspan:nth-child(1)").css("font-size","20px");

     var isi = $("#donut-example tspan:first").html();
     $('#morrisDonutChartSpan').text(isi);
 }
 
 </script>
					</div>
					<div class="col-md-3 text-center">
						<b>Especialidades</b>
						<div id="donut-example1"
							style="height: 180px; padding: 0; margin: 0"></div>
						<span id="morrisDonutChartSpan1"></span>
						<script>
 Morris.Donut({
  element: 'donut-example1',
  data: [
    {label: "Download Sales", value: 12},
    {label: "In-Store Sales", value: 30},
    
  ],
  colors: [
		    '#23527c',
		    '#39B580',
//		    '#67C69D',
//		    '#95D7BB'
		  ],
  formatter: function (x) { return x + "%"},
});

 $( "#donut-example1" ).mouseover(function() {
     prepareMorrisDonutChart1();
 });

 $( document ).ready(function() {
     prepareMorrisDonutChart1();
 });

 function prepareMorrisDonutChart1() {
     $("#donut-example1 tspan:first").css("display","none");
     $("#donut-example1 tspan:nth-child(1)").css("font-size","20px");

     var isi = $("#donut-example1 tspan:first").html();
     $('#morrisDonutChartSpan1').text(isi);
 }
 
 </script>
					</div>
					<!-- <div class="col-md-2 text-center">
		<b>Sexo</b>
		<div id="donut-example2" style="height: 180px; padding: 0; margin: 0"></div>
		<span id="morrisDonutChartSpan2"></span>
 <script>
 Morris.Donut({
  element: 'donut-example2',
  data: [
    {label: "Masculino", value: 55},
    {label: "Feminino", value: 45},
   
  ],
  formatter: function (x) { return x + "%"},
});

 $( "#donut-example2" ).mouseover(function() {
     prepareMorrisDonutChart2();
 });

 $( document ).ready(function() {
     prepareMorrisDonutChart2();
 });

 function prepareMorrisDonutChart2() {
     $("#donut-example2 tspan:first").css("display","none");
     $("#donut-example2 tspan:nth-child(1)").css("font-size","20px");

     var isi = $("#donut-example2 tspan:first").html();
     $('#morrisDonutChartSpan2').text(isi);
 }
 </script>
	</div>
	 -->


				</div>


				<div class="clear-fix"></div>
				<div class="clear-fix"></div>
			</div>
		</div>
	</div>


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
                              format: 'DD/MM/YYYY 23:59:59', showClear: true, useCurrent: false, showTodayButton: true ,
                              maxDate: new Date() 
                                });
                          
                          </script>
                                <?php echo $this->Form->input('unidade_id',['label'=>'Unidades','options'=>$unidades, 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%'])?>
                           
                                <?php echo $this->Form->input('especialidade_id',['label'=>'Especialidades','options'=>$especialidade, 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%'])?>
                              
                               <?php echo $this->Form->input('cid',['id'=>'CidId','label'=>'CID'])?>
                         
                                
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
                                url: '<?php echo $this->Url->build([ "action" => "internacao"]);?>',
                                
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
			<!--<div class="dropdown pull-right">
				 <button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo'), ['action' => 'add'], ['escape' => false]) ?></li>
				</ul>
			</div>-->
			<h3><?php echo __('Pacientes Internados') ?> <small>AGHU</small>
			</h3>
		</div>
		<div id="no-more-tables">
			<div id="PanelBody">

				<div class="horizon-swiper hidden">

					<div class="horizon-item" style="background-color: #777; ">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />01
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />02
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />03
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />04
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />05
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />06
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />07
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />08
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />10
						</div>
					</div>
					<div class="horizon-item">
						<div class="card ">
							JAN<span class="hidden-xs hidden-sm">EIRO</span><br />11
						</div>
					</div>



				</div>



				<script>
$('.horizon-swiper').horizonSwiper({
    showItems: 5,
//     arrows: false,
    animationSpeed: 200
} );
</script>

				<table class="table table-bordered table-hover census"
					cellpadding="0" cellspacing="0"
					style="margin: 0; padding: 0; font-size: 90%; background:#ffffff" id="tabela">
					<thead>
						<tr>

							<th class="actions">&nbsp;</th>

							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.prontuario','Prontuário') ?> / <?php echo $this->Paginator->sort('Pacientes.nome','Nome') ?></th>
							<!--  <th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.prontuario','Pront.') ?></th> -->
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.dt_nascimento','Idade') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.sexo','Sexo') ?> </th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Internacoes.dthr_internacao','Internação') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Internacoes.dt_saida_paciente','Alta') ?></th>
							<th class="ajax-pagination">Dias</th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Unidades.descricao','Unidade') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Internacoes.lto_lto_id','Leito') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Especialidades.nome_especialidade','Especialidade') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pessoas.nome','Médico') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Cids.codigo','CID') ?></th>



						</tr>
					</thead>
					<tbody>
                    <?php
																				$i = 0;
																				foreach ( $internados as $internado ) :
																					$class = "";
																					// debug($internado);
																					// if(!$dispositivo->ativo)
																					// $class="class='text-danger'";
																					
																					?>
                    <tr <?php echo $class;?>>

							<td class="action ">

								<div class="btn-group ">
									<button type="button"
										class="btn btn-xs btn-info dropdown-toggle"
										data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="glyphicon glyphicon-menu-hamburger"
											aria-hidden="true"></span>
									</button>
									<ul class="dropdown-menu ">
										<li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'paciente', $internado->prontuario], ['escape' => false]); ?></li>

										<!--  <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $dispositivo->id], ['escape' => false]); ?></li>
										<li role="separator" class="divider"></li>
										<li><?php echo $this->Html->link(__('Enviar E-mail'), ['action' => 'enviarEmail', $dispositivo->id], ['escape' => false]); ?></li>
										
										<li role="separator" class="divider"></li>
										<li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $dispositivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>-->
									</ul>
								</div>
							</td>
                                                 
                   		<?php
																					// $datas = Time::createFromFormat('yyyy-MM-dd HH:mm:ss',$internado['Internacoes']['dthr_internacao']);
																					?>
                        
                        <td data-title="Nome"><small><?php echo h($internado->prontuario); ?></small><br /><?php echo h($internado->nome) ?>&nbsp;</td>
							<!--  <td data-title="Prontuario"><?php echo h($internado->prontuario); ?>&nbsp;</td> -->
							<td data-title="Idade"><?php echo h($internado->idade); ?>&nbsp;</td>
							<td data-title="Sexo"><?php echo h($internado->sexo) ?>&nbsp;</td>
							<td data-title="Internação"><?php echo substr(formatDate($internado['Internacoes']['dthr_internacao']),0,10); ?>&nbsp;</td>
							<td data-title="Alta"><?php echo ($internado['Internacoes']['dt_saida_paciente']? substr(formatDate($internado['Internacoes']['dt_saida_paciente']),0,10) : '') ?>&nbsp;</td>
							<td data-title="Permanência"><?php echo h($internado['Internacoes']['permanencia']); ?>&nbsp;</td>
							<td data-title="Unidade"><?php echo h($internado['Unidades']['descricao']); ?><?php echo h($internado['Internacoes']['unf_seq']); ?> &nbsp;</td>
							<td data-title="Leito"><?php echo h($internado['Internacoes']['leito']); ?>&nbsp;</td>
							<td data-title="Especialidade"><?php echo h($internado['Especialidades']['nome_especialidade']); ?>&nbsp;</td>
							<td data-title="Médico"><?php echo h($internado['Medico']['nome']); ?>&nbsp;</td>
							<td data-title="CID"><?php echo h($internado['Cids']['codigo']); ?><br />
							<small><?php echo h($internado['Cids']['descricao']); ?></small>&nbsp;</td>
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
	                   <?php
																				$paginas = [ 
																						15,
																						25,
																						50,
																						75,
																						100,
																						500
																				];
																				$active = $this->Paginator->param ( 'limit' );
																				?>
                     <div
							class="btn-group pagination hidden-xs hidden-sm dropup">

							<button type="button" class="btn  btn-sm dropdown-toggle"
								data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
									    <?php echo $active? $active : 50;?> / pág. <span
									class="caret"></span>
							</button>
							<ul class="dropdown-menu " style="min-width: 0px">
									 	<?php
											foreach ( $paginas as $pag ) {
												if ($pag == $active) {
													$class = 'active disabled';
												}
												echo "<li >" . $this->Html->link ( $pag, [ 
														'action' => 'internacao',
														'?' => [ 
																'limit' => $pag 
														] 
												], [ 
														'class' => ' ' 
												] ) . "</li>";
											}
											?>
									  </ul>

						</div>
						&nbsp; <small class="hidden-xs hidden-sm">
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
							<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'internacao', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
							<li id="print" style="text-align: center;"><a href=# onclick="printTabela();">Exportar para PNG</a></li>
						</ul>

					</div>
				</div>

			</div>

		</div>
	</div>

</div>

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

