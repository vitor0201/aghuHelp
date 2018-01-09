<?php
namespace Tutorial\Controller;

use Tutorial\Controller\AppController;

/**
 * Arquivos Controller
 *
 * @property \Tutorial\Model\Table\ArquivosTable $Arquivos
 */
class ArquivosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('FileUploadComponent');
	}
	
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categorias']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorArquivos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Arquivos.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterArquivos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Arquivos->find('all', ['conditions'=> $conditions  ,'contain' => ['Categorias']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Arquivos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Arquivos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('arquivos', $this->paginate($this->Arquivos));
        $this->set('_serialize', ['arquivos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Arquivo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $arquivo = $this->Arquivos->get($id, [
            'contain' => ['Categorias', 'Tags']
        ]);
        $this->set('arquivo', $arquivo);
        $this->set('_serialize', ['arquivo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $arquivo = $this->Arquivos->newEntity();
        if ($this->request->is('post')) {
            $arquivo = $this->Arquivos->patchEntity($arquivo, $this->request->data);
            if ($this->Arquivos->save($arquivo)) {
                $this->Flash->success(__('O registro de arquivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $arquivo->id]);
            } else {
                $this->Flash->error(__('O registro de arquivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $categorias = $this->Arquivos->Categorias->find('list', ['limit' => 200, 'keyField'=>'id', 'valueField'=>'descricao']);
        $tags = $this->Arquivos->Tags->find('list', ['limit' => 200, 'keyValue'=>'id','valueField'=>'descricao']);
        $this->set(compact('arquivo', 'categorias', 'tags'));
        $this->set('_serialize', ['arquivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Arquivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $arquivo = $this->Arquivos->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $arquivo = $this->Arquivos->patchEntity($arquivo, $this->request->data);
            if ($this->Arquivos->save($arquivo)) {
                $this->Flash->success(__('O registro de arquivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $arquivo->id]);
            } else {
                $this->Flash->error(__('O registro de arquivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $categorias = $this->Arquivos->Categorias->find('list', ['limit' => 200]);
        $tags = $this->Arquivos->Tags->find('list', ['limit' => 200]);
        $this->set(compact('arquivo', 'categorias', 'tags'));
        $this->set('_serialize', ['arquivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Arquivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $arquivo = $this->Arquivos->get($id);
        if ($this->Arquivos->delete($arquivo)) {
            $this->Flash->success(__('O registro de arquivo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de arquivo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    public function upload()
    {
    	if( !empty( $this->request->data))
    	{
    		$this->FileUploadComponent->fileUpload($this->request->data[''])
    	}
    }
}
