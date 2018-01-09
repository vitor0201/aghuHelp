<?php
namespace Base\Controller\Component;

use Cake\Controller\Component;

class PaginationSessionComponent extends Component
{
	
	public $config =['session'=>'filter_query'];
	
	public $the_controller = null;
	
	// elemnts keys from pagination to save 
	public $pagination_key = ['sort','direction', 'limit'];
	
	public function initialize(array $config=[]) {
		parent::initialize($config);
		$this->config = array_merge($this->config, $config);
		$this->the_controller = $this->_registry->getController();
	
	}
	
	public function restore(){
		
		$session = $this->the_controller->request->session();
		//$session->delete($this->config['session']);
		//return;
		
		$session_id 	= $this->config['session'];
		
		$saved_query	= $session->read($session_id);
		
		if($saved_query){
			// restore
			$this->the_controller->request->query = array_merge($saved_query, $this->the_controller->request->query);
		}
	}
	
	public function save(){
		//return;
		$session = $this->the_controller->request->session();
		$session_id 	= $this->config['session'];
		$save = [];
		foreach($this->pagination_key as $ks ){
			if(isset($this->the_controller->request->query[$ks]))
				$save[$ks] = $this->the_controller->request->query[$ks];
		}
		$session->write($session_id, $save);
	}
	
}