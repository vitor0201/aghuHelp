<style>
.thumbnail {
	background-color: #f2f2f2;
	box-shadow: 10px 10px 5px #888888;
}

.thumbnail:hover {
	background-color: #cccccc;
}
</style>
<?php echo $this->Html->script('https://www.gstatic.com/charts/loader.js', ['block' => true]);?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-9 col-md-9">
				<h3 class="panel-title"><?php echo $this->Html->image('ebserh.png', ['height'=>45])?>		</h3>
			</div>
			<div class="col-sm-3 col-md-3">
				<h2 class="pull-right">Painel de Bordo</h2>
			</div>
		</div>
	</div>
	<div class="panel-body text-center">
		<div class="row">
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
	<?php
	echo $this->Html->link ( '<h4>Taxa de Ocupação Hospitalar
			</h4><p>&nbsp;</p>', [ 
			'action' => 'dados',
			1,
			'controller' => 'painel' 
	], [ 
			'escape' => false 
	] )?>
					<!-- <h4>Taxa de Ocupação Hospitalar</h4> -->

				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
							<?php
							echo $this->Html->link ( '<h4 style="margin: 0">Tempo Médio De Permanência Hospitalar</h4>
						<span>&nbsp;</span>', [ 
									'action' => 'dados',
									21,
									'controller' => 'painel' 
							], [ 
									'escape' => false 
							] )?>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
													<?php
													echo $this->Html->link ( '<h4>Taxa de Mortalidade Institucional</h4>', [ 
															'action' => 'dados',
															14,
															'controller' => 'painel' 
													], [ 
															'escape' => false 
													] )?>
						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
												<?php
												echo $this->Html->link ( '<h4>Giro de Rotatividade</h4>', [ 
														'action' => 'rotatividade',
														'controller' => 'painel' 
												], [ 
														'escape' => false 
												] )?><span>&nbsp;</span>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Relação de Enfermeiro por leito</h4>', [ 
							'action' => 'dados',
							12,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>	
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Número de cirurgias por mês</h4>', [ 
							'action' => 'dados',
							8,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
												<?php
												echo $this->Html->link ( '<h4>Número de internações por mês</h4>', [ 
														'action' => 'internacoes',
														'controller' => 'painel' 
												], [ 
														'escape' => false 
												] )?>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Número de consultas por mês</h4>', [ 
							'action' => 'dados',
							5,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>	
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Relação Enfermagem por leito</h4>', [ 
							'action' => 'dados',
							19,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>	
						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
						
					<?php
					echo $this->Html->link ( '<h4>Taxa de cesáreas</h4><span>&nbsp;</span>', [ 
							'action' => 'dados',
							11,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>										
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
												<?php
												echo $this->Html->link ( '<h4>Número de Leitos Ativos</h4>', [ 
														'action' => 'leitos',
														'controller' => 'painel' 
												], [ 
														'escape' => false 
												] )?><small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">						
					<?php
					echo $this->Html->link ( '<h4>Número de exames laboratoriais(mês)</h4>', [ 
							'action' => 'dados',
							10,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>										
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Percentual de Ampliação de Consultas</h4>', [ 
							'action' => 'dados',
							6,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
			<?php
			echo $this->Html->link ( '<h4>Número de exame de imagens(mês)</h4>', [ 
					'action' => 'dados',
					9,
					'controller' => 'painel' 
			], [ 
					'escape' => false 
			] )?>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h5>Taxa de desempenho da produção contratualizada com o Gestor do
							Sus</h5>', [ 
							'action' => 'dados',
							20,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>
						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Taxa de desempenho da produção FAEC</h4>', [ 
							'action' => 'dados',
							13,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Percentual de primeiras consultas(Gestor)</h4>', [ 
							'action' => 'dados',
							7,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>							
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
							<?php
							echo $this->Html->link ( '<h4>Percentual de Ampliação de Leitos </h4>', [ 
									'action' => 'ampliacao',
									'controller' => 'painel' 
							], [ 
									'escape' => false 
							] )?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Tempo Médio de Permanência Cirúrgica</h4>', [ 
							'action' => 'dados',
							3,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Número de Never Events</h4><span>&nbsp;</span>', [ 
							'action' => 'dados',
							15,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h6>Densidade de Incidência de Pneumonia Associada à Ventilação
							Mecânica em Pacientes Internados em Unidades de Terapia</h6>', [ 
							'action' => 'dados',
							16,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>	
						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Densidade de Incidência de Infecção</h4>', [ 
							'action' => 'dados',
							17,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4>Densidade de Incidência de Infecção IPCSL</h4>', [ 
							'action' => 'dados',
							18,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>						
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-2">
				<div class="thumbnail">
					<div class="caption" data-toggle="modal" data-target="#myModal">
					<?php
					echo $this->Html->link ( '<h4 style="margin: 0">Tempo Médio De Permanência Clínica</h4>
						<span>&nbsp;</span>', [ 
							'action' => 'dados',
							2,
							'controller' => 'painel' 
					], [ 
							'escape' => false 
					] )?>							
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

