<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
echo $this->fetch('content');
?>
 <script type="text/javascript">

	            	
            	
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
              	    errorClass: 'help-block',
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


                
                 	/*
                    $('input').iCheck({
                      checkboxClass: 'icheckbox_square-blue',
                      radioClass: 'icheckbox_square-blue',
                      increaseArea: '20%' // optional
                    });
                    */

                    $('.date').datetimepicker({     format: 'DD/MM/YYYY', showClear: true, useCurrent: false, showTodayButton: true    });
                    $('.datetime').datetimepicker({     format: 'DD/MM/YYYY HH:mm:ss', showClear: true, useCurrent: false, showTodayButton: true    });
                    $('.time').datetimepicker({     format: 'HH:mm:ss', showClear: true, useCurrent: false    });
                    $('.hour_min').datetimepicker({     format: 'HH:mm', showClear: true, useCurrent: false    });

                    
                    $("select.select2").select2();


                     //var ModalResponse = new Array();

                    
                    
                
       

			
                
        </script>