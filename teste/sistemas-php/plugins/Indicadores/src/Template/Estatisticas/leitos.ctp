 <?php
	use Cake\I18n\Time;
	echo $this->Html->script ( "https://www.gstatic.com/charts/loader.js", [ 
			'block' => true 
	] );
	
	?>
<div class="panel panel-default" id="panel1">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3><?php echo __('LEITOS') ?> 
			</h3>
		</div>
		<!-- começo do body -->
		<div id="PanelBody">
			<table class="table table-bordered table-hover table-responsive"
				style="margin: 0; padding: 0; font-size: 90%; background: #FFFFFF">
				<thead>
					<tr>
						<th style="border-bottom: 1px solid #A9A9A9;" class="actions">Unidade</th>
						<th style="border-bottom: 1px solid #A9A9A9;"
							class="ajax-pagination">Total</th>
						<th style="border-bottom: 1px solid #A9A9A9;"
							class="ajax-pagination">Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<tr>
<?php
// constante que será utilizada para comparação se o leito está ocupado
define ( 'OCUPADO', 16 );
foreach ( $leitos as $leito ) :
	;
	// verifica se é uma unidade nova, somente assim criando a TR
	if ($leito ['unidade'] != $unidadeOld) :
		?>
		<td><?php echo ($leito['descricao']);?></td>
		<?php
		$unidadeOld = $leito ['unidade'];
		$cont = 0;
		// contador de leitos total por unidade
		foreach ( $leitos as $leito ) {
			if ($unidadeOld == $leito ['unidade']) {
				// echo $leito['unf_seq'];
				$cont = $cont + 1;
			}
		}
		
		?>
		<td><span class="badge"><?php echo  $cont;?></span></td>
						<td>
		<?php
		
		/*
		 * Foreach que compara todos os leitos
		 * procura todos os critérios (../CriteriosController.php) e os compara
		 */
		foreach ( $leitos as $leito ) :
			foreach ( $criterios as $crit ) {
				$cor = "";
				$dataInter = new Time ( $leito ['dt_inter'] );
				$dataAtual = new Time ();
				$diff = $dataInter->diff ( $dataAtual );
				$tempo_minutos = ($diff->days * 1440) + ($diff->h * 60) + ($diff->i);
				// verifica primeiro se o leito não está ocupado e da uma cor baseado no tipo de movimentação
				// não possui tempo, pois só pacientes internados(LEITO OCUPADO) possuem tempo
				if ($leito ['tml_cod'] != OCUPADO && $crit->movimento_id != OCUPADO) // Continuação do IF
{
					$cor = $crit->cor;
					break;
				}
				// Verifica se o tempo é maior ou menor e se o tipo de movimentação é OCUPADO
				if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ($crit->unidade_id == $leito ['unidade']) && $leito ['tml_cod'] == OCUPADO) {
					$cor = $crit->cor;
					break;
				}
				/*
				 * // busca criterio de tempo especifico para uma especialidade
				 * if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ($crit->especialidade_id == $internado ['Especialidades'] ['seq'])) {
				 * $cor = $crit->cor;
				 * break;
				 * }
				 * // busca criterio de tempo que não seja especifico (geral)
				 * if ($tempo_minutos >= $crit->inicio && $tempo_minutos <= $crit->fim && ! $crit->especialidade_id && ! $crit->unidade_id) {
				 * $cor = $crit->cor;
				 * break;
				 * }
				 */
			}
			if ($unidadeOld == $leito ['unidade']) :
				if ($leito ['tml_cod'] == OCUPADO) {
					echo $this->Html->link ( '', [ 
							'action' => 'historico',
							'controller' => 'estatisticas',
							'plugin' => 'Indicadores',
							$leito ['prontuario'] 
					], [ 
							'class' => 'glyphicon glyphicon-bed',
							'style' => 'color:' . $cor,
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => $leito ['leito'] 
					] );
				} else {
					echo ('<span class="glyphicon glyphicon-bed" aria-hidden="true" style="color:' . $cor . '" data-toggle="tooltip" data-placement="top" title="' . $leito ['leito'] . '"></span>');
				}
				?>	
			<?php 	
			endif;
		endforeach
		;
		?>
		</td>
					</tr>
	
	
	
	<?php 
	endif;
endforeach
;

?>
	
			</tbody>

			</table>
		</div>
	</div>
</div>



