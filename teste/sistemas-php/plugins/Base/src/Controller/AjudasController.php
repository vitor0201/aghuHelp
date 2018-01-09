<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Ajudas Controller
 *
 * @property \App\Model\Table\AjudasTable $Ajudas
 */
class AjudasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	
    	 
        $this->paginate = [
            'contain' => ['ParentAjudas', 'Sistemas']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorAjudas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Ajudas.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterAjudas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Ajudas->find('all', ['conditions'=> $conditions  ,'contain' => ['ParentAjudas', 'Sistemas']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Ajudas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Ajudas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('ajudas', $this->paginate($this->Ajudas));
        $this->set('_serialize', ['ajudas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Ajuda id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ajuda = $this->Ajudas->get($id, [
            'contain' => ['ParentAjudas', 'Sistemas', 'ChildAjudas']
        ]);
        $this->set('ajuda', $ajuda);
        $this->set('_serialize', ['ajuda']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ajuda = $this->Ajudas->newEntity();
        if ($this->request->is('post')) {
            $ajuda = $this->Ajudas->patchEntity($ajuda, $this->request->data);
            if ($this->Ajudas->save($ajuda)) {
                $this->Flash->success(__('O registro de ajuda foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $ajuda->id]);
            } else {
                $this->Flash->error(__('O registro de ajuda não foi salvo. Por favor, tente novamente.'));
            }
        }
        $parentAjudas = $this->Ajudas->ParentAjudas->find('list', ['limit' => 200]);
        $sistemas = $this->Ajudas->Sistemas->find('list', ['limit' => 200]);
        $this->set(compact('ajuda', 'parentAjudas', 'sistemas'));
        $this->set('_serialize', ['ajuda']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ajuda id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ajuda = $this->Ajudas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ajuda = $this->Ajudas->patchEntity($ajuda, $this->request->data);
            if ($this->Ajudas->save($ajuda)) {
                $this->Flash->success(__('O registro de ajuda foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $ajuda->id]);
            } else {
                $this->Flash->error(__('O registro de ajuda não foi salvo. Por favor, tente novamente.'));
            }
        }
        $parentAjudas = $this->Ajudas->ParentAjudas->find('list', ['limit' => 200]);
        $sistemas = $this->Ajudas->Sistemas->find('list', ['limit' => 200]);
        $this->set(compact('ajuda', 'parentAjudas', 'sistemas'));
        $this->set('_serialize', ['ajuda']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ajuda id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ajuda = $this->Ajudas->get($id);
        if ($this->Ajudas->delete($ajuda)) {
            $this->Flash->success(__('O registro de ajuda foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de ajuda não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
