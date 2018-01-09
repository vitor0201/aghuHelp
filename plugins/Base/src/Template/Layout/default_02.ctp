<?php
$cakeDescription = $this->fetch('title');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?= $this->Html->charset() ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

        <title> <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        
        <?php  echo $this->Html->script('scripts.js', array('fullBase' => true,'pathPrefix'=>'http://10.42.128.12/webroot/js/'));?>
        <?php  echo $this->Html->css('stylestoastr.css', array('fullBase' => true,'pathPrefix'=>'http://10.42.128.12/webroot/css/toastr/'));?>

        <?php /*$this->Html->css('bootstrap.css')*/ ?>
        <?= $this->Html->css('style.css') ?>

        <?= $this->fetch('fonts') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>

    </head>

    <body>    
        <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header"> <!-- Nav Topo -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                    <h3>Login</h3>
                </div> <!-- Nav Topo --> 
                 <div class="collapse navbar-collapse animated fadeIn" id="bs-example-navbar-collapse-1">  <!-- Painel Fundo Login -->
                    <ul class="nav navbar-nav navbar-right"> 
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-cog"></span></a></li>
                        <li><a href="http://10.42.128.12/exemplo/usuarios"><span class="glyphicon glyphicon-home"></span></a></li>           
                    </ul>   
                </div><!-- Painel Fundo Login -->
            </div>
        </nav> <!-- Nav login -->

               
        <div id="page-content-wrapper">
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
                <div class="row">
                    <div class="col-md-12"> 
                        
                        <div class="well lead" style= "margin-left: 0;"><p>Cadastro Cópia Controlada</p></div>
                        <div class="container">                            
                            <?php echo $this->Flash->render() ?>
                            <?php echo $this->fetch('content') ?> 
                           
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Conteudo -->     
        
    
        <footer class="footer col-md-12">
            <div class="container">
               <div class="row text-center"> 
                <p class="text-muted">Footer Padrão - Humap </p>
               </div>
            </div>
        </footer> <!-- footer -->
        
        <script type="text/javascript">
            $("#menu-toggle").click(function (e) {
                e.preventDefault();
                $("#wrapper").toggleClass("active");

            });
        </script>

    </body>
</html>
