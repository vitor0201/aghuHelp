
<div class="agendamentos view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading">


			<div class="dropdown pull-right">
		 						
                                <?php if($this->request->is('ajax')): ?>
                                <button type="button" class="close"
					style="margin-left: 15px" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
                               
								<?php endif; ?>
								<button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $agendamento->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $agendamento->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                    
                                    <?php if(!$this->request->is('ajax')): ?>
                                    <li class="divider"></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Mapa'), ['action' => 'index'], ['escape' => false]) ?></li>

					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-calendar pull-right" aria-hidden="true"></span>&nbsp; '.__('Agenda'), ['action' => 'calendar'], ['escape' => false]) ?></li>
                                    <?php endif;?>
                                </ul>
			</div>

			<h3><?= h(substr($agendamento->data,0,10)); ?> às <?= h(str_pad($agendamento->horario->hour,2,'0',STR_PAD_LEFT)); ?>:<?= h(str_pad($agendamento->horario->minute,2,'0',STR_PAD_LEFT)); ?>h </h3>
		</div>

		<div class="">


			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion"
								href="#collapseZero" aria-expanded="true"
								aria-controls="collapseZero"> Agendamento </a>
						</h4>
					</div>
					<div id="collapseZero" class="panel-collapse collapse in"
						role="tabpanel" aria-labelledby="headingOne">
						<div class="">
							<table class="table" style="margin: 0">
								<tr>
									<th style="padding-left: 25px"><?= __('Preceptor') ?></th>
									<td><?= h($agendamento->preceptor->nome) ?></td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Situação') ?></th>
									<td>&nbsp; <?= h($agendamento->situacao->descricao); ?> <div  style="width:20px;float:left;   background: <?php echo $agendamento->situacao->cor_agenda;?> ">
											&nbsp;</div></td>
								</tr>

								<tr>
									<th style="padding-left: 25px"><?= __('Sala') ?></th>
									<td><?= h($agendamento->sala->descricao); ?></td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Duração') ?></th>
									<td><?php if($agendamento->duracao->hour) echo h(str_pad($agendamento->duracao->hour,2,'0',STR_PAD_LEFT)).'h'; ?> <?php if($agendamento->duracao->minute) echo h(str_pad($agendamento->duracao->minute,2,'0',STR_PAD_LEFT)).'min'; ?> </td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Sequência') ?></th>
									<td><?= h($agendamento->sequência) ?></td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('AIH') ?></th>
									<td><?= h($agendamento->aih) ?></td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Data de Cadastro') ?></th>
									<td><?= h($agendamento->data_cadastro->format('Y-m-d / H:i:s')) ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion"
								href="#collapseOne" aria-expanded="true"
								aria-controls="collapseOne"> Paciente </a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingOne">
						<div class="">
							<table class="table" style="margin: 0">

								<tr>
									<th style="padding-left: 25px"><?= __('Prontuário') ?></th>
									<td><?= h($agendamento->paciente_prontuario); ?></td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Nome') ?></th>
									<td><?= h($agendamento->paciente_nome); ?> (<?= h($agendamento->paciente_sexo); ?>) </td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Nascimento') ?></th>
									<td><?= h(substr($agendamento->paciente_nascimento,0,10)); ?>  </td>
								</tr>
								<tr>
									<th style="padding-left: 25px"><?= __('Fones') ?></th>
									<td>
            <?php
												$fones = [ ];
												if ($agendamento->fone1)
													$fones [] = $agendamento->fone1;
												if ($agendamento->fone2)
													$fones [] = $agendamento->fone2;
												echo h ( implode ( ', ', $fones ) );
												
												?></td>
							
							</table>
						</div>
					</div>
				</div>

				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingHist">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion"
								href="#collapseHist" aria-expanded="true"
								aria-controls="collapseHist"> Histórico do paciente </a>
						</h4>
					</div>
					<div id="collapseHist" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingHist">
						<div class="">
							<table class="table" style="margin: 0">
		<?php foreach ($historico as $hist): ?>
        <tr>
									<th style="padding-left: 25px"><div style="cursor: pointer;"
											onclick="openLookupEvent(<?php echo $hist->id; ?>)"><?php echo substr($hist->data,0,10); ?></div></th>

									<td>
            <?php
			
			$procs = [ ];
			foreach ( $hist->cirurgias_procedimentos as $procedimento ) {
				// debug($procedimento) ;
				$procs [] = $procedimento->procedimento->sigla;
			}
			echo implode ( ', ', $procs );
			?>
            </td>
									<td>
            &nbsp; <?= h($hist->situacao->descricao); ?> <div  style="width:20px;float:left;  background: <?php echo $hist->situacao->cor_agenda;?> ">
											&nbsp;</div>
									</td>
								</tr>
        <?php endforeach;?>
        </table>
						</div>
					</div>
				</div>

				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingCaso">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion"
								href="#collapseCaso" aria-expanded="true"
								aria-controls="collapseCaso"> Caso Clínico </a>
						</h4>
					</div>
					<div id="collapseCaso" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingCaso">
						<div class="">
							<table class="table" style="margin: 0">

								<tr>
									<td style="padding-left: 25px"><?= h($agendamento->observacao) ?>&nbsp;</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse"
								data-parent="#accordion" href="#collapseTwo"
								aria-expanded="false" aria-controls="collapseTwo"> Equipe <span
								style="font-size: 80%">(<?php echo count($agendamento->medicos)?>)</span>
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingTwo">
						<div class="">
							<table class="table" style="margin: 0">
      <?php foreach($agendamento->medicos as $medico):?>
      	 <tr>
									<th style="padding-left: 25px">CRM nº <?= h($medico->crm); ?></th>
									<td><?= h($medico->nome); ?></td>
								</tr>
      <?php endforeach;?>
      </table>
						</div>
					</div>
				</div>
				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse"
								data-parent="#accordion" href="#collapseThree"
								aria-expanded="false" aria-controls="collapseThree">
								Procedimentos <span style="font-size: 80%">(<?php echo count($agendamento->cirurgias_procedimentos)?>)</span>
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingThree">
						<div class="">
							<table class="table" style="margin: 0">
      <?php  /*debug($agendamento->cirurgias_procedimentos); */ foreach($agendamento->cirurgias_procedimentos as $procedimento):?>
      	 <tr>
									<th style="padding-left: 25px"><?= h($procedimento->procedimento->sigla); ?></th>
									<td><?= h($procedimento->procedimento->codigo); ?> <?= h($procedimento->procedimento->descricao); ?>
            
            <span class=""><?php if($procedimento->resultado) echo '<br/>'.$this->Html->label(h($procedimento->resultado->descricao),'info'); ?> 
            <?php
							foreach ( $procedimento->motivos as $motivo )
								echo $this->Html->label ( h ( $motivo->descricao ), 'default' ) . " ";
							?> </span> <span class=""><small><?php if($procedimento->observacao) echo '<br/> <b>Obs:</b> '.h($procedimento->observacao); ?></small></span>
									</td>
								</tr>
      <?php endforeach;?>
      </table>
						</div>
					</div>
				</div>
				<div class="panel panel-default"
					style="margin: 0; border-bottom: 1px solid #ddd">
  <?php
		$docs = [ ];
		foreach ( $agendamento->cirurgias_procedimentos as $proc ) {
			
			if ($proc->procedimento->documentos) {
				?>
		 <?php
				foreach ( $proc->procedimento->documentos as $doc ) {
					if (! isset ( $docs [$doc->id] )) {
						$docs [$doc->id] = [ ];
						$docs [$doc->id] ['titulo'] = $doc->titulo;
						$docs [$doc->id] ['procs'] = [ ];
					}
					if (! in_array ( $proc->procedimento->sigla, $docs [$doc->id] ['procs'] ))
						$docs [$doc->id] ['procs'] [] = $proc->procedimento->sigla;
				}
			}
		}
		// debug($docs);
		?>
    <div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse"
								data-parent="#accordion" href="#collapseDoc"
								aria-expanded="false" aria-controls="collapseDoc"> Documentos <span
								style="font-size: 80%">(<?php echo count($docs)?>)</span>
							</a>
						</h4>
					</div>
					<div id="collapseDoc" class="panel-collapse collapse"
						role="tabpanel" aria-labelledby="headingDoc">
						<div class="">
        <?php //debug($agendamento)?>
       
        
          <table class="table" style="margin: 0">
          <?php foreach ($docs as $doc_id => $doc): ?>
          <tr>
									<th style="padding-left: 25px"><?php echo implode(', ',$doc['procs']) ?></th>
									<td>
            <?php echo $this->Html->link($doc['titulo'],['controller'=>"documentos",'action'=>'download', $doc_id]); ?>
            </td>
								</tr>
          <?php endforeach;?>
          </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
