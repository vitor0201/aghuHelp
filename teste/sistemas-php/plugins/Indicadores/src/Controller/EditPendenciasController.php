<?php
namespace Indicadores\Controller;

use Indicadores\Controller\AppController;

/**
 * EditPendencias Controller
 *
 * @property \Indicadores\Model\Table\EditPendenciasTable $EditPendencias
 */
class EditPendenciasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorEditPendencias']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'EditPendencias.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterEditPendencias']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->EditPendencias->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('EditPendencias_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['EditPendencias.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('editPendencias', $this->paginate($this->EditPendencias));
        $this->set('_serialize', ['editPendencias']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Edit Pendencia id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $editPendencia = $this->EditPendencias->get($id, [
            'contain' => []
        ]);
        $this->set('editPendencia', $editPendencia);
        $this->set('_serialize', ['editPendencia']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
    	/*$criterios = TableRegistry::get ( 'Pendencias', [
    			'table' => 'kanban.pendencias'
    	] );
    	$criterios = $criterios->find ( 'all', [
    			'order' => 'unidade_id, especialidade_id, inicio'
    	] )
    	->where(['id'=>$id])
    	->toArray ();*/
        $editPendencia = $this->EditPendencias->newEntity();
        if ($this->request->is('post')) {
        	//Colocar valores nos campos
        	unset ( $this->request->data ['id'] );
        	$this->request->data ['data'] = date ( 'd/m/Y H:i:s' );
        	$this->request->data ['usuario'] = $this->login ['login'];
        	$this->request->data ['id_pendencia'] = $id;
        	
            $editPendencia = $this->EditPendencias->patchEntity($editPendencia, $this->request->data);
            if ($this->EditPendencias->save($editPendencia)) {
                $this->Flash->success(__('O registro foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $editPendencia->id]);
            } else {
                $this->Flash->error(__('O registro não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('editPendencia'));
        $this->set('_serialize', ['editPendencia']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Edit Pendencia id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $editPendencia = $this->EditPendencias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $editPendencia = $this->EditPendencias->patchEntity($editPendencia, $this->request->data);
            if ($this->EditPendencias->save($editPendencia)) {
                $this->Flash->success(__('O registro de edit pendencia foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $editPendencia->id]);
            } else {
                $this->Flash->error(__('O registro de edit pendencia não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('editPendencia'));
        $this->set('_serialize', ['editPendencia']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Edit Pendencia id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $editPendencia = $this->EditPendencias->get($id);
        if ($this->EditPendencias->delete($editPendencia)) {
            $this->Flash->success(__('O registro de edit pendencia foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de edit pendencia não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
