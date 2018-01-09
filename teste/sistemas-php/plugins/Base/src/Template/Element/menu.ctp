<?php 
	$user = $this->request->session()->read('login');
	$menu = $this->request->session()->read('menu');
?>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  		<ul class="nav navbar-nav">
			<?php if($menu) echo $menu; ?>  
		</ul>
		<?php if($user):?>
			
			<span class="navbar-text navbar-right">
	      	</span>
	      
			<div class="navbar-text navbar-right" role="toolbar" aria-label="...">
			<?php // echo $this->Html->link($this->Html->icon('th'), ['plugin'=>'base','controller'=>'usuarios','action'=>'escolher'],['escape'=>false,'class'=>'text-success ', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sistemas"])?>
	      	<?php //echo $this->Html->link("<span class='admin-customerservice10'></span>", ['plugin'=>'base','controller'=>'usuarios','action'=>'escolher'],['escape'=>false,'class'=>'text-primary', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Suporte"])?>
			<!-- 
			<span class=""><small><span class="label label-danger">1</span> </small><?php echo $this->Html->icon('bell');?></span>
			 -->
			<?php //echo $this->Html->link($this->Html->icon('bell').'<span class="label label-danger">1</span>', ['plugin'=>'base','controller'=>'usuarios','action'=>'escolher'],['escape'=>false,'class'=>'btn btn-xs ', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sistemas"])?>
			
	      	<?php echo $this->Html->link($this->Html->icon('th'), ['plugin'=>'base','controller'=>'usuarios','action'=>'escolher'],['escape'=>false,'class'=>'btn btn-xs btn-success', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sistemas"])?>
			
			<?php echo $this->Html->link($this->Html->icon('off'), ['plugin'=>'base','controller'=>'usuarios','action'=>'logout'],['escape'=>false,'class'=>'btn btn-xs btn-primary', 'data-toggle'=>"tooltip",'data-placement'=>"bottom", 'title'=>"Sair"])?>
			</div>  
			 
			<p class="navbar-text navbar-right" ><?php echo $user['login'] ?> &nbsp; </p>
			
		<?php else: ?>
		
		<?php echo $this->Html->link('Login', ['plugin'=>'base','controller'=>'usuarios','action'=>'login'],['class'=>'btn btn-primary navbar-btn navbar-right'])?>
			
		<?php endif;?>
</div>
