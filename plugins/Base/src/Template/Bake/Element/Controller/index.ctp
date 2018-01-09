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
%>

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    
    	if($this->request->isAjax())
    		$this->viewBuilder()->layout('ajax');
    
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if ($belongsTo): %>
        $this->paginate = [
            'contain' => [<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]
        ];
<% endif; %>

		$this->loadComponent('PaginationSession', ['session'=>'paginator<%= $currentModelName %>']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> '<%= $currentModelName %>.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filter<%= $currentModelName %>']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Export');
    		$data_export = $this-><%= $currentModelName; %>->find('all', ['conditions'=> $conditions <% if ($belongsTo): %> ,'contain' => [<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>] <% endif; %>  ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('<%= $currentModelName %>_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['<%= $currentModelName %>.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('<%= $pluralName %>', $this->paginate($this-><%= $currentModelName %>));
        $this->set('_serialize', ['<%= $pluralName %>']);
        
         $this->PaginationSession->save();
    }
