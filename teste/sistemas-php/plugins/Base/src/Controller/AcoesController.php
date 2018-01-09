<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Acoes Controller
 *
 * @property \App\Model\Table\AcoesTable $Acoes
 */
class AcoesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
	PUBLIC $tipo = [
		'private'=>'private',
		'protected'=>'protected',
		'public' =>'public',
	];
	
    public function index()
    {
    	
    	$sistemas = $this->Acoes->Sistemas->find('list',['conditions'=>[]]);
    	$this->set('sistemas', $sistemas);
    	$this->set('tipos', $this->tipo);
    	
        $this->paginate = [
            'contain' => ['Sistemas', 'Grupos']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorAcoes']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'filtro_sistema'=> ['field'=> 'Acoes.sistema_id', 'operator'=>'='],
				'filtro_prefix'=> ['field'=> 'Acoes.prefix', 'operator'=>'ILIKE'],
				'filtro_controller'=> ['field'=> 'Acoes.controller', 'operator'=>'ILIKE'],
				'filtro_action'=> ['field'=> 'Acoes.action', 'operator'=>'ILIKE'],
				'filtro_tipo'=> ['field'=> 'Acoes.tipo', 'operator'=>'ILIKE'],
				'filtro_ativo'=> ['field'=> 'Acoes.ativo', 'operator'=>'='],
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterAcoes']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Acoes->find('all', ['conditions'=> $conditions  ,'contain' => ['Sistemas']   ]);
    		$callback = function ($object){
    			return [$object->id,$object->prefix,$object->controller,$object->action,($object->ativo?'SIM':'NÃO')];
    		};
    		$this->Export->CSV('Acoes_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['ID','PROJETO','CONTROLADOR','ACAO','ATIVO'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 100;
    		
    	//if(!isset($this->request->query['order']))
    	$this->paginate['order'] = ['Acoes.sistema_id ASC, Acoes.prefix ASC, Acoes.controller ASC, Acoes.action ASC']; 
    		
    		
    	//$conditions['Acoes.sistema_id'] = $this->sistema['id'];
    	
    	$this->paginate['conditions']	= $conditions;
    	
    	
    	
        $this->set('acoes', $this->paginate($this->Acoes));
        $this->set('_serialize', ['acoes']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Acao id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $acao = $this->Acoes->get($id, [
            'contain' => ['Sistemas', 'Grupos']
        ]);
        
        // controle de escopo do sistema
        /*
        if($acao->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível exibir a ação [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        $this->set('acao', $acao);
        $this->set('_serialize', ['acao']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	$this->set('tipos', $this->tipo);
    	
    	$sistemas = $this->Acoes->Sistemas->find('list',['conditions'=>[]]);
        $acao = $this->Acoes->newEntity();
        
        $this->set(compact('acao', 'grupos', 'sistemas'));
        if ($this->request->is('post')) {
        	
        	//$this->request->data['sistema_id'] = $this->sistema['id'];
        	//debug($this->request->data); exit;
        	
            $acao = $this->Acoes->patchEntity($acao, $this->request->data);
            if ($this->Acoes->save($acao)) {
                $this->Flash->success(__('Ação foi salva com sucesso.'));
                if(isset($this->request->data['continuar'])){
                	
                	$acao = $this->Acoes->newEntity();
                	$this->set(compact('acao', 'grupos', 'sistemas'));
                	$this->set('_serialize', ['acao']);
                	unset($this->request->data['action']);
                	return ; //$this->redirect(['action' => 'add']);
                }
                
                return $this->redirect(['action' => 'view', $acao->id]);
            } else {
                $this->Flash->error(__('Ação não foi salva. Por favor, tente novamente.'));
            }
        }
       
        /*
        $grupos = $this->Acoes->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$this->sistema['id'],'Grupos.ativo'=>true]]);
       
        $grupos =  $grupos->toArray();
        
        if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
        if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
         
        
        unset($grupos[1]);
        unset($grupos[0]);
        */
        
       
        $this->set('_serialize', ['acao']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Acao id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	$this->set('tipos', $this->tipo);
        $acao = $this->Acoes->get($id, [
            'contain' => ['Grupos']
        ]);
        

        // controle de escopo do sistema
        /*
        if($acao->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar a ação [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	unset($this->request->data['sistema_id']);
        	
            $acao = $this->Acoes->patchEntity($acao, $this->request->data);
            if ($this->Acoes->save($acao)) {
                $this->Flash->success(__('A Ação foi alterada com sucesso.'));
                return $this->redirect(['action' => 'view', $acao->id]);
            } else {
                $this->Flash->error(__('A Ação não foi alterada. Por favor, tente novamente.'));
            }
        }
        $sistemas = $this->Acoes->Sistemas->find('list', []);

        $grupos = $this->Acoes->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$acao->sistema_id]]);
         
        $grupos =  $grupos->toArray();
        
        if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
        if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
         
        unset($grupos[1]);
        unset($grupos[0]);
        $this->set(compact('acao', 'grupos','sistemas'));
        $this->set('_serialize', ['acao']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Acao id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $acao = $this->Acoes->get($id);
        
        // controle de escopo do sistema
        /*
        if($acao->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível remover a ação [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->Acoes->delete($acao)) {
            $this->Flash->success(__('A Ação foi removida com sucesso.'));
        } else {
            $this->Flash->error(__('A Ação não foi removida. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
