<?php
namespace Base\Controller;

use Base\Controller\AppController;
use Cake\Routing\Router;
/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	
    	$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorGrupos']);
    	$this->PaginationSession->restore();
    	
    	$this->loadComponent('Base.Filter');
    	$this->Filter->addFilter([
    			'filtro_sistema'=> ['field'=> 'Menus.sistema_id', 'operator'=>'=']
    			// ...
    			]);

    	$sistemas = $this->Menus->Sistemas->find('list');
    	$this->set('sistemas',$sistemas);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterGrupos']);
    	 
    	
    	$menu = $this->Menus->find('all', [
    			'contain' => ['Acoes'],
    			'order' => ['Menus.lft'],
    			'conditions' => $conditions
    			]);
    	
//     	debug($menu);
    	$this->Menus->recover();
    	
        $this->set('menus', $menu);
        $this->set('_serialize', ['menus']);
        
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['Sistemas']
        ]);
        // controle de escopo do sistema
        /*
        if($menu->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível exibir o item de menu [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        $descendants = $this->Menus->find('children', ['for' => $id, 'order'=>'Menus.lft']);
        
        $crumbs =  $this->Menus->find('path', ['for' => $id]);
        
        //debug($descendants);
        
        $this->set('descendants', $descendants);
        $this->set('crumbs', $crumbs);
        
        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($sistema_id=null)
    {
    	$this->set('sistema_id',$sistema_id);
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
        	
        	//$this->request->data['sistema_id'] = $this->sistema['id'];
        	
            $menu = $this->Menus->patchEntity($menu, $this->request->data);
            
            //debug($menu); exit; 
            
            if ($this->Menus->save($menu)) {
            	$this->Menus->recover();
                $this->Flash->success(__('O registro de menu foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $menu->id]);
            } else {
            	debug($menu);
                $this->Flash->error(__('O registro de menu não foi salvo. Por favor, tente novamente.'));
            }
        }
        $parentMenus = $this->Menus->find('treeList',[
			    'spacer' => ' &nbsp;&nbsp; ',
        		'conditions' => ['Menus.sistema_id'=>$sistema_id]
			]);
//         debug($parentMenus);

        $sistemas = $this->Menus->Sistemas->find('list');
        $this->set('sistemas',$sistemas);
        
        $acoes = $this->Menus->Acoes->find('list', ['groupField' => 'controller','conditions' => ['Acoes.sistema_id'=>$sistema_id,'Acoes.ativo'=>true]]);
        $this->set(compact('menu', 'parentMenus', 'acoes'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        
        /*
        if($menu->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o item de menu [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	unset($this->request->data['sistema_id']);
            
        	$menu = $this->Menus->patchEntity($menu, $this->request->data);
            if ($this->Menus->save($menu)) {
            	$this->Menus->recover();
                $this->Flash->success(__('O registro de menu foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $menu->id]);
            } else {
                $this->Flash->error(__('O registro de menu não foi salvo. Por favor, tente novamente.'));
            }
        }
        $parentMenus = $this->Menus->ParentMenus->find('treeList',[
			    'spacer' => ' &nbsp;&nbsp; ',
        		'conditions' => ['ParentMenus.sistema_id'=>$menu->sistema_id]
			]);

        $sistemas = $this->Menus->Sistemas->find('list');
        $this->set('sistemas',$sistemas);
        
        $acoes = $this->Menus->Acoes->find('list', ['groupField' => 'controller','conditions' => ['Acoes.sistema_id'=>$menu->sistema_id,'Acoes.ativo'=>true]]);
        $this->set(compact('menu', 'parentMenus', 'acoes'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);

        // escopo do sistema
        /*
        if($menu->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível remover o item de menu [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->Menus->delete($menu)) {
        	$this->Menus->recover();
            $this->Flash->success(__('O registro de menu foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de menu não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
    public function moveUp($id = null)
    {
    	
    	$menu = $this->Menus->get($id);
    	
    	// escopo do sistema
    	/*if($menu->sistema_id != $this->sistema['id']){
    		$this->Flash->error(__("Não é possível mover o item de menu [$id]."));
    		return $this->redirect(['action' => 'index']);
    	}*/
    	
    	if ($this->Menus->moveUp($menu)) {
    		$this->Menus->recover();
    		$this->Flash->success(__('O item de menu foi movido com sucesso.'));
    	} else {
    		$this->Flash->error(__('O item de menu não foi movido. Por favor, tente novamente.'));
    	}
    	return $this->redirect(['action' => 'index']);
    }
    
    public function moveDown($id = null, $goto_bottom = 0)
    {
    	$menu = $this->Menus->get($id);
    	
    	// escopo do sistema
    	/*if($menu->sistema_id != $this->sistema['id']){
    		$this->Flash->error(__("Não é possível mover o item de menu [$id]."));
    		return $this->redirect(['action' => 'index']);
    	}*/
    	
    	
    	if ($this->Menus->moveDown($menu)) {
    		$this->Menus->recover();
    		$this->Flash->success(__('O item de menu foi movido com sucesso.'));
    	} else {
    		$this->Flash->error(__('O item de menu não foi movido. Por favor, tente novamente.'));
    	}
    	return $this->redirect(['action' => 'index']);
    }
   
}
