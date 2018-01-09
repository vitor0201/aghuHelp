
<div class="medicos view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $medico->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $medico->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Médico</h3>
	</div>
    
    <table class="table">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($medico->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('CRM') ?></th>
            <td><?= h($medico->crm) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
           <td><?= $medico->ativo ? __('SIM') : __('NÃO'); ?></td>
        </tr>
        <tr>
            <th><?= __('Residente') ?></th>
            <td><?= $medico->residente ? __('SIM') : __('NÃO'); ?></td>
         </tr>
        <tr>
            <th><?= __('Preceptor') ?></th>
            <td><?= $medico->preceptor ? __('SIM') : __('NÃO'); ?></td>
         </tr>
         
          <tr>
            <th><?= __('Cor na Agenda') ?></th>
            <td><?= h($medico->cor_agenda);  ?> <?php echo '<div id="setColor" style="width:20px;float:left;margin-right:10px;   background: '.$medico->cor_agenda.'"> &nbsp;</div>'; ?></td>
         </tr>
    </table>
   
  
  <div class="panel-body">    

    



	    	<?php if (!empty($medico->disponibilidades)): ?>
	    	
	    	
	    	
	    	<h4>Disponibilidade</h4>
	    	<div class="col-md-5">
        	
        	<table class="table  table-bordered">
        		<tr>
        			<th>&nbsp;</th>
        			<?php $dia_semana = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb']?>
        			<?php foreach($dia_semana as $dia => $semana): ?>
        			<th class="text-center"><?php echo $semana; ?></th>
        			<?php endforeach; ?>
        		</tr>
        		<?php $i=0; ?>
        		<?php foreach($periodos as $periodo_id => $periodo): ?>
	        		<tr>
	        				<th style="vertical-align: middle; text-align: center;">
			        			<?php echo $periodo; ?>
			        		</th>
			        		<?php  $d=0; ?>
	        				<?php foreach($dia_semana as $dia => $semana): ?>
	        					<?php
	        					$estaDisponivel = false;
	        					foreach ($medico->disponibilidades as $disponibilidades){
									if(	$disponibilidades['dia_semana']==$dia &&  
										$disponibilidades['periodo_id']==$periodo_id &&
										$disponibilidades['ativo']
										){
										$estaDisponivel = true;
										break;
									}
								}
	        					?>
	        				
			        			<td class="text-center">
			        			<?php if($estaDisponivel): ?>
			        			<div class="icheckbox_square-blue checked" style="cursor: auto;" ></div>
			        			<?php else: ?>
			        			<div class="icheckbox_square-blue " style="cursor: auto;" ></div>
			        			<?php endif;?>
			        			</td>
	        				<?php endforeach;?>
	        		</tr>
        		<?php endforeach; ?>
        	</table>
        </div>
	    	 <?php else: ?>
	    <div class="alert alert-warning">Disponibilidade não cadastrada</div>
	    <?php endif; ?>
	    <div class="clearfix" ></div>
	    	
	    	
	  
		    
	    	<h4>Portifólio <small>(procedimentos)</small></h4>

	    	<?php if (!empty($medico->procedimentos)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
		                <th><?= __('Código') ?></th>
		                <th><?= __('Descrição') ?></th>
	            </tr>
	         </thead>
	            <?php foreach ($medico->procedimentos as $procedimentos): ?>
	            <?php 
	            	$class="";
	            	//if(!$procedimentos->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	              
	                <td><?= h($procedimentos->codigo) ?></td>
	                <td><?= h($procedimentos->descricao) ?></td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Procedimentos não cadastrados.</div>
	    <?php endif; ?>
	    </div>
		

</div>
</div>
</div>
