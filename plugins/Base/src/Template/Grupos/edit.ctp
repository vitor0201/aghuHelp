<div class="panel panel-default grupos">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $grupo->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $grupo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Grupos
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($grupo, ['horizontal' => true, 'id'=>'FormGrupos',
	    		'cols' => ['label' => 2,'input' => 4,'error' => 6 	]
			] );
   
   
     ?>
   
   <div id="PanelBody" class="panel-body" style="position:relative;">  
        
        <?php
            //echo $this->Form->input('sistema_id', ['options' => $sistemas]);
			echo $this->Form->input('descricao', ['label'=> 'Descrição']);
			echo $this->Form->input('atividade', ['type'=>'textarea','label'=> 'Atividade/Observação']);
			echo $this->Form->input('sigla', ['label'=> ' Sigla']);
			echo $this->Form->input('ativo', ['label'=> ' ATIVO']);
			
			echo $this->Form->input('is_public', ['label'=> ' PUBLIC']);
			
				
            //echo $this->Form->input('acoes._ids', ['options' => $acoes, 'multiple'=>'checkbox']);
            //echo $this->Form->input('parametros._ids', ['options' => $parametros]);
           	//echo $this->Form->input('usuarios._ids', ['options' => $usuarios]);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormGrupos').validate({  

	 });
});
</script>
