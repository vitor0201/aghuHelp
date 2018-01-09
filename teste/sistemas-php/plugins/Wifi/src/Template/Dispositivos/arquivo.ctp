<div class="dispositivos view large-9 medium-8 columns content">
	<div class="panel panel-default">
		<div class="panel-heading"> 
	          <h3>Arquivo <small><?= h($arquivo) ?> (<?php echo date ("d/m/Y H:i:s", filemtime($arquivo)) ?>)</small>
	          <?php echo $this->Html->link('Gerar', ['action'=>'arquivo', 1],['class'=>'btn btn-xs btn-primary'])?>
	          </h3>
		</div>
	    <div class="panel-body" >  
			<pre style="max-height: 400px; overflow: scroll;"><?php echo $file; ?></pre>    
		</div>
	</div>
</div>
