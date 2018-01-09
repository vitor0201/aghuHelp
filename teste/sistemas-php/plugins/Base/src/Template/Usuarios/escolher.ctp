<?php if(!$usuarios->isEmpty() || !$grupos_publicos->isEmpty()) : ?>

<div class="col-md-6 col-md-offset-3">
<div class="panel panel-default ">
<div class="panel-heading">

<form class="" role="search">
        <div class="input-group">

                      
                <input type="text" class="form-control" placeholder="Buscar" id="filter"/>
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
            </div>

      </form>
</div>
</div>
</div>
<div class="clearfix"></div>
<!--
 <ul class="list-group" id="SistemasListId"> -->
<div class="container">
<div class="row row-centered">

<?php 
	$selected = $this->request->session()->read('sistema');
	$selected_id = ( $selected ? $selected['id'] : null);
?>

<?php 
$sistemas_publicos_id = [];
foreach($grupos_publicos as $gr) 
	$sistemas_publicos_id[$gr->sistema->id] = $gr->sigla;
?>

<?php foreach($usuarios as $sistema): ?>
		
		

 		<div class="col-xs-12 col-sm-6 col-lg-4  animated zoomIn searchable col-centered" >
            <div class="box" location="<?php echo $this->Url->build(['controller'=>'usuarios','action'=>'escolher', $sistema->sistema_id]); ?>">
                <div class="icon">
                    <div class="image"><span class="<?php echo $sistema->sistema->icon ? $sistema->sistema->icon : ''; ?> btn-lg white"></span></div>
                    <div class="info">
                   
                        <h4 class="title"><?php echo $sistema->sistema->nome; ?></h4>
                        <p>
                             <?php 
								foreach($sistema->grupos as $grupo){
									echo $this->Html->label($grupo->sigla, $selected_id==$sistema->sistema_id ?'success': 'default' )." ";	
								}

								if(array_key_exists($sistema->sistema->id, $sistemas_publicos_id)){
									echo $this->Html->label($sistemas_publicos_id[$sistema->sistema->id], 'info' )." ";
									unset($sistemas_publicos_id[$sistema->sistema->id]);
								}
							?>
                        </p>
                        <!-- 
                        <div class="more">
                            <a href="<?php echo $this->Url->build(['controller'=>'usuarios','action'=>'escolher', $sistema->sistema_id]); ?>" title="Title Link"><i class="fa fa-plus"></i> Acessar
                            </a>
                        </div>
                         -->
                       
                    </div>
                </div>
                <div class="space"></div>
            </div>
      </div>
      
      

<?php endforeach; ?>

<?php //debug($grupos_publicos);?>

<?php foreach($grupos_publicos as $sistema) :?>
<?php // se o sistema ja foi apresentado acima, vamos para o proximo 
	if(!isset($sistemas_publicos_id[$sistema->sistema->id])) continue; ?>
 		
 		<div class="col-xs-12 col-sm-6 col-lg-4  animated zoomIn searchable col-centered" >
            <div class="box" location="<?php echo $this->Url->build(['controller'=>'usuarios','action'=>'escolher', $sistema->sistema_id]); ?>">
                <div class="icon">
                    <div class="image"><span class="<?php echo $sistema->sistema->icon ? $sistema->sistema->icon : ''; ?> btn-lg white"></span></div>
                    <div class="info">
                   
                        <h4 class="title"><?php echo $sistema->sistema->nome; ?></h4>
                        <p>
                             <?php 
								//foreach($sistema->grupos as $grupo){
									echo $this->Html->label($sistema->sigla, 'info' )." ";	
								//}

								
							?>
                        </p>
                        <!-- 
                        <div class="more">
                            <a href="<?php echo $this->Url->build(['controller'=>'usuarios','action'=>'escolher', $sistema->sistema_id]); ?>" title="Title Link"><i class="fa fa-plus"></i> Acessar
                            </a>
                        </div>
                         -->
                       
                    </div>
                </div>
                <div class="space"></div>
            </div>
      </div>
<?php endforeach;?>
</div>

<!-- 
<div class="col-md-6 col-md-offset-3"  style="display:none" id="notfound">
<div class="alert alert-warning">Nenhum registro encontrado </div>
</div>
 -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#filter').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable').hide();
                $('.searchable').filter(function () {
                    return rex.test($(this).text());
                }).show();

                //$("#notfound").hide();

                if($(".searchable a:visible").length==0){
                	//$("#notfound").show();
                }
            })
        }(jQuery));

        $('.box').click(function(e) {
            e.preventDefault();
           //alert($(this).att("location"));
            window.location = $(this).attr("location");
   		 });
            
        
    });
</script> <!-- script de busca -->
<?php else: ?>
<div class="alert alert-danger">Nenhum sistema está disponível para seu login.</div>
<?php endif;?>
<div class="clearfix"></div>
<?php //debug($this->request->session()->read('permissao'))?>
