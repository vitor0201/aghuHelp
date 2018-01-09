

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent"
	class="criterios index large-9 medium-8 columns content"> 
<?php //echo date('d/m/Y H:i:s') ; ?>
    <div class="panel panel-default" id="panel1">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" id="FilterCollapse" class="collapsed"
					data-target="#collapseOne"> <span
					class="glyphicon glyphicon-search"></span> Filtro <?php if(!empty($url)):?><span
					class="badge">aplicado</span> <?php endif;?>
                </a>
			</h4>
		</div>

		<div id="collapseOne" class="panel-collapse collapse ">
            <?php
            // $this->Form->templates($CustomConfig['FormFilter.Template']);
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal' => true]); ?>

            <div class="panel-body">                
            	                <?php //echo $this->Form->input('filtro1')?>
                                <?php echo $this->Form->input('inicio',['label'=>'Início'])?>
                                <?php echo $this->Form->input('fim')?>
                                <?php echo $this->Form->input('cor')?>
                                <?php echo $this->Form->input('especialidade_id',['label'=>'Especialidade'])?>
                                <?php echo $this->Form->input('unidade_id',['label'=>'Unidade'])?>
                                <?php echo $this->Form->input('movimento_id',['label'=>'Movimentação'])?>
                            </div>
			<div class="panel-footer">                
                <?php echo $this->Form->button('Buscar', ['id'=>'FormFilterSubmit','class' => 'btn btn-primary btn-sm']); ?>
                
            </div>

            <?php echo $this->Form->end(); ?>
            
             <script>
                jQuery("#FormFilterSubmit").click(
                        function()
                        {                
                            jQuery.ajax({
                                type:'POST',
                                async: true,
                                cache: false,
                                url: '<?php echo $this->Url->build([ "action" => "index"]);?>',
                                
                                beforeSend: function(response) {
                                	
                                    jQuery('#FilterCollapse').click();
                                    
                                    jQuery('#PanelBody').fadeTo(300,0, function() {  });
                                },
                        
                                success: function(response) {
                                    
                                    jQuery('#AjaxContent').html(response);
                                    
                                    jQuery('#PanelBody').fadeTo(100, 1);
                                },
                                data:jQuery('#FormFilter').serialize()
                            });
                            return false;
                        }
                );
            </script>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm" type="button"
					id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical"
						aria-hidden="true"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo'), ['action' => 'add'], ['escape' => false]) ?></li>
				</ul>
			</div>
			<h3><?php echo __('KANBAN') ?> <small>Cores</small>
			</h3>
		</div>
		<div id="no-more-tables">
			<div id="PanelBody">

				<table class="table table-striped" cellpadding="0" cellspacing="0"
					style="margin: 0; padding: 0">
					<thead>
						<tr>
							<th class="actions">&nbsp;</th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('inicio',['label'=>'Início']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('fim') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('cor',['label'=>'Cor Hexadecimal']) ?></th>
						    <th class="ajax-pagination"><?php echo $this->Paginator->sort('cor') ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('especialidade_id',['label'=>'Especialidade']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('unidade_id',['label'=>'Unidade']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('movimento_id',['label'=>'Movimentação']) ?></th>
							
						</tr>
					</thead>
					<tbody>
                    <?php
                    $i = 0;
                    foreach ($criterios as $criterio) :
                        $class = "";
                        // if(!$criterio->ativo)
                        // $class="class='text-danger'";
                        
                        ?>
                    <tr <?php echo $class;?>>
							<td class="action">

								<div class="btn-group ">
									<button type="button"
										class="btn btn-info btn-xs dropdown-toggle"
										data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="glyphicon glyphicon-menu-hamburger"
											aria-hidden="true"></span>
									</button>
									<ul class="dropdown-menu ">
										<li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $criterio->id], ['escape' => false]); ?></li>
										<li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', $criterio->id], ['escape' => false]); ?></li>

										<li role="separator" class="divider"></li>
										<li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', $criterio->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
									</ul>
								</div>
							</td>
							<td data-title="inicio"><?php echo $this->Number->format($criterio->inicio) ?>&nbsp;</td>
							<td data-title="fim"><?php echo $this->Number->format($criterio->fim) ?>&nbsp;</td>
							<td data-title="fim"><?php echo h($criterio->cor) ?>&nbsp;</td>
							<td data-title="cor"  style="background-color:<?php echo $criterio->cor; ?>">&nbsp;</td>
							<td data-title="especialidade_id"><?php echo $especialidades[$criterio->especialidade_id] ?>&nbsp;</td>
							<td data-title="unidade_id"><?php echo $unidades[$criterio->unidade_id] ?>&nbsp;</td>
							<td data-title="movimento_id"><?php echo $movimentos[$criterio->movimento_id] ?>&nbsp;</td>

							<!-- 
                        <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $criterio->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $criterio->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $criterio->id], ['class'=>'btn btn-default', 'escape' => false])?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $criterio->id], ['class'=>'btn btn-default','escape' => false])?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $criterio->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false])?>
							</div>
                        </td>
                         -->
						</tr>
                    <?php endforeach; ?>
                </tbody>
				</table>
              <?php if($criterios->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro
					encontrado.</div>
            <?php endif;?>
 </div>
		</div>

		<div class="panel-footer">
			<div class="row ">

				<div class="col col-xs-8 ajax-pagination" style="line-height: 40px; height: 40px;">
					<div class="btn-toolbar" role="toolbar" aria-label="...">
						<div class="btn-group">
							<ul class="pagination pagination-sm hidden-xs ">
	                  	<?php echo $this->Paginator->numbers()?>
	                    </ul>
						</div>
						<div class="btn-group">
							<ul class="pagination  pagination-sm">
                        <?php echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false])?>
                    	<?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false])?>
                    </ul>
						</div>
	                   <?php
                    $paginas = [
                        15,
                        25,
                        50,
                        75,
                        100
                    ];
                    $active = $this->Paginator->param('limit');
                    ?>
                     <div
							class="btn-group pagination hidden-xs hidden-sm dropup">

							<button type="button" class="btn  btn-sm dropdown-toggle"
								data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
									    <?php echo $active? $active : 15;?> / pág. <span
									class="caret"></span>
							</button>
							<ul class="dropdown-menu " style="min-width: 0px">
									 	<?php
        foreach ($paginas as $pag) {
            if ($pag == $active) {
                $class = 'active disabled';
            }
            echo "<li >" . $this->Html->link($pag, [
                'action' => 'index',
                '?' => [
                    'limit' => $pag
                ]
            ], [
                'class' => ' '
            ]) . "</li>";
        }
        ?>
									  </ul>

						</div>
						&nbsp; <small class="hidden-xs hidden-sm">
	                 <?php
                
echo $this->Paginator->counter('Página {{page}} de {{pages}} - Total: {{pages}} registro(s)');
                ?>
		                </small>

					</div>
				</div>
				<div class="col col-xs-4" style="line-height: 40px; height: 40px;">
					<div class="btn-group pagination dropup pull-right">

						<button type="button" class="btn  btn-sm dropdown-toggle"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-export"></span>
						</button>
						<ul class="dropdown-menu " style="min-width: 0px">
							<li><?php echo $this->Html->link(''.__('Exportar Excel (.csv)'), ['action'=>'index', '?' => ['export' => 'csv']], ['class'=>'','escape' => false]);	?></li>
						</ul>

					</div>
				</div>

			</div>

		</div>
	</div>
</div>

