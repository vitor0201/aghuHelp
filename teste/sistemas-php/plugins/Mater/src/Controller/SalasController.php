<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Salas Controller
 *
 * @property \Mater\Model\Table\SalasTable $Salas
 */
class SalasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorSalas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'descricao'=> ['field'=> 'Salas.descricao', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Salas.ativo', 'operator'=>'='] 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterSalas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Salas->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			
    			return [$object->id, $object->descricao, ($object->ativo? 'SIM':'NÃO')];
    		};
    		$this->Export->CSV('Salas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','descrição','ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Salas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('salas', $this->paginate($this->Salas));
        $this->set('_serialize', ['salas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Sala id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $sala = $this->Salas->get($id, [
            'contain' => ['Agendamentos']
        ]);
        $this->set('sala', $sala);
        $this->set('_serialize', ['sala']);
    }
*/
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sala = $this->Salas->newEntity();
        if ($this->request->is('post')) {
            $sala = $this->Salas->patchEntity($sala, $this->request->data);
            if ($this->Salas->save($sala)) {
                $this->Flash->success(__('O registro de sala foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
//                 return $this->redirect(['action' => 'view', $sala->id]);
            } else {
                $this->Flash->error(__('O registro de sala não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('sala'));
        $this->set('_serialize', ['sala']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sala id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sala = $this->Salas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sala = $this->Salas->patchEntity($sala, $this->request->data);
            if ($this->Salas->save($sala)) {
                $this->Flash->success(__('O registro de sala foi salvo com sucesso.'));
//                 return $this->redirect(['action' => 'view', $sala->id]);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O registro de sala não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('sala'));
        $this->set('_serialize', ['sala']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sala id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sala = $this->Salas->get($id);
        if ($this->Salas->delete($sala)) {
            $this->Flash->success(__('O registro de sala foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de sala não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
