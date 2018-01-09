<?php
namespace Indicadores\Controller;

use Indicadores\Controller\AppController;

/**
 * TipoPendencias Controller
 *
 * @property \Indicadores\Model\Table\TipoPendenciasTable $TipoPendencias
 */
class TipoPendenciasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorTipoPendencias']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'TipoPendencias.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterTipoPendencias']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->TipoPendencias->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('TipoPendencias_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['TipoPendencias.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('tipoPendencias', $this->paginate($this->TipoPendencias));
        $this->set('_serialize', ['tipoPendencias']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Pendencia id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoPendencia = $this->TipoPendencias->get($id, [
            'contain' => []
        ]);
        $this->set('tipoPendencia', $tipoPendencia);
        $this->set('_serialize', ['tipoPendencia']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoPendencia = $this->TipoPendencias->newEntity();
        if ($this->request->is('post')) {
            $tipoPendencia = $this->TipoPendencias->patchEntity($tipoPendencia, $this->request->data);
            if ($this->TipoPendencias->save($tipoPendencia)) {
                //debug($this->TipoPendencias->save($tipoPendencia));
                $this->Flash->success(__('O registro foi salvo com sucesso.'));
                return $this->redirect(['action' => 'kanban','controller'=> 'Estatisticas']);
            } else {
                $this->Flash->error(__('O registro não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('tipoPendencia'));
        $this->set('_serialize', ['tipoPendencia']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Pendencia id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoPendencia = $this->TipoPendencias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoPendencia = $this->TipoPendencias->patchEntity($tipoPendencia, $this->request->data);
            if ($this->TipoPendencias->save($tipoPendencia)) {
                $this->Flash->success(__('O registro foi salvo com sucesso.'));
                return $this->redirect(['action' => 'kanban','controller'=> 'Estatisticas']);
            } else {
                $this->Flash->error(__('O registro não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('tipoPendencia'));
        $this->set('_serialize', ['tipoPendencia']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Pendencia id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
   /* public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tipoPendencia = $this->TipoPendencias->get($id);
        if ($this->TipoPendencias->delete($tipoPendencia)) {
            $this->Flash->success(__('O registro foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }*/
}
