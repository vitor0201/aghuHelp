<?php
echo $this->Html->script ( 'https://www.gstatic.com/charts/loader.js', [ 
		'block' => true 
] );
?>
<!-- FILTRO  -->
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
				<!-- OPÇÕES -->
	                     		<?php echo $this->Form->input('data_internacao', ['label'=>'Data Inicial', 'id'=>'dataInternacao', 'required'=>'required'])?>
                          <script>
                          $('#dataInternacao').datetimepicker({     
                              format: '01/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true ,
                              maxDate: new Date() 
                                });                         
                          </script>                         	 
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
                                url: '<?php echo $this->Url->build([ "action" => "internacoes"]);?>',
                                
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
	<!-- FIM DO FILTRO -->

	<div class="panel panel-default">
		<div class="panel-heading">

			<div class=" pull-right">
				<button class="btn btn-sm" type="button" aria-haspopup="true"
					aria-expanded="true">
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-question-sign pull-right" aria-hidden="true"></span>&nbsp; ', ['controller' => 'FichaIndicadores', 'action' => 'view', 24], ['escape' => false]) ?>
					</button>
			</div>
			<h3>Número de Internações por Mês</h3>
		</div>
		<div class="panel-body">
			<div id="chart_div"></div>
		</div>

		<script type="text/javascript">
		
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {packages: ['corechart', 'bar']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
         var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tempo');
        data.addColumn('number', 'Pacientes');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addRows([
        		<?php
										foreach ( $internacoes as $internacao ) {
											echo "['" . $internacao ['data_count'] . "', " . $internacao ['Total'] . ", '" . $internacao ['Total'] . "'],";
										}
										?>
        ]);

        // Set chart options
        var options = {
                		'title':'Internações',         
               			 hAxis: {
           					title: 'Meses',
           			 		minValue: 0
          				},
          				vAxis: {
           				title: 'Total',
           			    minValue: 0
        				},
        				legend: 
            				{ position: "none" },       
                       'width':1000,
                       'height':600,
                       annotations: {
                           alwaysOutside: true,
                           textStyle: {
                             fontSize: 17,
                             auraColor: '#eee',
                             color: '#000'
                           },                                           
                    	}
                      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

	</div>