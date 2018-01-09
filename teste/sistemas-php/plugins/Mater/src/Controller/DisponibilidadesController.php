<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Disponibilidades Controller
 *
 * @property \Mater\Model\Table\DisponibilidadesTable $Disponibilidades
 */
class DisponibilidadesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Medicos', 'Periodos']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorDisponibilidades']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Disponibilidades.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterDisponibilidades']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Disponibilidades->find('all', ['conditions'=> $conditions  ,'contain' => ['Medicos', 'Periodos']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Disponibilidades_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Disponibilidades.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('disponibilidades', $this->paginate($this->Disponibilidades));
        $this->set('_serialize', ['disponibilidades']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Disponibilidade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $disponibilidade = $this->Disponibilidades->get($id, [
            'contain' => ['Medicos', 'Periodos']
        ]);
        $this->set('disponibilidade', $disponibilidade);
        $this->set('_serialize', ['disponibilidade']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $disponibilidade = $this->Disponibilidades->newEntity();
        if ($this->request->is('post')) {
            $disponibilidade = $this->Disponibilidades->patchEntity($disponibilidade, $this->request->data);
            if ($this->Disponibilidades->save($disponibilidade)) {
                $this->Flash->success(__('O registro de disponibilidade foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $disponibilidade->id]);
            } else {
                $this->Flash->error(__('O registro de disponibilidade não foi salvo. Por favor, tente novamente.'));
            }
        }
        $medicos = $this->Disponibilidades->Medicos->find('list', ['limit' => 200]);
        $periodos = $this->Disponibilidades->Periodos->find('list', ['limit' => 200]);
        $this->set(compact('disponibilidade', 'medicos', 'periodos'));
        $this->set('_serialize', ['disponibilidade']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Disponibilidade id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $disponibilidade = $this->Disponibilidades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $disponibilidade = $this->Disponibilidades->patchEntity($disponibilidade, $this->request->data);
            if ($this->Disponibilidades->save($disponibilidade)) {
                $this->Flash->success(__('O registro de disponibilidade foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $disponibilidade->id]);
            } else {
                $this->Flash->error(__('O registro de disponibilidade não foi salvo. Por favor, tente novamente.'));
            }
        }
        $medicos = $this->Disponibilidades->Medicos->find('list', ['limit' => 200]);
        $periodos = $this->Disponibilidades->Periodos->find('list', ['limit' => 200]);
        $this->set(compact('disponibilidade', 'medicos', 'periodos'));
        $this->set('_serialize', ['disponibilidade']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Disponibilidade id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $disponibilidade = $this->Disponibilidades->get($id);
        if ($this->Disponibilidades->delete($disponibilidade)) {
            $this->Flash->success(__('O registro de disponibilidade foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de disponibilidade não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
