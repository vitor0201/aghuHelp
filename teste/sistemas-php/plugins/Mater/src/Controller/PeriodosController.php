<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Periodos Controller
 *
 * @property \Mater\Model\Table\PeriodosTable $Periodos
 */
class PeriodosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorPeriodos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'descricao'=> ['field'=> 'Periodos.descricao', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Periodos.ativo', 'operator'=>'='] 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterPeriodos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Periodos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id, $object->descricao, $object->ativo ? 'S' : 'N'];
    		};
    		$this->Export->CSV('Periodos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','Descrição', 'Ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Periodos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('periodos', $this->paginate($this->Periodos));
        $this->set('_serialize', ['periodos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Periodo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $periodo = $this->Periodos->get($id, [
            'contain' => ['Agendamentos', 'Disponibilidades']
        ]);
        $this->set('periodo', $periodo);
        $this->set('_serialize', ['periodo']);
    }
	*/
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periodo = $this->Periodos->newEntity();
        if ($this->request->is('post')) {
            $periodo = $this->Periodos->patchEntity($periodo, $this->request->data);
            if ($this->Periodos->save($periodo)) {
                $this->Flash->success(__('O registro de periodo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
//                 return $this->redirect(['action' => 'view', $periodo->id]);
            } else {
                $this->Flash->error(__('O registro de período não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('periodo'));
        $this->set('_serialize', ['periodo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Periodo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $periodo = $this->Periodos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $periodo = $this->Periodos->patchEntity($periodo, $this->request->data);
            if ($this->Periodos->save($periodo)) {
                $this->Flash->success(__('O registro de periodo foi salvo com sucesso.'));
//                 return $this->redirect(['action' => 'view', $periodo->id]);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O registro de período não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('periodo'));
        $this->set('_serialize', ['periodo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Periodo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $periodo = $this->Periodos->get($id);
        if ($this->Periodos->delete($periodo)) {
            $this->Flash->success(__('O registro de período foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de período não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
