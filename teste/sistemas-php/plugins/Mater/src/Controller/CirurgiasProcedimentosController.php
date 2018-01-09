<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * CirurgiasProcedimentos Controller
 *
 * @property \Mater\Model\Table\CirurgiasProcedimentosTable $CirurgiasProcedimentos
 */
class CirurgiasProcedimentosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Agendamentos', 'Procedimentos', 'Resultados']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorCirurgiasProcedimentos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'CirurgiasProcedimentos.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterCirurgiasProcedimentos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->CirurgiasProcedimentos->find('all', ['conditions'=> $conditions  ,'contain' => ['Agendamentos', 'Procedimentos', 'Resultados']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('CirurgiasProcedimentos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['CirurgiasProcedimentos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('cirurgiasProcedimentos', $this->paginate($this->CirurgiasProcedimentos));
        $this->set('_serialize', ['cirurgiasProcedimentos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Cirurgias Procedimento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cirurgiasProcedimento = $this->CirurgiasProcedimentos->get($id, [
            'contain' => ['Agendamentos', 'Procedimentos', 'Resultados']
        ]);
        $this->set('cirurgiasProcedimento', $cirurgiasProcedimento);
        $this->set('_serialize', ['cirurgiasProcedimento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cirurgiasProcedimento = $this->CirurgiasProcedimentos->newEntity();
        if ($this->request->is('post')) {
            $cirurgiasProcedimento = $this->CirurgiasProcedimentos->patchEntity($cirurgiasProcedimento, $this->request->data);
            if ($this->CirurgiasProcedimentos->save($cirurgiasProcedimento)) {
                $this->Flash->success(__('O registro de cirurgias procedimento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $cirurgiasProcedimento->id]);
            } else {
                $this->Flash->error(__('O registro de cirurgias procedimento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $agendamentos = $this->CirurgiasProcedimentos->Agendamentos->find('list', ['limit' => 200]);
        $procedimentos = $this->CirurgiasProcedimentos->Procedimentos->find('list', ['limit' => 200]);
        $resultados = $this->CirurgiasProcedimentos->Resultados->find('list', ['limit' => 200]);
        $this->set(compact('cirurgiasProcedimento', 'agendamentos', 'procedimentos', 'resultados'));
        $this->set('_serialize', ['cirurgiasProcedimento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cirurgias Procedimento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cirurgiasProcedimento = $this->CirurgiasProcedimentos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cirurgiasProcedimento = $this->CirurgiasProcedimentos->patchEntity($cirurgiasProcedimento, $this->request->data);
            if ($this->CirurgiasProcedimentos->save($cirurgiasProcedimento)) {
                $this->Flash->success(__('O registro de cirurgias procedimento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $cirurgiasProcedimento->id]);
            } else {
                $this->Flash->error(__('O registro de cirurgias procedimento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $agendamentos = $this->CirurgiasProcedimentos->Agendamentos->find('list', ['limit' => 200]);
        $procedimentos = $this->CirurgiasProcedimentos->Procedimentos->find('list', ['limit' => 200]);
        $resultados = $this->CirurgiasProcedimentos->Resultados->find('list', ['limit' => 200]);
        $this->set(compact('cirurgiasProcedimento', 'agendamentos', 'procedimentos', 'resultados'));
        $this->set('_serialize', ['cirurgiasProcedimento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cirurgias Procedimento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cirurgiasProcedimento = $this->CirurgiasProcedimentos->get($id);
        if ($this->CirurgiasProcedimentos->delete($cirurgiasProcedimento)) {
            $this->Flash->success(__('O registro de cirurgias procedimento foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de cirurgias procedimento não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
