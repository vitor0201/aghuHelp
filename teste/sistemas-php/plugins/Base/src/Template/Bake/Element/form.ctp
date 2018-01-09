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
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<div class="panel panel-default <%= $pluralVar %>">
	<div class="panel-heading">
			<div class="dropdown pull-right">
				<button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
				</button>
					
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
					
					<% if (strpos($action, 'add') === false): %>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign pull-right" aria-hidden="true"></span>&nbsp; '.__('Detalhes'), ['action' => 'view', $<%= $singularVar %>-><%= $primaryKey[0] %>], ['escape' => false]) ?></li>
					<li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>], ['class'=>'delete-confirm','escape' => false]) ?></li>
					<% endif; %>
				</ul>
			</div>
	
	
            <h3>
            <%= $pluralHumanName %>
            <small>
            <span class="glyphicon glyphicon-pencil"></span> 
            <% if (strpos($action, 'add') === false): %>
            Alterar
            <% else: %>
            Cadastrar
            <% endif; %>
            </small>
            </h3>
    </div>
    
   <?php echo $this->Form->create($<%= $singularVar %>, ['horizontal' => true, 'id' => 'Form<%= $pluralHumanName %>',
	    		'cols' => [
		    		'label' => 2,
		    		'input' => 4,
		    		'error' => 6
		    	]
			] );
     ?>
    
   
   <div class="panel-body" style="position:relative;">  
        
        <?php
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
<%
                } else {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
					$this->Form->setHorizontal(true);
					echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
<%
                } else {

				if($fieldData['type'] === 'date') {
%>
					$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
					$this->Form->setHorizontal(true);
					echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'date', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
<% 				 } %>

<%
				if(in_array($fieldData['type'],['datetime', 'timestamp'])) {
				%>
				$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
				$this->Form->setHorizontal(true);
				echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'datetime', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
<% 				 } %>

<%
				if(in_array($fieldData['type'],['time'])) {
					%>
						$this->Form->colSize = ['label' => 2, 'input' => 2, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'time', 'type' => 'text', 'append'=>$this->Html->icon('time')]);
				<% 				 } %>

<%
				if(in_array($fieldData['type'], ['integer','biginteger']) ) {
%>
						$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
						$this->Form->setHorizontal(true);
						echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'integer', 'type' => 'text', 'append'=>$this->Html->icon('calendar')]);
				<% 				 } %>

<%
				if($fieldData['type'] === 'float') {
%>
				$this->Form->colSize = ['label' => 2, 'input' => 3, 'error' => 4];
				$this->Form->setHorizontal(true);
				echo $this->Form->input('<%= $field %>', ['label' => '<%= $field %>', 'class'=>'money', 'type' => 'text', 'append'=>$this->Html->icon('usd')]);
<% 				}  
				if(!in_array($fieldData['type'], ['datetime','date','float'])) {%>

             
					echo $this->Form->input('<%= $field %>', ['label'=> ' <%= $field %>']);
				
<% 					}
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
            }
        }
%>
        ?>
  </div>
   <div class="panel-footer"> 
   <% if (strpos($action, 'add') === false): %>
           <?= $this->Form->button(__('Salvar alterações'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
            <% else: %>
            <?= $this->Form->button(__('Salvar'), ['id'=>'FormSaveSubmit','class' => 'btn btn-primary']) ?>
            <% endif; %>
    
   </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function(){
	$('#Form<%= $pluralHumanName %>').validate({   });
});
</script>
