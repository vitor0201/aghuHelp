<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;

/**
 * Coletas Controller
 *
 * @property \Wifi\Model\Table\ColetasTable $Coletas
 */
class ColetasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorColetas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Coletas.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterColetas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Coletas->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Coletas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Coletas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('coletas', $this->paginate($this->Coletas));
        $this->set('_serialize', ['coletas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Coleta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coleta = $this->Coletas->get($id, [
            'contain' => []
        ]);
        $this->set('coleta', $coleta);
        $this->set('_serialize', ['coleta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coleta = $this->Coletas->newEntity();
        if ($this->request->is('post')) {
            $coleta = $this->Coletas->patchEntity($coleta, $this->request->data);
            if ($this->Coletas->save($coleta)) {
                $this->Flash->success(__('O registro de coleta foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $coleta->id]);
            } else {
                $this->Flash->error(__('O registro de coleta não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('coleta'));
        $this->set('_serialize', ['coleta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Coleta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coleta = $this->Coletas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coleta = $this->Coletas->patchEntity($coleta, $this->request->data);
            if ($this->Coletas->save($coleta)) {
                $this->Flash->success(__('O registro de coleta foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $coleta->id]);
            } else {
                $this->Flash->error(__('O registro de coleta não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('coleta'));
        $this->set('_serialize', ['coleta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Coleta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coleta = $this->Coletas->get($id);
        if ($this->Coletas->delete($coleta)) {
            $this->Flash->success(__('O registro de coleta foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de coleta não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
