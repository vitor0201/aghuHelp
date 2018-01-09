<?php
echo $this->Html->script ( 'https://www.gstatic.com/charts/loader.js', [ 
		'block' => true 
] );
?>
<?php
$indicador = "";
foreach ( $dados as $dado ) {
	if ($indicador == "") {
		$indicador = $dado ['indicador'] ['nome'];
		$indicador_id = $dado ['indicador_id'];
		$tipo_valor = $dado ['indicador'] ['valor'];
		break;
	}
}
?>
<div class="criterios view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading">

			<div class=" pull-right">
				<button class="btn btn-sm" type="button" aria-haspopup="true"
					aria-expanded="true">
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-question-sign pull-right" aria-hidden="true"></span>&nbsp; ', ['controller' => 'FichaIndicadores', 'action' => 'view', $indicador_id], ['escape' => false]) ?>
					</button>
			</div>

			<h3>
				<?php echo h($indicador) ?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="panel-body text-center">
				<div class="col-sm-12 col-md-12">
					<div id="chart_div"></div>
				</div>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th><?= __($tipo_valor) ?></th>
						<th><?= __('Data') ?></th>
					</tr>
				</thead>
			<?php
			foreach ( $dados as $dado ) :
				?>
				<tr>
					<td><?= h($dado['valor']) ?></td>
					<td><?= h($dado['date']) ?></td>
				</tr>
				<?php endforeach;?>
			</table>
			<ul class="nav nav-tabs">
			</ul>
			<div class="tab-content"></div>
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
        data.addColumn('string', 'Data');
        data.addColumn('number', '<?= $tipo_valor?>', { role: 'annotation' });
        data.addColumn({type:'string', role:'annotation'});

        data.addRows([
				<?php
				foreach ( $dados as $dado ) {
					echo "['" . $dado ['date'] . "'," . $dado ['valor'] . ", '" . $dado ['valor'] . "'],";
				}
				?>
        ]);

        // Set chart options
        var options = {
                		'title':'<?= $indicador?>',         
               			 hAxis: {
           					title: 'Data',
           			 		minValue: 0
          				},
          				vAxis: {
           				title: '<?= $tipo_valor?>',
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
