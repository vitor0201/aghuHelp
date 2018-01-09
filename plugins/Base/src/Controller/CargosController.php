<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Cargo Controller
 *
 * @property \Base\Model\Table\CargoTable $Cargo
 */
class CargosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorCargo']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Cargos.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterCargo']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Cargos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Cargo_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Cargos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('cargos', $this->paginate($this->Cargos));
        $this->set('_serialize', ['cargos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Cargo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cargo = $this->Cargo->get($id, [
            'contain' => ['Funcionario']
        ]);
        $this->set('cargo', $cargo);
        $this->set('_serialize', ['cargo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cargo = $this->Cargos->newEntity();
        if ($this->request->is('post')) {
            $cargo = $this->Cargos->patchEntity($cargo, $this->request->data);
            if ($this->Cargos->save($cargo)) {
                $this->Flash->success(__('O registro de cargo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $cargo->id]);
            } else {
                $this->Flash->error(__('O registro de cargo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('cargo'));
        $this->set('_serialize', ['cargo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cargo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cargo = $this->Cargo->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cargo = $this->Cargo->patchEntity($cargo, $this->request->data);
            if ($this->Cargo->save($cargo)) {
                $this->Flash->success(__('O registro de cargo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $cargo->id]);
            } else {
                $this->Flash->error(__('O registro de cargo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('cargo'));
        $this->set('_serialize', ['cargo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cargo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cargo = $this->Cargo->get($id);
        if ($this->Cargo->delete($cargo)) {
            $this->Flash->success(__('O registro de cargo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de cargo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
