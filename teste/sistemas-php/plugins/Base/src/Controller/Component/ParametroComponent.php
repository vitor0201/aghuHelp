<?php
namespace Base\Controller\Component;

use Cake\Controller\Component;
use Base\Model\Entity;
use Base\Model\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

class ParametroComponent extends Component
{
	
	public $the_controller = null;
	
	public $config = [
	];
	
	public function initialize(array $config=[]) {
		
		parent::initialize($config);
		
		$this->config = $config + $this->config; 
		$this->the_controller = $this->_registry->getController();
	}
	
	public function get($key, $use_cache = true){
		
		$value = false;
		
		if($use_cache) {
			$value = Cache::read($key);
			if ($value !== false) {
				//debug("cached");
			    return $value;
			}
		}
		
		$conf_tb = TableRegistry::get('Base.Parametros');
		
		$config =  $conf_tb->find('all')
            ->where(['chave' => $key])
            ->first();
		
		$value = $config ? $config->valor : null;
		
		if($config && $config->use_cache) {
			Cache::write($key, $value);
		}
		
		return $value;
		
	}
	
		
}