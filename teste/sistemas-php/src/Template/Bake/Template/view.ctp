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

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
    ->map(function($field) use ($immediateAssociations) {
        foreach ($immediateAssociations as $alias => $details) {
            if ($field === $details['foreignKey']) {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function($fields, $value) {
        return $fields + $value;
    }, []);

$groupedFields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->groupBy(function($field) use ($schema, $associationFields) {
        $type = $schema->columnType($field);
        if (isset($associationFields[$field])) {
            return 'string';
        }
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>

<div class="<%= $pluralVar %> view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', <%= $pk %>], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', <%= $pk %>], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3><%= $singularHumanName %> <small><?= h($<%= $singularVar %>-><%= $displayField %>) ?></small></h3>
	</div>
    <div class="panel-body">  
    <table class="table">
<% if ($groupedFields['string']) : %>
<% foreach ($groupedFields['string'] as $field) : %>
<% if (isset($associationFields[$field])) :
            $details = $associationFields[$field];
%>
        <tr>
            <th><?= __('<%= Inflector::humanize($details['property']) %>') ?></th>
            <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
        </tr>
<% else : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endif; %>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['number']) : %>
<% foreach ($groupedFields['number'] as $field) : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['date']) : %>
<% foreach ($groupedFields['date'] as $field) : %>
        <tr>
            <th><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></th>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['boolean']) : %>
<% foreach ($groupedFields['boolean'] as $field) : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= $<%= $singularVar %>-><%= $field %> ? __('SIM') : __('NÃO'); ?></td>
         </tr>
<% endforeach; %>
<% endif; %>
    </table>
   
  
    
<ul class="nav nav-tabs">

<%
$relations = $associations['HasMany'] + $associations['BelongsToMany'];
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    %>
  <li role="presentation" class="active"><a href="#<%= $otherPluralHumanName %>" aria-controls="<%= $otherPluralHumanName %>" role="tab" data-toggle="tab"><?= __('Related <%= $otherPluralHumanName %>') ?></a></li>
 <% endforeach; %> 
  
</ul>
    
    

<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>
    <div class="row">
        <h4><?= __('<%= Inflector::humanize($field) %>') ?></h4>
        <?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?>
    </div>
<% endforeach; %>
<% endif; %>

	<div class="tab-content">
	<%
	$relations = $associations['HasMany'] + $associations['BelongsToMany'];
	foreach ($relations as $alias => $details):
	    $otherSingularVar = Inflector::variable($alias);
	    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
	    %>
	    
	    <div role="tabpanel" class="tab-pane " id="<%= $otherPluralHumanName %>">

	    	<?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
	        <table class="table " cellpadding="0" cellspacing="0">
	         <thead>
	            <tr>
	<% foreach ($details['fields'] as $field): %>
	                <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
	<% endforeach; %>
	               <!--  <th class="actions"><?= __('Actions') ?></th> -->
	            </tr>
	         </thead>
	            <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
	            <?php 
	            	$class="";
	            	//if(!$<%= $otherSingularVar %>->ativo)
	            	//	$class="text-danger";
	            
	            ?>
	            <tr <?php echo $class;?>>
	            <%- foreach ($details['fields'] as $field): %>
	                <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
	            <%- endforeach; %>
	            <%- $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
	                <!-- 
	                <td class="actions">
	                    <?= $this->Html->link(__('Detalhes'), ['controller' => '<%= $details['controller'] %>', 'action' => 'view', <%= $otherPk %>]) %>
	                    <?= $this->Html->link(__('Alterar'), ['controller' => '<%= $details['controller'] %>', 'action' => 'edit', <%= $otherPk %>]) %>
	                    <?= $this->Form->postLink(__('Remover'), ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $otherPk %>)]) %>
	                </td>
	                -->
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum registro encontrado.</div>
	    <?php endif; ?>
	    </div>
	<% endforeach; %>
	</div>

</div>
</div>
</div>
