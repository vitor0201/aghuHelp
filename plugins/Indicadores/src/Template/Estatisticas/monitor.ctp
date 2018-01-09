<?php
use Cake\I18n\Time;
?>
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
					class="glyphicon glyphicon-search"> </span> Filtro <?php if(!empty($url)):?><span
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
                                <?php echo $this->Form->input('unidade_id',['label'=>'Unidades','options'=>$unidades, 'class'=>'select', 'id'=>'unidadeSelect', 'multiple'=>'multiple', 'style'=>'width:100%','onClick'=>'unidadeShow()'])?>
                           
                                <?php echo $this->Form->input('especialidade_id',['label'=>'Especialidades','options'=>$especialidade, 'class'=>'select', 'multiple'=>'multiple', 'style'=>'width:100%'])?>
                              	
              
                 <div class="col-md-2 pull-right ">
					<div class="input-group  input-group-sm">
						<span class="input-group-addon"> Atualizar </span> <input
							type="text" class="form-control" 
							id="uploadText" aria-label="..." placeholder="Minutos" required />
					</div>
					<!-- /input-group -->
				</div>
				<!-- /.col-lg-2 -->

			</div>
			
			<div class="panel-footer">                
                <?php echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm','onclick'=>'autoRefresh(); autoScroll(); ']); ?>
                
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
                                url: '<?php echo $this->Url->build([ "action" => "monitor"]);?>',
                                
                                beforeSend: function(response) {
                                	
                                    jQuery('#FilterCollapse').click();
                                    
                                    jQuery('#PanelBody').fadeTo(300,0, function() {  });
                                },
                        
                                success: function(response) {
                                    
                                    jQuery('#tabela').load('<?php echo $this->Url->build([ "action" => "monitor"]);?>' + ' #tabela');
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
		<div class="panel-heading" >


			<div class="row padding-small-horizontal">
				<div class="col-md-3 pull-left " id="cores">
					<h3 id="exibeUnidade"><?php echo __('Pacientes') ?></h3>
				</div>
				<div></div>
			</div>
			<!-- .row -->

		</div>
		<div id="no-more-tables">
			<div id="PanelBody">

				<script>
$('.horizon-swiper').horizonSwiper({
    showItems: 5,
//     arrows: false,
    animationSpeed: 200
} );
</script>

				<table class="table table-bordered table-hover census"
					cellpadding="0" cellspacing="0"
					style="margin: 0; padding: 0; font-size: 90%" id="tabela">
					<thead>
						<tr>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Internacoes.lto_lto_id','Leito') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.prontuario','Prontário') ?> / <?php echo $this->Paginator->sort('Pacientes.nome','Nome') ?></th>
							<!--  <th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.prontuario','Pront.') ?></th> -->
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.dt_nascimento','Idade') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pacientes.sexo','Sexo') ?> </th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Pessoas.nome','Médico') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Internacoes.dthr_internacao','Internação') ?></th>
							<th class="ajax-pagination">Pendências</th>
							<th class="ajax-pagination">Dias</th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Unidades.descricao','Unidade') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('Especialidades.nome_especialidade','Especialidade') ?></th>
						</tr>
					</thead>
					<tbody id="tbody">
                     <?php 
																				$i = 0;
																				$anterior = "";
																				foreach ( $internados as $internado ) :
																					// $class = "";
																					
																					// TEMPO
																					$dataAtual = $data_anterior = Time::now ();
																					$dataEntrada = new Time ( $internado ['Movimentos'] ['entrada'] );
																					$dataDif = $dataAtual->diff ( $dataEntrada );
																					$tempo_minutos = ($dataDif->days * 1440) + ($dataDif->h * 60) + ($dataDif->i);
																					
																					// CORES
																					foreach ( $criterios as $crit ) {
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
                    <tr <?php echo $class;?>>
                   		<?php
																					// $datas = Time::createFromFormat('yyyy-MM-dd HH:mm:ss',$internado['Internacoes']['dthr_internacao']);
								
               ?>
               				<td data-title="Leito" style="font-weight: bold;"><?php echo h($internado['Internacoes']['leito']); ?>&nbsp;</td>
                        	<td data-title="Nome"><small><?php echo h($internado->prontuario); ?></small><br /><?php echo h($internado->nome) ?>&nbsp;</td>
							<!--  <td data-title="Prontuario"><?php echo h($internado->prontuario); ?>&nbsp;</td> -->
							<td data-title="Idade"><?php echo h($internado->idade); ?>&nbsp;</td>
							<td data-title="Sexo"><?php echo h($internado->sexo) ?>&nbsp;</td>
							<td data-title="Médico"><?php echo h($internado['Medico']['nome']); ?>&nbsp;</td>
							<td data-title="Internação"><?php echo substr(formatDate($internado['Internacoes']['dthr_internacao']),0,10); ?>&nbsp;</td>
							<td data-title="Pendências"><?php foreach ( $kanb as $value ) {
																						if ($value ['internacao_id'] == $internado->prontuario && $value ['data_remocao'] == null) {																	
																							echo $this->Html->link ( $value->tipo_pendencia->descricao, [ 
																									'action' => 'edit',
																									'controller' => 'Pendencias',
																									'plugin' => 'Indicadores',
																									$value->id 
																							], [ 
																									'class' => 'label label-default',
																									'style' => 'display: block; border: solid #ffffff 0.2px' 
																							] );
																						}
																					}
																					?></td>
							<td data-title="Permanência" style="background-color: <?php echo  $cor; ?>"><?php echo $this->Html->label($dataDif->days.'d, '.$dataDif->h.'h '.$dataDif->i.'m'); ?>&nbsp;</td>
							<td data-title="Unidade" style="background-color: <?php echo  $cor; ?>"><?php echo h($internado['Unidades']['descricao']); ?><?php echo h($internado['Internacoes']['unf_seq']); ?> &nbsp;</td>
							<td data-title="Especialidade" style="background-color: <?php echo  $cor; ?>"><?php echo h($internado['Especialidades']['nome_especialidade']); ?>&nbsp;</td>
						</tr>
					
					<?php
																				endforeach
																				;
																				?>
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

		<div class="panel-footer" id="footer">
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
																						100 
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
			</div>

		</div>
	</div>

</div>
<!-- Função para atualizar a tabela -->
<script>
function refreshPage()
{
	$( "#tabela" ).load( "<?= $this->Url->build(['plugin'=>'Indicadores',"controller" => "Estatisticas", "action" => "monitor"]);?> #tabela" );
}
</script>
<!-- Função que recebe o tempo para atualizar a tabela -->
<script>
function autoRefresh()
{
	unidadeShow()
	var valor = $('#uploadText').val();
	if(valor > 0)
	{
		setInterval(function(){ 
			refreshPage(); 
		}, valor*60000);
	}	
}
</script>
<!-- Função que pega o valor e o nome da unidade  -->
<script>
function unidadeShow()
{
	var exibe = $( "#unidadeSelect option:selected" ).text();
	var unidade = $( "#unidadeSelect option:selected" ).val();
	$('#exibeUnidade').html('<h5 id="exibeUnidade">'+ exibe + '</h5>');
	$('.texto').detach();
	corShow(unidade);
}
</script>
<!-- Função para exibir as legendas -->
<script>
function corShow(unidade)
{
	var unidadeCor = <?php echo json_encode($criterios); ?>;
	
	$.each(unidadeCor, function (index, value) {
     if(value.unidade_id == unidade)
       {    
			var inicio = conversor(value.inicio);
			var fim = conversor(value.fim);
			$('#cores').siblings().prepend('<div class="texto"><div class="col-md-3 pull-right">\
											<h3><span><small>Início&nbsp;</small></span><span class="label label-default" style="background:'+ value.cor + '">\
											&nbsp;</span>' + inicio + '</h3>\
											<h3><span><small>Final&nbsp;&nbsp;</small></span><span class="label label-default" style="background:'+ value.cor + '">\
											&nbsp;</span>' + fim + '</h3>\
					                        </div></div>');
       }
    })

}
<!-- Função de conversão de tempo-->
function conversor(minuto)
{
		//var date = new Date(null);
		//date.setSeconds(minuto); // specify value for SECONDS here
		//date.toISOString().substr(11, 8);
	if(minuto < 525600)
	{
		var minutos = Math.floor(minuto % 60);
		var horas = Math.floor(minuto / 60) % 24;
		var dias = Math.floor((minuto / 60) / 24);
		return (dias + ' dias ' + horas + ' h ' + minutos + ' min');
	}
	else
	{
		return(' ... ');	
	}
}
</script>
<!-- Função auto scroll -->
<script>
function autoScroll()
{
	$('html,body').animate({scrollTop:$('#footer').offset().top}, 50000);
	$('html,body').animate({scrollTop:$('#AjaxContent').offset().top}, 50000);
	autoScroll();
}
</script>


		