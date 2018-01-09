<div class="panel panel-default pendencias">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left pull-right" aria-hidden="true"></span>&nbsp; '.__('Voltar'), ['action' => 'kanban','controller'=>'Estatisticas'], ['escape' => false]) ?></li>
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $pendencia->id], ['escape' => false]) ?></li>
			</ul>
		</div>


		<h3>
			Pendências <small> Alterar </small>
		</h3>
	</div>
    
   <?php
			
			echo $this->Form->create ( $pendencia, [ 
					'horizontal' => true,
					'id' => 'FormPendencias',
					'cols' => [ 
							'label' => 2,
							'input' => 4,
							'error' => 6 
					] 
			] );
			?>
    
   
   <div class="panel-body" style="position: relative;">
		<div class="panel-body">
			<table class="table">
				<tr>
					<th><?= __('Tipo de Pendência') ?></th>
					<td><?= $pendencia->has('tipo_pendencia') ? $this->Html->link($pendencia->tipo_pendencia->descricao, ['controller' => 'TipoPendencias', 'action' => 'view', $pendencia->tipo_pendencia->id]) : '' ?></td>
				</tr>
				<tr>
					<th><?= __('Observação') ?></th>
					<td><?= h($pendencia->observacao) ?></td>
				</tr>
				<tr>
					<th><?= __('Usuário') ?></th>
					<td><?=  h($pendencia->usuario_id) ?></td>
				</tr>
				<tr>
					
				<tr>
					<th><?= __('Remover') ?></th>
					<td><?=  $this->Form->checkbox ( 'deletar', ['id'=>'delete', 'class' => 'btn btn-primary'  ] );?></td>
				</tr>
				<tr></table>
		</div>

        <?php
								// echo $this->Form->input('tipo_pendencia_id', ['options' => $tipoPendencias, 'empty' => true]);
								// echo $this->Form->input('observacao', ['label'=> ' observacao']);
								/*
								 * echo $this->Form->
								 *
								 * input('usuario_id', [
								 * 'label' => ' usuario_id'
								 * ]);
								 */
								/*
								 * echo $this->Form->input('data_remocao', [
								 * 'label' => 'data_remocao',
								 * 'class' => 'date',
								 * 'type' => 'text',
								 * 'append' => $this->Html->icon('calendar')
								 * ]);
								 */
								
								echo $this->Form->input ( 'observacao', [ 
										'label' => 'Observação',
										'type' => 'textarea' 
								] );
								echo $this->Form->input ( 'observacao_remocao', [ 
										'label' => 'Observação da Remoção',
										'type' => 'textarea' 
								] );
								// debug($internados);
								?>
  
	
	</div>
	<div class="panel-footer"> 
              <?= $this->Form->button(__('Alterar'), ['id'=>'FormSaveSubmit','class' => 'btn'])?>
                
   </div>
    <?= $this->Form->end()?>
</div>

<script>
$(document).ready(function(){
	$('#FormPendencias').validate({   });
});
</script>


