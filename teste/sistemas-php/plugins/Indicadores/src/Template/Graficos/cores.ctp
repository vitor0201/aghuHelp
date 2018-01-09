<?php echo $this->Html->script('https://www.gstatic.com/charts/loader.js', ['block' => true]);?>
<?php
$array = array ();
$cont ;
foreach ( $especialidades as $especialidade ) {
	$cont += 1;
// 	debug($especialidade);
	foreach ( $criterios as $criterio ) {
// 		debug($criterio);
		if ($criterio ['fim'] >= $especialidade ['data_internacao'] && $criterio ['inicio'] <= $especialidade ['data_internacao'] && $criterio ['unidade_id'] == $especialidade ['unidade_id']) {
// 			echo $criterio['cor'] ; echo '<br>';
			$cor = $criterio ['cor'];
			$array[$cor] += 1;
			break;
		}
	}
}
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
                              format: 'DD/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true ,
                              maxDate: new Date() 
                                });
                          
                          </script>
                          	   <?php echo $this->Form->input('data_saida', ['label'=>'Data Final', 'id'=>'dataSaida', 'required'=>'required'])?>
                          <script>
                          $('#dataSaida').datetimepicker({     
                              format: 'DD/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true ,
                              maxDate: new Date() 
                                });
                          
                          </script>
                                <?php echo $this->Form->input('unidade_id',['label'=>'Unidades','options'=>$unidades, 'class'=>'select2', 'multiple'=>'multiple', 'style'=>'width:100%'])?> 
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
                                url: '<?php echo $this->Url->build([ "action" => "cores"]);?>',
                                
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

	<script type="text/javascript">
		
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Cor');
        data.addColumn('number', 'Quantidade');
        data.addRows([
        		<?php				
        			foreach ($array as $key => $values){
        				echo "['" . $key . "', " . $values . "],";
					}
				?>
        ]);
		//SOMA O TOTAL
        var total = google.visualization.data.group(data, [{
            type: 'boolean',
            column: 0,
            modifier: function () {return true;}
        }], [{
            type: 'number',
            column: 1,
            aggregation: google.visualization.data.sum
        }]);
        // ADICIONA TOTAL
        data.addRow(['TOTAL : ' + total.getValue(0, 1), 0]);
        // Set chart options
        var options = {'title':'Cores por Unidades',
                       'pieSliceText':'value',  
                       'width':1000,
                       'height':600,
                       'sliceVisibilityThreshold': 0,
                       'colors' : [<?php foreach($array as $key => $values){
						echo "'$key',";}?>]
                      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>



	<!--Div that will hold the pie chart-->
	<div id="chart_div"></div>
</div>
