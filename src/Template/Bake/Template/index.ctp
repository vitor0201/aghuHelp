<%
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
* @since         0.1.0
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/
use Cake\Utility\Inflector;

$fields = collection($fields)
->filter(function($field) use ($schema) {
return !in_array($schema->columnType($field), ['binary', 'text']);
})
->take(7);

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
$fields = $fields->reject(function ($field) {
return $field === 'lft' || $field === 'rght';
});
}

%>

<%
//$done = [];
//foreach ($associations as $type => $data):
//foreach ($data as $alias => $details):
//if (!empty($details['navLink']) && $details['controller'] !== $this->name && !in_array($details['controller'], $done)):

%>
<%
//$done[] = $details['controller'];
//endif;
//endforeach;
//endforeach;
%>

<?php $this->Paginator->options(['url' => $url]); ?>

<div id="AjaxContent" class="<%= $pluralVar %> index large-9 medium-8 columns content"> 
<?php //echo date('d/m/Y H:i:s') ; ?>
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="FilterCollapse" class="collapsed" data-target="#collapseOne">
                  <span class="glyphicon glyphicon-search" ></span> Filtro <?php if(!empty($url)):?><span class="badge">aplicado</span> <?php endif;?>
                </a>
            </h4>
        </div>
        
        <div id="collapseOne" class="panel-collapse collapse ">
            <?php
           // $this->Form->templates($CustomConfig['FormFilter.Template']);            
            ?>
                       
            <?php echo $this->Form->create('', ['id'=>'FormFilter', 'horizontal' => true, 'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]]); ?>

            <div class="panel-body">                
            	<?php echo $this->Form->input('filtro1') ?>
                <% foreach ($fields as $field): %>
                <?php echo $this->Form->input('<%= $field %>') ?>
                <% endforeach; %>
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
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenuTop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuTop">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>&nbsp; '.__('Novo <%= $singularHumanName %>'), ['action' => 'add'], ['escape' => false]) ?></li>
                                </ul>
                </div>
            <h3><?php echo __('<%= $pluralHumanName %>') ?> <small>Listagem</small></h3>
        </div>
		<div id="no-more-tables" >
        <div id="PanelBody" >  
        
            <table class="table table-striped" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0">
                <thead>
                    <tr>
                    	<th class="actions">&nbsp;</th>
                        <% foreach ($fields as $field): %>
                        <th class="ajax-pagination"><?php echo $this->Paginator->sort('<%= $field %>') ?></th>
                        <% endforeach; %>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($<%= $pluralVar %> as $<%= $singularVar %>):
                    $class="";
                    //if(!$<%= $singularVar %>->ativo)
                    //	$class="class='text-danger'";
                    
                    ?>
                    <tr <?php echo $class;?>>
                   		<% $pk = '$' . $singularVar . '->' . $primaryKey[0]; %>
                    	<td class="action">
                    	
                    		<div class="btn-group ">
									  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
									  </button>
									 <ul class="dropdown-menu ">
									    <li><?php echo $this->Html->link(__('Detalhes'), ['action' => 'view', <%= $pk %>], ['escape' => false]); ?></li>
									    <li><?php echo $this->Html->link(__('Alterar'), ['action' => 'edit', <%= $pk %>], ['escape' => false]); ?></li>
									   
									    <li role="separator" class="divider"></li>
									    <li><?php echo $this->Html->link(__('Remover'), ['action' => 'delete', <%= $pk %>], ['class'=>'delete-confirm','escape' => false]) ?></li>
									  </ul>
							</div>
						</td>
                        <%      
                        
                          foreach ($fields as $field) {
                        $isKey = false;
                        if (!empty($associations['BelongsTo'])) {
                        foreach ($associations['BelongsTo'] as $alias => $details) {
                        if ($field === $details['foreignKey']) {
                        $isKey = true;
                        %>
                         
                   		
                        
                        <td data-title="<%= $field %>"><?php echo $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>&nbsp;</td>
                        <%
                        break;
                        }
                        }
                        }
                        if ($isKey !== true) {
                        if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
                        %>
                        <td data-title="<%= $field %>"><?php echo h($<%= $singularVar %>-><%= $field %>) ?>&nbsp;</td>
                        <%
                        } else {
                        %>
                        <td data-title="<%= $field %>"><?php echo $this->Number->format($<%= $singularVar %>-><%= $field %>) ?>&nbsp;</td>
                        <%
                        }
                        }
                        }
                        $pk = '$' . $singularVar . '->' . $primaryKey[0];
                        %>
                         
                        <!-- 
                        <td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo <%= $pk %> ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo <%= $pk %> ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', <%= $pk %>], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', <%= $pk %>], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', <%= $pk %>], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
                        </td>
                         -->
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <?php if($<%= $pluralVar %>->isEmpty()  && !empty($url) ):?>
              <div class="panel-body">
            	<div class="alert alert-warning">Nenhum registro encontrado.</div>
            	</div>
            <?php endif;?>
 </div>
 </div>
            
            <div class="panel-footer"> 
            	<div class="row ">
                  
                   <div class="col col-xs-8 ajax-pagination" style=" line-height: 40px;height: 40px;" >
                   <div class="btn-toolbar" role="toolbar" aria-label="...">
                   <div class="btn-group">
	                  <ul class="pagination pagination-sm hidden-xs ">
	                  	<?php echo $this->Paginator->numbers() ?>
	                    </ul>
                    </div>
                    <div class="btn-group">
                    <ul class="pagination  pagination-sm">
                        <?php echo $this->Paginator->prev('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['escape' => false]) ?>
                    	<?php echo $this->Paginator->next('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['escape' => false]) ?>
                    </ul>
                    </div>
	                   <?php 
							$paginas = [15,25,50,75,100];
							$active = $this->Paginator->param('limit');
						?>
                     <div class="btn-group pagination hidden-xs hidden-sm dropup">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <?php echo $active? $active : 15;?> / pág. <span class="caret"></span>
									  </button>
									 <ul class="dropdown-menu " style="min-width: 0px">
									 	<?php 
											foreach($paginas as $pag ){
												if($pag==$active){
													$class= 'active disabled';
												}
												echo "<li >" . $this->Html->link($pag, ['action'=>'index', '?' => ['limit' => $pag]],['class'=>' ']) . "</li>";
											}  
										?>
									  </ul>
									  
						</div> &nbsp;
						<small class="hidden-xs hidden-sm" >
	                 <?php echo $this->Paginator->counter(
								    'Página {{page}} de {{pages}} - Total: {{pages}} registro(s)'
								);
		             ?>
		                </small>
				
                    </div>
                  </div>
                   <div class="col col-xs-4" style=" line-height: 40px;height: 40px;" >
                   	 <div class="btn-group pagination dropup pull-right">
                     
									  <button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

