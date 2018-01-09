
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
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left pull-right" aria-hidden="true"></span>&nbsp; '.__('Voltar'), ['action' => 'internacao'], ['escape' => false]) ?></li>
				</ul>
			</div>

			<h3>
				Paciente <small><?php echo h($paciente['prontuario']) ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Nome') ?></th>
					<td><?= h($paciente['nome']) ?></td>
				</tr>
				<tr>
					<th><?= __('Prontuário') ?></th>
					<td><?= h($paciente['prontuario']) ?></td>
				</tr>
				<tr>
					<th><?= __('Número do CNS') ?></th>
					<td><?= h($paciente['nro_cartao_saude']) ?></td>
				</tr>
				<tr>
					<th><?= __('CPF') ?></th>
					<td><?= h($paciente['cpf']) ?></td>
				</tr>
				<tr>
					<th><?= __('RG') ?></th>
					<td><?= h($paciente['rg']) ?></td>
				</tr>
				<tr>
					<th><?= __('Nome da Mãe') ?></th>
					<td><?= h($paciente['nome_mae']) ?></td>
				</tr>
				<tr>
					<th><?= __('Nome do Pai') ?></th>
					<td><?= h($paciente['nome_pai']) ?></td>
				</tr>
				<tr>
					<th><?= __('Data de Nascimento') ?></th>
					<td><?= h($paciente['dt_nascimento']) ?></td>
				</tr>
				<tr>
					<th><?= __('Nacionalidade') ?></th>
					<td><?= h($paciente['nac_codigo']) ?></td>
				</tr>
				<tr>
					<th><?= __('Naturalidade') ?></th>
					<td><?= h($paciente['naturalidade']) ?></td>
				</tr>
				<tr>
					<th><?= __('Sexo') ?></th>
					<td><?= h($paciente['sexo']) ?></td>
				</tr>
				<tr>
					<th><?= __('Sexo Biológico') ?></th>
					<td><?= h($paciente['sexo_biologico']) ?></td>
				</tr>
				<tr>
					<th><?= __('Grau de Instrução') ?></th>
					<td><?= h($paciente['grau_instrucao']) ?></td>
				</tr>
				<tr>
					<th><?= __('Estado Civil') ?></th>
					<td><?= h($paciente['estado_civil']) ?></td>
				</tr>
				<tr>
					<th><?= __('Telefone') ?></th>
					<td><?= h($paciente['fone_residencial']) ?></td>
				</tr>
				<tr>
					<th><?= __('Naturalidade') ?></th>
				
				
				<tr>
					<th><?= __('Logradouro') ?></th>
					<td><?php h($paciente['Endereco_pacientes']['tipo_endereco']).': '.h($paciente['Logradouros']['nome']).' ,  número: '.h($paciente['Endereco_pacientes']['nro_logradouro'])?></td>
				
				
				<tr>
					<th><?= __('Bairro') ?></th>

					<td><?= h($paciente['Bairros']['descricao']) ?></td>
				
				
				<tr>
					<th><?=__('CEP')?></th>
					<td><?= h($paciente['Endereco_pacientes']['bcl_clo_cep']) ?></td>
				</tr>
	




			</table>



			<ul class="nav nav-tabs">



			</ul>




			<div class="tab-content"></div>

		</div>
	</div>
</div>
