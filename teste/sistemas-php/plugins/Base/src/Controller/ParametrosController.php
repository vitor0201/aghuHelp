<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Parametros Controller
 *
 * @property \App\Model\Table\ParametrosTable $Parametros
 */
class ParametrosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	
        $this->paginate = [
            'contain' => ['Sistemas']
        ];
        
        $sistemas = $this->Parametros->Sistemas->find('list', ['conditions'=>['Sistemas.ativo'=>true]]);
        $this->set('sistemas',$sistemas);
        
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorParametros']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'sistema'=> ['field'=> 'Parametros.sistema_id', 'operator'=>'='],
					'descricao'=> ['field'=> 'Parametros.descricao', 'operator'=>'ILIKE'],
					'chave'=> ['field'=> 'Parametros.chave', 'operator'=>'ILIKE']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterParametros']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Parametros->find('all', ['conditions'=> $conditions  ,'contain' => ['Sistemas']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Parametros_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Parametros.id ASC'];
    		
    		
    	//$conditions['Parametros.sistema_id'] = $this->sistema['id'];
    	
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('parametros', $this->paginate($this->Parametros));
        $this->set('_serialize', ['parametros']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Parametro id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $parametro = $this->Parametros->get($id, [
            'contain' => ['Sistemas', 'Grupos']
        ]);
        
        // controle de escopo
        /*
        if($parametro->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível exibir o parâmetro [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        $this->set('parametro', $parametro);
        $this->set('_serialize', ['parametro']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parametro = $this->Parametros->newEntity();
        if ($this->request->is('post')) {

        	// mantem o escopo do sistema atual
        	$this->request->data['sistema_id'] = $this->sistema['id'];
        	
            $parametro = $this->Parametros->patchEntity($parametro, $this->request->data);
            if ($this->Parametros->save($parametro)) {
                $this->Flash->success(__('O registro de parametro foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $parametro->id]);
            } else {
                $this->Flash->error(__('O registro de parametro não foi salvo. Por favor, tente novamente.'));
            }
        }
        $sistemas = $this->Parametros->Sistemas->find('list', ['conditions'=>['Sistemas.ativo'=>true]]);
        $grupos = $this->Parametros->Grupos->find('list', ['conditions' => ['Grupos.sistema_id'=>$this->sistema['id'],'Grupos.ativo'=>true]]);
        $this->set(compact('parametro', 'grupos','sistemas'));
        $this->set('_serialize', ['parametro']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Parametro id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $parametro = $this->Parametros->get($id, [
            'contain' => ['Grupos']
        ]);
        
        // controle de escopo
        /*
        if($parametro->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o parâmetro [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	unset($this->request->data['sistema_id']);
        	
            $parametro = $this->Parametros->patchEntity($parametro, $this->request->data);
            if ($this->Parametros->save($parametro)) {
                $this->Flash->success(__('O registro de parametro foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $parametro->id]);
            } else {
                $this->Flash->error(__('O registro de parametro não foi salvo. Por favor, tente novamente.'));
            }
        }
        $sistemas = $this->Parametros->Sistemas->find('list', ['conditions'=>['Sistemas.ativo'=>true]]);
        $grupos = $this->Parametros->Grupos->find('list', ['conditions' => ['Grupos.sistema_id'=>$this->sistema['id']]]);
        $this->set(compact('parametro', 'grupos','sistemas'));
        $this->set('_serialize', ['parametro']);
    }

    

    /**
     * Edit method
     *
     * @param string|null $id Parametro id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function configurar($id = null)
    {
    	$parametro = $this->Parametros->get($id, [
    			'contain' => ['Grupos']
    			]);
    
    	// controle de escopo
    	/*
    	if($parametro->sistema_id != $this->sistema['id']){
    		$this->Flash->error(__("Não é possível alterar o parâmetro [$id]."));
    		return $this->redirect(['action' => 'index']);
    	}
    	*/
    
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		 
    		unset($this->request->data['sistema_id']);
    		 
    		$parametro = $this->Parametros->patchEntity($parametro, $this->request->data);
    		if ($this->Parametros->save($parametro)) {
    			$this->Flash->success(__('O registro de parametro foi salvo com sucesso.'));
    			return $this->redirect(['action' => 'view', $parametro->id]);
    		} else {
    			$this->Flash->error(__('O registro de parametro não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    	$grupos_id = [];
    	foreach($this->user->grupos as $gr)
    		$grupos_id[] = $gr->id;
    	
    	debug($grupos_id);
    	$sistemas = $this->Parametros->Sistemas->find('list', ['conditions'=>['Sistemas.ativo'=>true]]);
    	$grupos = $this->Parametros->Grupos->find()->contain(['Parametros'])
    			->where(['Grupos.id IN '=>$grupos_id,'Grupos.ativo'=>true]);
    	
    	foreach($grupos as $gr){
    		debug($gr->parametros);
    	}
    	
    	$this->set(compact('parametro', 'grupos','sistemas'));
    	$this->set('_serialize', ['parametro']);
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Parametro id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parametro = $this->Parametros->get($id);
        // controle de escopo
        /*
        if($parametro->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível remover o parâmetro [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        if ($this->Parametros->delete($parametro)) {
            $this->Flash->success(__('O registro de parametro foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de parametro não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
