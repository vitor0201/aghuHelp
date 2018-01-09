<div class="criterios view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading">


			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left pull-right" aria-hidden="true"></span>&nbsp; '.__('Voltar'), ['action' => 'kanban'], ['escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				Paciente <small><?php echo h($paciente['prontuario']) ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<!-- TABLE PACIENTE -->
			<table class="table">
				<tr><?php //debug($pendencias)?>
					<th><?= __('Nome') ?></th>
					<td><?= h($paciente['nome']) ?></td>
				</tr>
				<tr>
					<th><?= __('Prontuário') ?></th>
					<td><?= h($paciente['prontuario']) ?></td>
				</tr>
				<tr>
					<th><?= __('Data de Nascimento') ?></th>
					<td><?= h($paciente['dt_nascimento']) ?></td>
				</tr>
			</table>
			<!-- TABLE PENDÊNCIAS -->
			<table class="table table-bordered table-hover table-responsive">
				<tr style="background: #DCDCDC">
					<th>Pendência &nbsp;</th>
					<th>Data Cadastro &nbsp;</th>
					<th>Observação &nbsp;</th>
					<th>Usuário Cadastro &nbsp;</th>
					<th>Data Remoção &nbsp;</th>
					<th>Observação Remoção &nbsp;</th>
					<th>Usuário Remoção &nbsp;</th>
				</tr>	
				<?php foreach ($pendencias as $pendencia) :?>
				<tr>
					<td><?= h($pendencia['tipo_pendencia'] ['descricao'])?></td>
					<td><?= h($pendencia['data_cadastro'])?></td>
					<td><?= h($pendencia['observacao'])?></td>
					<td><?= h($pendencia['usuario_id'])?></td>
					<td><?= h($pendencia['data_remocao'])?></td>
					<td><?= h($pendencia['observacao_remocao'])?></td>
					<td><?= h($pendencia['remocao_usuario_id'])?></td>					
				</tr>
				<?php endforeach;?>
			</table>
			<ul class="nav nav-tabs">
			</ul>
			<div class="tab-content"></div>

		</div>
	</div>
</div>
