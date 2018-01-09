<div class="row">
	<div class="col-md-9">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= h($unidades);?></h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-responsive">
					<thead>
						<tr>
							<th><?= __('Cor') ?></th>
							<th><?= __('Início') ?></th>
							<th><?= __('Fim') ?></th>
						</tr>
		<?php foreach ($criterio as $criterios): ?>		
			<tr>
							<td style="background :<?= $criterios->cor ?>">&nbsp;</td>
							<td><?= ($criterios->inicio != 0)? '<span class="label label-default">' . date('d \D\i\a\s H \H\o\r\a\s i \M\i\n\u\t\o\s', mktime(0,$criterios->inicio,0,0,0,0)) .'</span>' :  '<p class="label label-default">00 Dias 00 Horas 00 Minutos</p>' ?></td>
							<td><?= ($criterios->fim > 44640 )? '<span class="label label-default"> ∞ </span>' :  '<span class="label label-default">' . date('d \D\i\a\s H \H\o\r\a\s i \M\i\n\u\t\o\s', mktime(0,$criterios->fim,0,0,0,0)) .'</span>' ?></td>
			</tr>	
		<?php endforeach; ?>

				</table>
			</div>
		</div>
	</div>
</div>