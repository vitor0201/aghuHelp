<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;

/**
 * TipoDispositivos Controller
 *
 * @property \Wifi\Model\Table\TipoDispositivosTable $TipoDispositivos
 */
class TipoDispositivosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorTipoDispositivos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'TipoDispositivos.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterTipoDispositivos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->TipoDispositivos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('TipoDispositivos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['TipoDispositivos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('tipoDispositivos', $this->paginate($this->TipoDispositivos));
        $this->set('_serialize', ['tipoDispositivos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Dispositivo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoDispositivo = $this->TipoDispositivos->get($id, [
            'contain' => ['Dispositivos']
        ]);
        $this->set('tipoDispositivo', $tipoDispositivo);
        $this->set('_serialize', ['tipoDispositivo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoDispositivo = $this->TipoDispositivos->newEntity();
        if ($this->request->is('post')) {
            $tipoDispositivo = $this->TipoDispositivos->patchEntity($tipoDispositivo, $this->request->data);
            if ($this->TipoDispositivos->save($tipoDispositivo)) {
                $this->Flash->success(__('O registro de tipo dispositivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $tipoDispositivo->id]);
            } else {
                $this->Flash->error(__('O registro de tipo dispositivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('tipoDispositivo'));
        $this->set('_serialize', ['tipoDispositivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Dispositivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoDispositivo = $this->TipoDispositivos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoDispositivo = $this->TipoDispositivos->patchEntity($tipoDispositivo, $this->request->data);
            if ($this->TipoDispositivos->save($tipoDispositivo)) {
                $this->Flash->success(__('O registro de tipo dispositivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $tipoDispositivo->id]);
            } else {
                $this->Flash->error(__('O registro de tipo dispositivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('tipoDispositivo'));
        $this->set('_serialize', ['tipoDispositivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Dispositivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tipoDispositivo = $this->TipoDispositivos->get($id);
        if ($this->TipoDispositivos->delete($tipoDispositivo)) {
            $this->Flash->success(__('O registro de tipo dispositivo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de tipo dispositivo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
