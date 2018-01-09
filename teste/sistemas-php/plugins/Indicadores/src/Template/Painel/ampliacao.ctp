<?php
echo $this->Html->script ( 'https://www.gstatic.com/charts/loader.js', [ 
		'block' => true 
] );
?>
						
<?php
define ( "QTDASSINATURA", "240" );
foreach ( $leitos as $leito ) {
	$porcentagem = ($leito ['total']);
	$qtd = $leito ['qtd'];
}
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class=" pull-right">
			<button class="btn btn-sm" type="button" aria-haspopup="true"
				aria-expanded="true">
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-question-sign pull-right" aria-hidden="true"></span>&nbsp; ', ['controller' => 'FichaIndicadores', 'action' => 'view', 22], ['escape' => false]) ?>
					</button>
		</div>
		<h3 class="panel-title">Leitos Ativos</h3>
	</div>
	<div class="panel-body text-center">
		<div class="col-sm-4 col-md-4">
			<h4>Leitos Dez/2013</h4>
			<p><?= QTDASSINATURA ?></p>
		</div>
		<div class="col-sm-4 col-md-4">
			<h4>Leitos Atual</h4>
			<p><?= $qtd ?></p>
		</div>
		<div class="col-sm-4 col-md-4">
			<h4>Ampliação</h4>
			<p><?= $porcentagem ?>%</p>
		</div>
	</div>
	<hr>
	<div class="panel-body text-center">
		<div class="col-sm-12 col-md-12">
			<div id="chart_div"></div>
		</div>
	</div>


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
        data.addColumn('string', 'Quantidade');
        data.addColumn('number', 'Leitos');
        data.addRows([
			<?php echo "['Dez/2013'," . QTDASSINATURA . "],";?>
			<?php echo "['Atualmente'," . $qtd . "],";?>
        ]);

        // Set chart options
        var options = {
                		'title':'Internações',         
               			 hAxis: {
           					title: 'Data',
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






