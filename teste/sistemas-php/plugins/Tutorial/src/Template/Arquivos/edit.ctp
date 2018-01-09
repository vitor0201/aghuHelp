<div class="panel panel-default arquivos">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
										<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $arquivo->id], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $arquivo->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
			</div>
	
	
            <h3>
            Arquivos
            <small>
                        Alterar
                        </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($arquivo, ['horizontal' => true, 'id' => 'FormArquivos',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
            echo $this->Form->input('categoria_id', ['options' => $categorias]);





             
					echo $this->Form->input('titulo', ['label'=> ' titulo']);
				





             
					echo $this->Form->input('autor', ['label'=> ' autor']);
				





             
					echo $this->Form->input('descricao', ['label'=> ' descricao']);
				





             
					echo $this->Form->input('ativo', ['label'=> ' ativo']);
				





             
					echo $this->Form->input('arquivo_caminho', ['label'=> ' arquivo_caminho']);
				



						$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('arquivo_tamanho', ['label' => 'arquivo_tamanho', 'class'=>'integer', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				

             
					echo $this->Form->input('arquivo_tamanho', ['label'=> ' arquivo_tamanho']);
				





             
					echo $this->Form->input('arquivo_type', ['label'=> ' arquivo_type']);
				
					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
					$this->Form->setHorizontal(true);
					echo $this->Form->input('data_publicacao', ['label' => 'data_publicacao', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);




            echo $this->Form->input('tags._ids', ['options' => $tags]);
        ?>
  </div>
   <div class="panel-footer"> 
              <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
                
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#FormArquivos').validate({   });
});
</script>
