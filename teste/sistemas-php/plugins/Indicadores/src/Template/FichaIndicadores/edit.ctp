<div class="panel panel-default fichaIndicadores">
	<div class="panel-heading">
		<div class="dropdown pull-right">
			<button class="btn dropdown-toggle btn-sm" type="button"
				id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="true">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>

				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $fichaIndicador->id], ['escape' => false]) ?></li>
				<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $fichaIndicador->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
			</ul>
		</div>


		<h3>
			Ficha Indicadores <small> Alterar </small>
		</h3>
	</div>
    
   <?php
			
			echo $this->Form->create ( $fichaIndicador, [ 
					'horizontal' => true,
					'id' => 'FormFicha Indicadores',
					'cols' => [ 
							'label' => 2,
							'input' => 4,
							'error' => 6 
					] 
			] );
			?>
    
   
   <div class="panel-body" style="position: relative;">
		<div class="well well-sm">1. Dados Gerais do Indicador</div>
        <?php
								echo $this->Form->input ( 'indicador_id', [ 
										'options' => $indicadores,
										'empty' => true,
										'label' => 'Nome' 
								] );
								echo $this->Form->input ( 'identificador', [ 
										'label' => ' Identificador do Indicador' 
								] );
								echo $this->Form->input ( 'area', [ 
										'label' => ' Área' 
								] );
								echo $this->Form->input ( 'nivel', [ 
										'label' => ' Nível do Indicador' 
								] );
								echo $this->Form->input ( 'eixo', [ 
										'label' => ' Eixo' 
								] );
								echo $this->Form->input ( 'Tipo', [ 
										'label' => ' Tipo' 
								] );
								echo $this->Form->input ( 'parametro', [ 
										'label' => 'Parâmetro' 
								] );
								echo $this->Form->label ( 'Finalidade do Indicador' );
								echo $this->Form->textarea ( 'finalidade', [ 
										'label' => ' Finalidade do Indicador' 
								] );
								echo '<hr/>';
								echo $this->Form->input ( 'historico', [ 
										'label' => ' Histórico de Homologação' 
								] );
								?>
								
																
        <div class="well well-sm">2. Dados Gerais sobre o Responsável</div>
        <?php
								echo $this->Form->input ( 'responsavel', [ 
										'label' => 'Responsável' 
								] );
								
								echo $this->Form->input ( 'telefone', [ 
										'label' => ' Telefone' 
								] );
								
								echo $this->Form->input ( 'email', [ 
										'label' => 'E-Mail' 
								] );
								
								?>
		<div class="well well-sm">3. Dados sobre a coleta do Indicador</div>
        <?php
								
								echo $this->Form->input ( 'objetivo', [ 
										'label' => ' Objetivo Estratégico' 
								] );
								
								echo $this->Form->input ( 'formula', [ 
										'label' => ' Fórmula' 
								] );
								
								echo $this->Form->input ( 'homologacao', [ 
										'label' => ' Homologação' 
								] );
								
								echo $this->Form->input ( 'fonte', [ 
										'label' => 'Fonte' 
								] );
								
								echo $this->Form->input ( 'periocidade', [ 
										'label' => 'Periocidade' 
								] );
								echo $this->Form->input ( 'unidade_medicao', [ 
										'label' => 'Unidade de Medição' 
								] );
								echo $this->Form->input ( 'coleta_dados', [ 
										'label' => 'Coleta de Dados' 
								] );
								
								echo $this->Form->label ( 'Termos' );
								echo $this->Form->textarea ( 'termos', [ 
										'label' => ' Termos' 
								] );
								?>
  </div>
	<div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormFicha Indicadores').validate({   });
});
</script>
