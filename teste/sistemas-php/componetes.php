<html>
<body>


	<div class="panel panel-default">
		<div class="panel-body">

			<h1>Toastr with FontAwesome Icons</h1>
			<button class="btn btn-primary " onclick="chamatoastr()">Alert</button>
			<script>
            function chamatoastr() {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "9380000",
                    "hideDuration": "8950000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.info('Are you the 6 fingered man?');

                toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!');

                // Display a success toast, with a title
                toastr.success('Have fun storming the castle!', 'Miracle Max Says');

                // Display an error toast, with a title
                toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
            }


        </script>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">

			<h1>Load-awesome/animations/pacman.html</h1>

			<div style="color: #f68f6f" class="la-pacman la-3x">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<a href="http://fronteed.com/iCheck/#skins"><h1>iCheck</h1></a> <input
				type="checkbox"> <input type="checkbox" checked> <input type="radio"
				name="iCheck"> <input type="radio" name="iCheck" checked>


			<script>
            $(document).ready(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                });
            });
        </script>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<a href=" https://select2.github.io/examples.html#placeholders"><h1>Select2</h1></a>
			<select class="js-example-placeholder-multiple" multiple="multiple"
				style="width: 75%">
				<option value="MS">Mato Grosso do Sul</option>
				<option value="SP">São Paulo</option>
				<option value="PR">Paraná</option>
				<option value="AM">Amazonas</option>
			</select>
		</div>
		<script>
        $(document).ready(function () {
            $(".js-example-placeholder-multiple").select2({placeholder: "Selecione os estados"});
        });
    </script>
	</div>


	<div class="panel panel-default">
		<div class="panel-body">
			<a href="http://t4t5.github.io/sweetalert/"><h1>Sweetalert</h1></a>
			<button class="btn btn-primary " onclick="chamasweet()">Alert</button>
			<script>
            function chamasweet() {
                swal({title: "Auto close alert!", text: "I will close in 2 seconds.", timer: 2000, showConfirmButton: false});
            }
        </script>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<a href="http://t4t5.github.io/sweetalert/"><h1>Treegrid</h1></a>


			<script type="text/javascript">
            $(document).ready(function () {
                $('.tree').treegrid();
            });
        </script>

			<table class="table tree">
				<tbody>
					<tr class="treegrid-1 treegrid-expanded">
						<td><span
							class="treegrid-expander glyphicon glyphicon-chevron-down"></span>Root
							node 1</td>
						<td>Additional info</td>
					</tr>
					<tr class="treegrid-2 treegrid-parent-1">
						<td><span class="treegrid-indent"></span><span
							class="treegrid-expander"></span>Node 1-1</td>
						<td>Additional info</td>
					</tr>
					<tr class="treegrid-3 treegrid-parent-1 treegrid-expanded">
						<td><span class="treegrid-indent"></span><span
							class="treegrid-expander glyphicon glyphicon-chevron-down"></span>Node
							1-2</td>
						<td>Additional info</td>
					</tr>
					<tr class="treegrid-4 treegrid-parent-3">
						<td><span class="treegrid-indent"></span><span
							class="treegrid-indent"></span><span class="treegrid-expander"></span>Node
							1-2-1</td>
						<td>Additional info</td>
					</tr>

				</tbody>
			</table>

		</div>
	</div>

	<div class="panel panel-default">
		<h1>
			<a href="https://daneden.github.io/animate.css/">animate.css</a>
		</h1>
		<div class="panel-body">

			<span class="" id="animationSandbox" style="display: block;"><h1
					style="color: #EDBD26; font-size: 52px;">Animate.css</h1></span>
			<form>
				<select class="input input--dropdown js--animations">
					<optgroup label="Attention Seekers">
						<option value="bounce">bounce</option>
						<option value="flash">flash</option>
						<option value="pulse">pulse</option>
						<option value="rubberBand">rubberBand</option>
						<option value="shake">shake</option>
						<option value="swing">swing</option>
						<option value="tada">tada</option>
						<option value="wobble">wobble</option>
						<option value="jello">jello</option>
					</optgroup>

					<optgroup label="Bouncing Entrances">
						<option value="bounceIn">bounceIn</option>
						<option value="bounceInDown">bounceInDown</option>
						<option value="bounceInLeft">bounceInLeft</option>
						<option value="bounceInRight">bounceInRight</option>
						<option value="bounceInUp">bounceInUp</option>
					</optgroup>

					<optgroup label="Bouncing Exits">
						<option value="bounceOut">bounceOut</option>
						<option value="bounceOutDown">bounceOutDown</option>
						<option value="bounceOutLeft">bounceOutLeft</option>
						<option value="bounceOutRight">bounceOutRight</option>
						<option value="bounceOutUp">bounceOutUp</option>
					</optgroup>

					<optgroup label="Fading Entrances">
						<option value="fadeIn">fadeIn</option>
						<option value="fadeInDown">fadeInDown</option>
						<option value="fadeInDownBig">fadeInDownBig</option>
						<option value="fadeInLeft">fadeInLeft</option>
						<option value="fadeInLeftBig">fadeInLeftBig</option>
						<option value="fadeInRight">fadeInRight</option>
						<option value="fadeInRightBig">fadeInRightBig</option>
						<option value="fadeInUp">fadeInUp</option>
						<option value="fadeInUpBig">fadeInUpBig</option>
					</optgroup>

					<optgroup label="Fading Exits">
						<option value="fadeOut">fadeOut</option>
						<option value="fadeOutDown">fadeOutDown</option>
						<option value="fadeOutDownBig">fadeOutDownBig</option>
						<option value="fadeOutLeft">fadeOutLeft</option>
						<option value="fadeOutLeftBig">fadeOutLeftBig</option>
						<option value="fadeOutRight">fadeOutRight</option>
						<option value="fadeOutRightBig">fadeOutRightBig</option>
						<option value="fadeOutUp">fadeOutUp</option>
						<option value="fadeOutUpBig">fadeOutUpBig</option>
					</optgroup>

					<optgroup label="Flippers">
						<option value="flip">flip</option>
						<option value="flipInX">flipInX</option>
						<option value="flipInY">flipInY</option>
						<option value="flipOutX">flipOutX</option>
						<option value="flipOutY">flipOutY</option>
					</optgroup>

					<optgroup label="Lightspeed">
						<option value="lightSpeedIn">lightSpeedIn</option>
						<option value="lightSpeedOut">lightSpeedOut</option>
					</optgroup>

					<optgroup label="Rotating Entrances">
						<option value="rotateIn">rotateIn</option>
						<option value="rotateInDownLeft">rotateInDownLeft</option>
						<option value="rotateInDownRight">rotateInDownRight</option>
						<option value="rotateInUpLeft">rotateInUpLeft</option>
						<option value="rotateInUpRight">rotateInUpRight</option>
					</optgroup>

					<optgroup label="Rotating Exits">
						<option value="rotateOut">rotateOut</option>
						<option value="rotateOutDownLeft">rotateOutDownLeft</option>
						<option value="rotateOutDownRight">rotateOutDownRight</option>
						<option value="rotateOutUpLeft">rotateOutUpLeft</option>
						<option value="rotateOutUpRight">rotateOutUpRight</option>
					</optgroup>

					<optgroup label="Sliding Entrances">
						<option value="slideInUp">slideInUp</option>
						<option value="slideInDown">slideInDown</option>
						<option value="slideInLeft">slideInLeft</option>
						<option value="slideInRight">slideInRight</option>

					</optgroup>
					<optgroup label="Sliding Exits">
						<option value="slideOutUp">slideOutUp</option>
						<option value="slideOutDown">slideOutDown</option>
						<option value="slideOutLeft">slideOutLeft</option>
						<option value="slideOutRight">slideOutRight</option>

					</optgroup>

					<optgroup label="Zoom Entrances">
						<option value="zoomIn">zoomIn</option>
						<option value="zoomInDown">zoomInDown</option>
						<option value="zoomInLeft">zoomInLeft</option>
						<option value="zoomInRight">zoomInRight</option>
						<option value="zoomInUp">zoomInUp</option>
					</optgroup>

					<optgroup label="Zoom Exits">
						<option value="zoomOut">zoomOut</option>
						<option value="zoomOutDown">zoomOutDown</option>
						<option value="zoomOutLeft">zoomOutLeft</option>
						<option value="zoomOutRight">zoomOutRight</option>
						<option value="zoomOutUp">zoomOutUp</option>
					</optgroup>

					<optgroup label="Specials">
						<option value="hinge">hinge</option>
						<option value="rollIn">rollIn</option>
						<option value="rollOut">rollOut</option>
					</optgroup>
				</select>

				<button class="butt js--triggerAnimation btn btn-primary">Animate it</button>

				<button
					class="butt js--triggerAnimation js--animations btn btn-primary "
					onclick="testAnim('hinge')" value="hinge">Hinge</button>


			</form>
			<script>
            function testAnim(x) {
                $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                });
            }
            ;

            $(document).ready(function () {
                $('.js--triggerAnimation').click(function (e) {
                    e.preventDefault();
                    var anim = $('.js--animations').val();
                    testAnim(anim);
                });

                $('.js--animations').change(function () {
                    var anim = $(this).val();
                    testAnim(anim);
                });
            });


        </script>
		</div>

	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<a href="http://eonasdan.github.io/bootstrap-datetimepicker/"><h1>Bootstrap-datetimepicker</h1></a>
			<div class="container">
				<div class="row">
					<div class='col-sm-6'>
						<div class="form-group">
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' class="form-control" /> <span
									class="input-group-addon"> <span
									class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
				</div>
			</div>
		</div>
    
    
    
<?php
echo rand () . "\n";
echo rand () . "\n";

echo rand ( 6, 100 );
?>

    


    
    

</body>
</html>