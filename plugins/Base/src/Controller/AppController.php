<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Base\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

use Cake\I18n\Time;
use Cake\Database\Type;


Time::$defaultLocale = 'pt-BR';
Time::setToStringFormat('dd/MM/YYYY HH:mm:ss');
Type::build('datetime')->useLocaleParser();

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller
{
	
	public $login	= NULL;
	public $user 	= NULL;
	public $sistema = NULL;
	public $permissao = NULL;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Base.Permissao');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        
        $this->viewBuilder()->layout('Base.default');
        
        if($this->request->isAjax())
        	$this->viewBuilder()->layout('Base.ajax');
         
       
    }

    public function beforeFilter(Event $event) {
    	
    	
    	$this->viewBuilder()->helpers(['Form' => ['className' => 'Bootstrap.BootstrapForm']]);
    	$this->viewBuilder()->helpers(['Html' => ['className' => 'Base.BaseHtml', 'PermissaoComponent'=> $this->Permissao ]]);
    	$this->viewBuilder()->helpers(['Modal' => ['className' => 'Bootstrap.BootstrapModal']]);
    	
    	
    	/*
    	if(!$this->Permissao->estaLogado()){
    		$this->Flash->error(__("Sessão expirou."));
    		return $this->redirect(['plugin'=>'base','controller'=>'usuarios','action' => 'acessoNegado']);
    	}
    	*/
    	
    	 
    	if(!$this->Permissao->temPermissao()){
    		$this->Flash->error(__("Acesso negado."));
    		//debug($this->request->params); exit;
    		return $this->redirect(['plugin'=>'base','controller'=>'usuarios','action' => 'acessoNegado']);
    	
    	} 
    	
    	
    	
    	
    	//
        parent::beforeFilter($event);
        Configure::load('custom');
        $this->set('CustomConfig', Configure::read('CustomConfig'));
        
        $this->login 		= $this->request->session()->read('login');
        $this->user 		= $this->request->session()->read('usuario');
        $this->sistema 		= $this->request->session()->read('sistema');
        $this->permissao 	= $this->request->session()->read('permissao');
        
    }

    public function hasGroup($group_id){
    	foreach($this->user->grupos as $grupo){
    		if($grupo->id == $group_id)
    			return true;
    	}
    	return false;
    }
    
    public function getGroups(){
    	$gr = [];
    	foreach($this->user->grupos as $grupo){
    		$gr[] = $grupo->id;
    	}
    	return $gr;
    }
    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}













