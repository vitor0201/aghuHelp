<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Motivos Controller
 *
 * @property \Mater\Model\Table\MotivosTable $Motivos
 */
class MotivosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorMotivos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'descricao'=> ['field'=> 'Motivos.descricao', 'operator'=>'ILIKE'],
						'ativo'=> ['field'=> 'Motivos.ativo', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterMotivos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Motivos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id,$object->descricao,$object->ativo ? 'S' : 'N'];
    		};
    		$this->Export->CSV('Motivos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','Descrição','Ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Motivos.descricao ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('motivos', $this->paginate($this->Motivos));
        $this->set('_serialize', ['motivos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Motivo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $motivo = $this->Motivos->get($id, [
            'contain' => ['CirurgiasProcedimentos']
        ]);
        $this->set('motivo', $motivo);
        $this->set('_serialize', ['motivo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $motivo = $this->Motivos->newEntity();
        if ($this->request->is('post')) {
            $motivo = $this->Motivos->patchEntity($motivo, $this->request->data);
            if ($this->Motivos->save($motivo)) {
                $this->Flash->success(__('O  motivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O  motivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('motivo'));
        $this->set('_serialize', ['motivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Motivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $motivo = $this->Motivos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $motivo = $this->Motivos->patchEntity($motivo, $this->request->data);
            if ($this->Motivos->save($motivo)) {
                $this->Flash->success(__('O  motivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O  motivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('motivo'));
        $this->set('_serialize', ['motivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Motivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $motivo = $this->Motivos->get($id);
        if ($this->Motivos->delete($motivo)) {
            $this->Flash->success(__('O  motivo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O  motivo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
