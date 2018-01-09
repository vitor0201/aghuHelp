

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent"
	class="pendencias index large-9 medium-8 columns content"> 
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
                                <?php echo $this->Form->input('id',['label' => 'Id'])?>
                                <?php echo $this->Form->input('tipo_pendencia_id',['label' => 'Tipo de Pendência'])?>
                                <?php echo $this->Form->input('observacao', ['label' => 'Observação'])?>
                                <?php echo $this->Form->input('usuario_id', [
                                    'label' => 'Usuário'
                                ]);
                                ?>
                                <?php echo $this->Form->input('data_cadastro', ['label' => 'Data de Cadastro', 'class' => 'date', 'append' => $this->Html->icon('calendar')])?>
                                <?php echo $this->Form->input('data_remocao',['label' => 'Data de Remoção','append' => $this->Html->icon('calendar'), 'class' => 'date'])?>
                                <?php echo $this->Form->input('observacao_remocao', ['label' => 'Observação de Remoção'])?>
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
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Adicionar'), ['action' => 'add'], ['escape' => false]) ?></li>
				</ul>
			</div>
			<h3><?php echo __('Pendências') ?> <small>Listagem</small>
			</h3>
		</div>
		<div id="no-more-tables">
			<div id="PanelBody">

				<table class="table table-striped" cellpadding="0" cellspacing="0"
					style="margin: 0; padding: 0">
					<thead>
						<tr>
							<th class="actions">&nbsp;</th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('id',['label'=> 'Id']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('tipo_pendencia_id',['label' => 'Tipo de Pendência']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('observacao',['label' => 'Observação']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('usuario_id', ['label' => 'Usuário']) ?></th>
							<th class="ajax-pagination"><?php echo $this->Paginator->sort('data_cadastro', ['label' => 'Data de Cadastro']) ?></th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    $i = 0;
                    foreach ($pendencias as $pendencia) :
                        $class = "";
                        // if(!$pendencia->ativo)
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
										<li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', $pendencia->id], ['escape' => false]); ?></li>
										<li><?php echo $this->Html->link(__('Remover'), ['action' => 'edit', $pendencia->id], ['escape' => false]); ?></li>
									</ul>
								</div>
							</td>
							<td data-title="id"><?php echo $this->Number->format($pendencia->id) ?>&nbsp;</td>



							<td data-title="tipo_pendencia_id"><?php echo $pendencia->has('tipo_pendencia') ? $this->Html->link($pendencia->tipo_pendencia->descricao, ['controller' => 'TipoPendencias', 'action' => 'view', $pendencia->tipo_pendencia->id]) : '' ?>&nbsp;</td>
							<td data-title="observacao"><?php echo h($pendencia->observacao) ?>&nbsp;</td>
							<td data-title="usuario_id"><?php echo $this->Html->link($pendencia->usuario->nome, ['plugin' => 'Base','controller' => 'Usuarios', 'action' => 'view', $pendencia->usuario->id]) ?>&nbsp;</td>
							<td data-title="data_cadastro"><?php echo h($pendencia->data_cadastro) ?>&nbsp;</td>

							<!-- 
                        <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $pendencia->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $pendencia->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $pendencia->id], ['class'=>'btn btn-default', 'escape' => false])?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $pendencia->id], ['class'=>'btn btn-default','escape' => false])?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $pendencia->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false])?>
							</div>
                        </td>
                         -->
						</tr>
                    <?php endforeach; ?>
                </tbody>
				</table>
              <?php if($pendencias->isEmpty()  && !empty($url) ):?>
            	<div class="alert alert-warning">Nenhum registro
					encontrado.</div>
            <?php endif;?>
 </div>
		</div>

		<div class="panel-footer">
			<div class="row ajax-pagination">

				<div class="col col-xs-8" style="line-height: 40px; height: 40px;">
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

