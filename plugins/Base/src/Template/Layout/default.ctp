<?php
use Cake\Core\Configure;
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc.
 * (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @since 0.10.0
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'CakePHP: the rapid development php framework';

?>
<!DOCTYPE html>
<html >
<head>
        <?php echo $this->Html->charset()?>
        <meta name="viewport"
	content="width=device-width, initial-scale=1.0">
<title>
           HUMAP - <?php echo ($sistema ? $sistema['nome'] : 'Sistemas')?>
        </title>
         <?php  echo $this->Html->meta('icon')?>
        <?php //echo  $this->Html->meta('icon')  ?>


        <?php //echo   $this->Html->css('cake.css')  ?>

        <?php echo   $this->Html->css('medical/flaticon.css');  	?>
        <?php echo   $this->Html->css('admin/flaticon.css');	  	?>
          
        <?php echo $this->Html->script('scripts.js'); ?>
        <?php echo $this->Html->script('jquery.jqplot.min.js'); ?>
        <?php echo $this->Html->script('jqplot-plugins/jqplot.donutRenderer.js'); ?>
        <?php echo $this->Html->script('jqplot-plugins/jqplot.pieRenderer.js'); ?>
        <?php //echo $this->Html->script('scripts.js', array('fullBase' => true, 'pathPrefix' => 'http://10.42.128.25/webroot/js/')); ?>

        
 		<?php echo $this->Html->css('styleTemplate.css' ); ?>
        <?php echo $this->Html->css('styles.css' ); ?>
        <?php echo $this->Html->css('jquery.jqplot.css' ); ?>
        <?php echo $this->Html->css('hover-min.css' ); ?>
       
         
         <?php echo $this->Html->script('horizon-swiper.min.js'); ?>
         <?php echo $this->Html->css('horizon-swiper.min.css' ); ?>
         <?php echo $this->Html->css('horizon-theme.min.css' ); ?>
        
        
       
        
        
        <?php //echo $this->Html->css('styles.css', array('fullBase' => true, 'pathPrefix' => 'http://10.42.128.25/webroot/css/')); ?>
        
		<!-- 
		<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
		 -->
		
        <?php echo $this->fetch('meta'); 			?>
        <?php echo $this->fetch('css'); 			?>
        <?php echo $this->fetch('script'); 			?>
        <?php echo $this->Html->css('fonts.css' ); 	?>
         <script src="http://code.angularjs.org/1.0.1/angular-1.0.1.min.js"></script>
        <script>

        	// mascara
        	
            $(document).ready(function() {

            	 
            		/*
            	$.sessionTimeout({

            	    keepAliveUrl: 'keep-alive.html',
            	    logoutUrl: 'login.html',
            	    redirUrl: 'locked.html',
            	    ignoreUserActivity: true,
            	    warnAfter: <?php echo (Configure::read('Session.timeout')-1) * 60 * 1000 ;?>,
            	    redirAfter: <?php echo Configure::read('Session.timeout') * 60 * 1000 ;?>,
            	    message: '',
            	    title: '',
            	    keepAliveButton: 'Revalidar Sessão',
            	    logoutButton: 'Sair',
            	    countdownSmart : true,
            	    countdownMessage: '<center><h4>Sua sessão expira em<br/><span style="color:#ccc; font-size:4.5em;">{timer}</span></h4></center>',

            	    onRedir: function() {
                	    //alert('saiu');
            	    	//$('#session-timeout-dialog').modal('hide');
            	    	$('#session-timeout-dialog .modal-body').html('<p></p><p></p><center><h4>Sua sessão expirou!<br/></center>');

            	    	$('#session-timeout-dialog-keepalive').hide();
            	    	$('#session-timeout-dialog-logout').html('Refazer Login');
            	    	
            	    }
            	    //onWarn: function() {
            	    //	$('#modalTimeout').modal('show');
            	    //}

            	   
            	    //countdownBar: true
            	});
	            	*/
	            	
            	
            	  $('.date').mask('00/00/0000');
            	  $('.time').mask('00:00:00');
            	  $('.hour_min').mask('00:00');
            	  $('.date_time').mask('00/00/0000 00:00:00');
            	  $('.cep').mask('00000-000');
            	  $('.phone').mask('0000-0000');
            	  $('.phone_with_ddd').mask('(00) 0000-0000');
            	  $('.phone_us').mask('(000) 000-0000');
            	  $('.mixed').mask('AAA 000-S0S');
            	  $('.cpf').mask('000.000.000-00', {reverse: true});
            	  $('.money').mask('000.000.000.000.000,00', {reverse: true});
            	  $('.integer').mask('000000000', {reverse: true});
            	  $('.money2').mask("#.##0,00", {reverse: true});
            	  $('.ip_address').mask('099.099.099.099');
            	  $('.mac_address').mask('AA:AA:AA:AA:AA:AA'); // wagner
            	  $('.percent').mask('##0,00%', {reverse: true});


            	// validacao: coloca tag e classes bootstrap indicando erro
                 $.validator.setDefaults({
                  //jQuery.validator.setDefaults({
              		highlight: function(element) {
              	        $(element).closest('.form-group').addClass('has-error');
              	    },
              	    unhighlight: function(element) {
              	        $(element).closest('.form-group').removeClass('has-error');
              	    },
              	    errorElement: 'span',
              	    errorClass: 'help-block error-message col-md-6',
              	    errorPlacement: function(error, element) {
              	    	error.appendTo($(element).closest('.form-group'));
              	    	//;
              	        //if(element.parent('.input-group').length) {
              	        //    error.insertAfter(element.parent());
              	        // } else {
              	        //  error.insertAfter(element.parent());
              	        // }
              	    }
              	});
              	
				/*
              	 $.validator.methods.date = function(value, element) {
                     return this.optional(element) || parseDate(value, "dd/MM/yyyy") !== null;
                 };
                 */

                 $.validator.addMethod(
                		    "date",
                		    function ( value, element ) {
                		        var bits = value.match( /([0-9]+)/gi ), str;
                		        if ( ! bits )
                		            return this.optional(element) || false;
                		        str = bits[ 1 ] + '/' + bits[ 0 ] + '/' + bits[ 2 ];
                		        return this.optional(element) || !/Invalid|NaN/.test(new Date( str ));
                		    },
                		    "Please enter a date in the format dd/mm/yyyy"
                		);

                 $.extend($.validator.messages, {
                		required: "Campo obrigat&oacute;rio.",
                		remote: "Por favor, corrija este campo.",
                		email: "Por favor, introduza um e-mail v&aacute;lido.",
                		url: "Por favor, introduza um URL v&aacute;lido.",
                		date: "Por favor, introduza uma data v&aacute;lida.",
                		dateISO: "Por favor, introduza uma data v&aacute;lida (ISO).",
                		number: "Por favor, introduza um n&uacute;mero v&aacute;lido.",
                		digits: "Por favor, introduza apenas d&iacute;gitos.",
                		creditcard: "Por favor, introduza um n&uacute;mero de cart&atilde;o de cr&eacute;dito v&aacute;lido.",
                		equalTo: "Por favor, introduza de novo o mesmo valor.",
                		extension: "Por favor, introduza um ficheiro com uma extens&atilde;o v&aacute;lida.",
                		maxlength: $.validator.format("Por favor, n&atilde;o introduza mais do que {0} caracteres."),
                		minlength: $.validator.format("Por favor, introduza pelo menos {0} caracteres."),
                		rangelength: $.validator.format("Por favor, introduza entre {0} e {1} caracteres."),
                		range: $.validator.format("Por favor, introduza um valor entre {0} e {1}."),
                		max: $.validator.format("Por favor, introduza um valor menor ou igual a {0}."),
                		min: $.validator.format("Por favor, introduza um valor maior ou igual a {0}."),
                		nifES: "Por favor, introduza um NIF v&aacute;lido.",
                		nieES: "Por favor, introduza um NIE v&aacute;lido.",
                		cifES: "Por favor, introduza um CIF v&aacute;lido.",
                		  cpfBR: "Por favor, introduza um CPF válido.", // wagner
                          ipv4: "Por favor, introduza um IP válido." // wagner
                	});
                	          		

                jQuery(".ajax-pagination a").click(
      		            function()
      		            {                
      		                var thisHref = $(this).attr('href');
      		                if (!thisHref) {
      		                        return false;
      		                }
      		                jQuery.ajax({
      		                    type:'GET',
      		                    async: true,
      		                    cache: false,
      		                    url: thisHref,
      		                    beforeSend : function () {
      		                    	 jQuery('#PanelBody').fadeTo(300,0, function() {  });
      		                        //jQuery('#AjaxContent').block();
      		                    },
      		                    success: function(response) {
      		                        jQuery('#AjaxContent').html(response);
      		                        jQuery('#PanelBody').fadeTo(100,1);
      		                    }
      		                });
      		                return false;
      		
      		            }
      		    );


                jQuery(".ajax-link").click(
      		            function()
      		            {                
      		
      		                var thisHref = $(this).attr('href');
      		              	var thisupdt = $(this).attr('data-target');
      		                if (!thisHref) {
      		                        return false;
      		                }
      		                jQuery.ajax({
      		                    type:'GET',
      		                    async: true,
      		                    cache: false,
      		                    url: thisHref,
      		                    beforeSend : function () {
      		                    	 //jQuery('#PanelBody').fadeTo(300,0, function() {  });
      		                        //jQuery('#AjaxContent').block();
      		                    },
      		                    success: function(response) {
      		                        jQuery(thisupdt).html(response);
      		                      	
      		                        //jQuery('#PanelBody').fadeTo(100,1);
      		                    }
      		                });
      		                return false;
      		
      		            }
      		    );


                jQuery(".delete-confirm").click(
      		            function()
      		            {                
      		                var thisHref = $(this).attr('href');
      		                if (!thisHref) {
      		                        return false;
      		                }
      		                swal({
      		                    title: "Confirma a remoção?",
      		                    text: "Após confirmar, não será possível recuperar o registro!",
      		                    //type: "warning",
      		                    showCancelButton: true,
      		                    confirmButtonColor: "#DD6B55",
      		                    confirmButtonText: "Sim!",
      		                    cancelButtonText: "Não",
      		                    closeOnConfirm: false
      		                }, function (isConfirm) {
      		                    if (!isConfirm) return;

      		                    var newForm = jQuery('<form>', {
      		                        'action': thisHref,
      		                        'method' : 'POST'
      		                    });
      		                    newForm.appendTo(document.body).submit();
      		                });
      		                return false;
      		            }
      		    );

                
                  $(function(){
                      $('[data-toggle="popover"]').popover({
                          container: 'body',
                          trigger: 'focus',
                          html: true,
                          content: function () {
                              var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                              return clone;
                          }
                      }).click(function(e) {
                          e.preventDefault();
                          e.stopPropagation();
                          //$(this).popover('show');
                      });
                  });
                  $('html').click(function() {
                      $('[data-toggle="popover"]').each(function () {
                      	$(this).popover('hide');
                      });
                      
                  });

                  $(function () {
                  	  $('[data-toggle="tooltip"]').tooltip()
                  });


                
                 	
                    $('input').iCheck({
                      checkboxClass: 'icheckbox_square-blue',
//                       radioClass: 'icheckbox_square-blue',
                      radioClass: 'iradio_square-blue',
                      increaseArea: '20%' // optional
                    });
                    

                    $('.date').datetimepicker({ format: 'DD/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true    });
                    $('.datetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm:ss', showClear: true, useCurrent: false, showTodayButton: true    });
                    $('.time').datetimepicker({     format: 'HH:mm:ss', showClear: true, useCurrent: false    });
                    $('.hour_min').datetimepicker({     format: 'HH:mm', showClear: true, useCurrent: false    });

                    
                     $("select.select2").select2();


                     var ModalResponse = new Array();
                
            });

            $('#session-timeout-dialog').on('show.bs.modal', function (e) {
            	  // do something...
          	  ALERT('MOSTRA');
            })
                
        </script>
<style>


.spinner {
  margin: 50px;
  height: 28px;
  width: 28px;
  animation: rotate 0.8s infinite linear;
  border: 8px solid #fff;
  border-right-color: transparent;
  border-radius: 50%;
}

@keyframes rotate {
  0%    { transform: rotate(0deg); }
  100%  { transform: rotate(360deg); }
}

.signal {
    border: 5px solid #2980b9;
    border-radius: 30px;
     height: 25px;
/*     left: 50%; */
/*     margin: -15px 0 0 -15px; */
    opacity: 0;
/*     position: absolute; */
/*     top: 50%; */
    width: 25px;
 
    animation: pulsate 1s ease-out;
    animation-iteration-count: infinite;
}

@keyframes pulsate {
    0% {
      transform: scale(.1);
      opacity: 0.0;
    }
    50% {
      opacity: 1;
    }
    100% {
      transform: scale(1.2);
      opacity: 0;
    }
}

.select2-container .select2-selection--single {

height: 34px;
padding: 2px;

border: 1px solid #ccc;

}
.select2-container--default .select2-selection--multiple {
border: 1px solid #ccc;
}

#session-timeout-dialog .modal-header {
	display: none;
}

#session-timeout-dialog .modal-footer {
	text-align: center;
}

html {
	position: relative;
	min-height: 100%;
}

body {
	font-family: 'Roboto', sans-serif;
	background-color: #ddd; /*#e5f1d6; #f5f8f9;*/
	padding-top: 80px;
	font-size: 15px;
	color: #4b4b4b; /*#575757; */
	text-rendering: optimizeLegibility !important;
	-webkit-font-smoothing: antialiased !important;
}

body>.container {
	/*padding: 25px 15px 0; */
	
}

.footer {
	position: fixed;
	bottom: 0;
	width: 100%;
	/* Set the fixed height of the footer here */
	height: 37px;
	background-color: #ddd; /*#f5f5f5;*/
	margin-top: 20px;
	z-index: 9999999;
}

#container {
	/* margin-top: 25px; */
	
}

.ajax-pagination a {
	text-decoration: none;
}

.asc:after {
	content: " \2193";
}

.desc:after {
	content: " \2191";
}

.panel {
	border: 0px;
}

.panel-heading h3 {
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	line-height: normal;
	width: 75%;
	font-size: 18px;
	display: block;
	margin: 5px;
	color: #666;
	/* text-transform: uppercase; */
}

.pagination {
	margin: 5px 0;
}

.panel-title a {
	display: block;
	padding: 10px 15px;
	margin: -10px -15px;
	cursor: pointer;
	text-decoration: none;
	font-size: 15px;
	color: #666;
}

.panel-title a:after {
	font-family: 'Glyphicons Halflings';
	content: "\e114";
	float: right;
	color: grey;
}

.panel-title a.collapsed:after {
	content: "\e080";
}

/* for icheck + form-horizontal */
.radio label, .checkbox label {
	padding-left: 0px;
}

.icon-header {
	font-size: 45px;
	line-height: 0.5;
}

.name-header {
	font-size: 25px;
}

.white {
	color: #fff;
}

.box {
	cursor: pointer;
}

.btn-lg {
	font-size: 38px;
	line-height: 1.33;
	border-radius: 6px;
}

.box>.icon {
	text-align: center;
	position: relative;
}

.box>.icon>.image {
	position: relative;
	z-index: 2;
	margin: auto;
	width: 88px;
	height: 88px;
	border: 7px solid #f5f8f9;
	line-height: 88px;
	border-radius: 50%;
	background: #63B76C;
	vertical-align: middle;
}

.box>.icon:hover>.image {
	border-color: #63B76C;
}

.box>.icon>.image>i {
	font-size: 40px !important;
	color: #fff !important;
}

.box>.icon:hover>.image>i {
	color: white !important;
}

.box>.icon>.info {
	margin-top: -32px;
	background: rgba(0, 0, 0, 0.04);
	border: 1px solid #e0e0e0;
	padding: 15px 0 10px 0;
}

.box>.icon>.info>h3.title, h4.title {
	color: #777;
	font-weight: 500;
	margin-top: 20px;
	margin-bottom: 10px;
}

.box>.icon>.info>p {
	color: #666;
	line-height: 1.5em;
	margin: 20px;
}

.box>.icon:hover>.info>h3.title, h4.title, .box>.icon:hover>.info>p,
	.box>.icon:hover>.info>.more>a {
	color: #222;
}

.box>.icon>.info>.more a {
	color: #777;
	line-height: 12px;
	text-transform: uppercase;
	text-decoration: none;
}

.box>.icon:hover>.info>.more>a {
	color: #222;
	/* padding: 6px 8px;
    border-bottom: 4px solid black;*/
}

.box .space {
	height: 30px;
}

.row-centered {
	text-align: center;
}

.col-centered {
	display: inline-block;
	float: none;
	/* reset the text-align */
	text-align: left;
	/* inline-block space fix */
	margin-right: -4px;
}

#no-more-tables td.action {
	padding-left: 20px;
}

@media only screen and (max-width: 800px) {
	/* Force table to not be like tables anymore */
	#no-more-tables table, #no-more-tables thead, #no-more-tables tbody,
		#no-more-tables th, #no-more-tables td, #no-more-tables tr {
		display: block;
	}

	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	#no-more-tables tr {
		border-bottom: 1px solid #eee;
	}
	#no-more-tables td {
		/* Behave like a "row" */
		border: none;
		/*border-bottom: 1px solid #eee;*/
		position: relative;
		padding-left: 35%;
		white-space: normal;
		text-align: left;
		margin-left: 12px;
	}
	#no-more-tables td.action {
		text-align: left;
		line-height: 35px;
		padding: 5px 15px 0px 5px;
	}
	#no-more-tables td:before {
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 30%;
		padding-right: 10px;
		white-space: nowrap;
		text-align: left;
		font-weight: bold;
	}

	/*
        Label the data
        */
	#no-more-tables td:before {
		content: attr(data-title);
	}
}

.text-xs-left {
	text-align: left;
}

.text-xs-right {
	text-align: right;
}

.text-xs-center {
	text-align: center;
}

.text-xs-justify {
	text-align: justify;
}

@media ( min-width : @screen-sm-min) {
	.text-sm-left {
		text-align: left;
	}
	.text-sm-right {
		text-align: right;
	}
	.text-sm-center {
		text-align: center;
	}
	.text-sm-justify {
		text-align: justify;
	}
}

@media ( min-width : @screen-md-min) {
	.text-md-left {
		text-align: left;
	}
	.text-md-right {
		text-align: right;
	}
	.text-md-center {
		text-align: center;
	}
	.text-md-justify {
		text-align: justify;
	}
}

@media ( min-width : @screen-lg-min) {
	.text-lg-left {
		text-align: left;
	}
	.text-lg-right {
		text-align: right;
	}
	.text-lg-center {
		text-align: center;
	}
	.text-lg-justify {
		text-align: justify;
	}
}

/* essential */
.ellipsis {
	white-space: nowrap;
	overflow: hidden;
	/* for good looks */
	padding: 10px;
}
</style>



<style>
#fixed-controls {
	position: fixed;
	z-index: 3;
	top: 100%;
	margin-top: -100px;
	/* background: #fff; */
	/* border: #ddd 1px solid; */
	/* width: 0px; */
	font-size: 20px;
	right: 0;
}

.animated {
	-webkit-animation-duration: 0.55s;
	animation-duration: 0.55s;
}
</style>
<script>
var is_hide = true;
$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 800) {
       	if(is_hide) {
       		is_hide = false;
	    	$('#fixed-controls').removeClass('bounceOut');
	        $('#fixed-controls').show();
       	}
    } else {

        if(!is_hide) {
    	$('#fixed-controls').addClass('bounceOut');
    	
    	setTimeout(function () {
    		is_hide = true;
//     		 $('#fixed-controls').removeClass('bounceOut');
    		 $('#fixed-controls').hide();
    		}, 500
    	);
        }
    }

});
</script>



</head>
<body>

	<div id="fixed-controls" class="animated bounceIn "
		style="display: none">

		<div class="btn-group-vertical" role="group">
			<a href="#" class="btn btn-default "
				onclick='$("html, body").animate({ scrollTop: 0 }, "slow");'><span
				class="glyphicon glyphicon-arrow-up"></span></a> <a href="#"
				class="btn btn-default "
				onclick='$("html, body").animate({ scrollTop: $(document).height() }, 500);'><span
				class="glyphicon glyphicon-arrow-down"></span></a>
		</div>

	</div>
        <?php echo  $this->element('Base.navbar')?>
        
        <div id="container" class="container">
		<div id="content" class="row">
            
           
            <?php
            // debug(Configure::read('Session.timeout'));
            ?>
                <?php echo $this->Flash->render()?>
                <?php echo $this->fetch('content'); ?>
            </div>
            
            <?php //echo $this->element('Base.env'); ?>
             
        </div>
	<div class="modal fade" id="modalDefault" tabindex="-1" role="dialog">
		<div class="modal-dialog" id="modalDefaultDialog"></div>
	</div>

	<div class="modal fade bs-example-modal-sm" id="modalTimeout"
		tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body text-center" style="padding: 35PX 15px">
					<h4>
						Sua sessão expira em<br /> <span
							style="font-size: 4.5em; color: #ccc;">10</span> <br />segundos
					</h4>
					<br />
					<button type="button" class="btn btn-primary">REVALIDAR SESSÃO</button>
				</div>


			</div>
		</div>
	</div>

</body>
</html>