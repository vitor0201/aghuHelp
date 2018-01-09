<?php

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?php  echo $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php  echo $cakeDescription ?>:
        <?php  echo $this->fetch('title') ?>
    </title>
    <?php  echo $this->Html->meta('icon') ?>

    <?php /* echo$this->Html->css('base.css')*/ ?>
    <?php /* echo$this->Html->css('cake.css')*/ ?>
    
    <?php  echo $this->Html->script('scripts.js', array('fullBase' => true,'pathPrefix'=>'http://10.42.128.12/webroot/js/'));?>
    
    <?php  echo $this->Html->css('styles.css', array('fullBase' => true,'pathPrefix'=>'http://10.42.128.12/webroot/css/'));?>
    
    <?php  echo $this->Html->css('pacman.css', array('fullBase' => true,'pathPrefix'=>'http://10.42.128.12/webroot/css/'));?>
    
    
   
    <link href="your-path/square/red.css" rel="stylesheet">
    
    
    <?php  echo $this->fetch('meta') ?>
    <?php  echo $this->fetch('css') ?>
    <?php  echo $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?php  echo $this->fetch('title') ?></a></h1>
            </li>
        </ul>
       
    </nav>
    <?php  echo $this->Flash->render() ?>
    <section class="container clearfix">
        <?php  echo $this->fetch('content') ?>
    </section>
    <footer>
    </footer>
    
    
    
    
</body>
</html>
