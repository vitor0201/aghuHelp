<?php
foreach ( $leitos as $leito ) {
	$qtd = ($leito ['total']);
}

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class=" pull-right">
			<button class="btn btn-sm" type="button" aria-haspopup="true"
				aria-expanded="true">
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-question-sign pull-right" aria-hidden="true"></span>&nbsp; ', ['controller' => 'FichaIndicadores', 'action' => 'view', 23], ['escape' => false]) ?>
					</button>
		</div>
		<h3 class="panel-title">Leitos Ativos</h3>
	</div>
	<div class="panel-body">Total de Leitos Ativos : <?php echo $qtd; ?></div>
</div>