<?php
namespace Indicadores\Controller;

use Indicadores\Controller\AppController;

/**
 * Indicadores Controller
 *
 * @property \Indicadores\Model\Table\IndicadoresTable $Indicadores
 */
class IndicadoresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorIndicadores']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Indicadores.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterIndicadores']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Indicadores->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Indicadores_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Indicadores.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('indicadores', $this->paginate($this->Indicadores));
        $this->set('_serialize', ['indicadores']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Indicador id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $indicador = $this->Indicadores->get($id, [
            'contain' => ['Configuracao']
        ]);
        $this->set('indicador', $indicador);
        $this->set('_serialize', ['indicador']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $indicador = $this->Indicadores->newEntity();
        if ($this->request->is('post')) {
            $indicador = $this->Indicadores->patchEntity($indicador, $this->request->data);
            if ($this->Indicadores->save($indicador)) {
                $this->Flash->success(__('O registro de indicador foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $indicador->id]);
            } else {
                $this->Flash->error(__('O registro de indicador não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('indicador'));
        $this->set('_serialize', ['indicador']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Indicador id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $indicador = $this->Indicadores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $indicador = $this->Indicadores->patchEntity($indicador, $this->request->data);
            if ($this->Indicadores->save($indicador)) {
                $this->Flash->success(__('O registro de indicador foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $indicador->id]);
            } else {
                $this->Flash->error(__('O registro de indicador não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('indicador'));
        $this->set('_serialize', ['indicador']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Indicador id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $indicador = $this->Indicadores->get($id);
        if ($this->Indicadores->delete($indicador)) {
            $this->Flash->success(__('O registro de indicador foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de indicador não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
