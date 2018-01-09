<?php 
 	use Cake\Core\Configure;
$sistema = $this->request->session()->read('sistema');
?>

<div class="navbar-header" >
	    
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	      </button>
	     
	       <span class="navbar-brand" style="color: #66A523; font-weight: 500; text-rendering: optimizelegibility;">
	       
	       <span class="<?php echo ( isset($sistema['icon']) ? $sistema['icon'] : 'medical-hospital11')?> icon-header">  </span>
	       </span>
	      <span class="navbar-brand" style="color: #66A523;  ">
	      
	      <span class=""><?php echo ($sistema ? $sistema['nome'] : 'HUMAP - Sistemas')?> <?php echo Configure::read('Env.snippet')?></span>
	      </span>
    </div>