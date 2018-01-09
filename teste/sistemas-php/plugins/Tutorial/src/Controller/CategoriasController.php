<?php
namespace Tutorial\Controller;

use Tutorial\Controller\AppController;

/**
 * Categorias Controller
 *
 * @property \Tutorial\Model\Table\CategoriasTable $Categorias
 */
class CategoriasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorCategorias']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Categorias.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterCategorias']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Categorias->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Categorias_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Categorias.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('categorias', $this->paginate($this->Categorias));
        $this->set('_serialize', ['categorias']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Categoria id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoria = $this->Categorias->get($id/*, [
            'contain' => ['Arquivos']
        ]*/);
        $this->set('categoria', $categoria);
        $this->set('_serialize', ['categoria']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoria = $this->Categorias->newEntity();
        if ($this->request->is('post')) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data);
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('O registro de categoria foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $categoria->id]);
            } else {
                $this->Flash->error(__('O registro de categoria não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('categoria'));
        $this->set('_serialize', ['categoria']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Categoria id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoria = $this->Categorias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data);
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('O registro de categoria foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $categoria->id]);
            } else {
                $this->Flash->error(__('O registro de categoria não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('categoria'));
        $this->set('_serialize', ['categoria']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoria = $this->Categorias->get($id);
        if ($this->Categorias->delete($categoria)) {
            $this->Flash->success(__('O registro de categoria foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de categoria não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
