<?php
namespace Tutorial\Controller;

use Tutorial\Controller\AppController;

/**
 * Tags Controller
 *
 * @property \Tutorial\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorTags']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Tags.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterTags']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Tags->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Tags_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Tags.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('tags', $this->paginate($this->Tags));
        $this->set('_serialize', ['tags']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
           // 'contain' => ['Arquivos']
        ]);
        $this->set('tag', $tag);
        $this->set('_serialize', ['tag']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('O registro de tag foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $tag->id]);
            } else {
                $this->Flash->error(__('O registro de tag não foi salvo. Por favor, tente novamente.'));
            }
        }
        //$arquivos = $this->Tags->Arquivos->find('list', ['limit' => 200]);
       $this->set(compact('tag'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, [
          //  'contain' => ['Arquivos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('O registro de tag foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $tag->id]);
            } else {
                $this->Flash->error(__('O registro de tag não foi salvo. Por favor, tente novamente.'));
            }
        }
        //$arquivos = $this->Tags->Arquivos->find('list', ['limit' => 200]);
       $this->set(compact('tag'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('O registro de tag foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de tag não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
