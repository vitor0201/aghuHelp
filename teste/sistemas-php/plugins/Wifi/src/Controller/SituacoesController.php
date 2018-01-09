<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;

/**
 * Situacoes Controller
 *
 * @property \Wifi\Model\Table\SituacoesTable $Situacoes
 */
class SituacoesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorSituacoes']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Situacoes.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterSituacoes']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Situacoes->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Situacoes_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Situacoes.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('situacoes', $this->paginate($this->Situacoes));
        $this->set('_serialize', ['situacoes']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Situacao id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $situacao = $this->Situacoes->get($id, [
            'contain' => ['Dispositivos']
        ]);
        $this->set('situacao', $situacao);
        $this->set('_serialize', ['situacao']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $situacao = $this->Situacoes->newEntity();
        if ($this->request->is('post')) {
            $situacao = $this->Situacoes->patchEntity($situacao, $this->request->data);
            if ($this->Situacoes->save($situacao)) {
                $this->Flash->success(__('O registro de situacao foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $situacao->id]);
            } else {
                $this->Flash->error(__('O registro de situacao não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('situacao'));
        $this->set('_serialize', ['situacao']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Situacao id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $situacao = $this->Situacoes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $situacao = $this->Situacoes->patchEntity($situacao, $this->request->data);
            if ($this->Situacoes->save($situacao)) {
                $this->Flash->success(__('O registro de situacao foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $situacao->id]);
            } else {
                $this->Flash->error(__('O registro de situacao não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('situacao'));
        $this->set('_serialize', ['situacao']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Situacao id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $situacao = $this->Situacoes->get($id);
        if ($this->Situacoes->delete($situacao)) {
            $this->Flash->success(__('O registro de situacao foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de situacao não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
