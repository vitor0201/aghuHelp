<?php 
	$sistema = $this->request->session()->read('sistema');
?>
	<div class="navbar-header">
	    
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	      </button>
	      <span class="navbar-brand" >
	       <?php echo ($sistema ? $sistema['nome'] : 'HUMAP')?>
	      </span>
    </div>