<?php
use Cake\Core\Configure;
$envMessage = Configure::read('Env.Message');
$hintColor = Configure::read('Env.hintColor') ? Configure::read('Env.hintColor') : '#ccc' ;
?>
<?php if(Configure::read('debug')): ?>
<span class="" style="background-color: <?php echo $hintColor; ?>"><?php echo $envMessage; ?></span>
<?php endif;?>