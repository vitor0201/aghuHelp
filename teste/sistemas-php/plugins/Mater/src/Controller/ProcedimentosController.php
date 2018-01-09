<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Procedimentos Controller
 *
 * @property \Mater\Model\Table\ProcedimentosTable $Procedimentos
 */
class ProcedimentosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorProcedimentos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'descricao'=> ['field'=> 'Procedimentos.descricao2', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Procedimentos.ativo', 'operator'=>'='] ,
				'codigo'=> ['field'=> 'Procedimentos.codigo', 'operator'=>'ILIKE'] ,
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterProcedimentos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Procedimentos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id, $object->codigo, $object->descricao,$object->ativo ?'S':'N'  ];
    		};
    		$this->Export->CSV('Procedimentos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','Código','Descrição','Ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Procedimentos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('procedimentos', $this->paginate($this->Procedimentos));
        $this->set('_serialize', ['procedimentos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Procedimento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $procedimento = $this->Procedimentos->get($id, [
            'contain' => ['Medicos', 'Documentos']
        ]);
        $this->set('procedimento', $procedimento);
        $this->set('_serialize', ['procedimento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $procedimento = $this->Procedimentos->newEntity();
        if ($this->request->is('post')) {
            $procedimento = $this->Procedimentos->patchEntity($procedimento, $this->request->data);
            if ($this->Procedimentos->save($procedimento)) {
                $this->Flash->success(__('O registro de procedimento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $procedimento->id]);
            } else {
                $this->Flash->error(__('O registro de procedimento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $medicos = $this->Procedimentos->Medicos->find('list', ['limit' => 200]);
        $this->set(compact('procedimento', 'medicos'));
        $this->set('_serialize', ['procedimento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Procedimento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $procedimento = $this->Procedimentos->get($id, [
            'contain' => ['Medicos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $procedimento = $this->Procedimentos->patchEntity($procedimento, $this->request->data);
            if ($this->Procedimentos->save($procedimento)) {
                $this->Flash->success(__('O registro de procedimento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $procedimento->id]);
            } else {
                $this->Flash->error(__('O registro de procedimento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $medicos = $this->Procedimentos->Medicos->find('list', ['limit' => 200]);
        $this->set(compact('procedimento', 'medicos'));
        $this->set('_serialize', ['procedimento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Procedimento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $procedimento = $this->Procedimentos->get($id);
        if ($this->Procedimentos->delete($procedimento)) {
            $this->Flash->success(__('O registro de procedimento foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de procedimento não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
