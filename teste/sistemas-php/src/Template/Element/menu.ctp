<?php 
	$user = $this->request->session()->read('login');
	$menu = $this->request->session()->read('menu');
?>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  		<ul class="nav navbar-nav">
			<?php if($menu) echo $menu; ?>  
		</ul>
		<?php if($user):?>
			<div class="btn-toolbar navbar-btn navbar-right" role="toolbar" aria-label="...">
			<?php echo $this->Html->link($this->Html->icon('th'), ['controller'=>'usuarios','action'=>'escolher'],['escape'=>false,'class'=>'btn btn-default ', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sistemas"])?>
			<?php echo $this->Html->link($this->Html->icon('off'), ['controller'=>'usuarios','action'=>'logout'],['escape'=>false,'class'=>'btn btn-default ', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sair"])?>
			</div>  
			<p class="navbar-text navbar-right" ><?php echo $user['nome'] ?> &nbsp; </p>
		<?php else: ?>
		
		<?php echo $this->Html->link('Login', ['controller'=>'usuarios','action'=>'login'],['class'=>'btn btn-primary navbar-btn navbar-right'])?>
			
		<?php endif;?>
</div>
