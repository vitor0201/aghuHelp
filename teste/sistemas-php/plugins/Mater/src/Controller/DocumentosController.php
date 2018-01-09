<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Documentos Controller
 *
 * @property \Mater\Model\Table\DocumentosTable $Documentos
 */
class DocumentosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
//             'contain' => ['Procedimentos']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorDocumentos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'titulo'=> ['field'=> 'Documentos.titulo', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Documentos.ativo', 'operator'=>'='] 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterDocumentos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Documentos->find('all', ['conditions'=> $conditions  ,'contain' => ['Procedimentos']   ]);
    		$callback = function ($object){
    			return [$object->id,$object->titulo,$object->cadastro,$object->ativo?'S':'N',$object->arquivo_nome, $object->arquivo_tamanho,$object->arquivo_tipo,$object->usuario_cadastro];
    		};
    		$this->Export->CSV('Documentos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','Título','Cadastro','Ativo','Arquivo_Nome','Arquivo_Tamanho','Arquivo_Tipo','Usuário_Cadastro'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Documentos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('documentos', $this->paginate($this->Documentos));
        $this->set('_serialize', ['documentos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Documento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documento = $this->Documentos->get($id, [
            'contain' => ['Procedimentos']
        ]);
        $this->set('documento', $documento);
        $this->set('_serialize', ['documento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documento = $this->Documentos->newEntity();
        if ($this->request->is('post')) {
            $documento = $this->Documentos->patchEntity($documento, $this->request->data);
            
//             debug($this->request->data); exit;
            
            /*
             * UPLOAD DE ARQUIVO
             */
            
            IF(empty($this->request->data['upload']['name'])){
            	$this->Flash->error(__('Erro. Não foi possível enviar o arquivo escolhido.'));

            }
//             elseif(!is_uploaded_file($this->request->data['upload']['name'])){
//             	$this->Flash->error(__('Não foi possível enviar o arquivo escolhido.'));
//             }
            else{
            	
            	$file_path =  $this->request->data['upload']['tmp_name'];
            	
            	$file_name = $this->request->data['upload']['name'];
            	$file_name = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file_name); // LIMPA CARACTERES DO NOME
            	$file_name = mb_ereg_replace("([\.]{2,})", '', $file_name);
            	
            	$file_size =  $this->request->data['upload']['size'];
            	$file_type =  $this->request->data['upload']['type'];
            	
            	$file_contents = file_get_contents ($file_path) ;

//             	debug($this->request->data);
//             	debug($file_name);
//             	debug($file_contents); exit;
            	
            	$documento->arquivo = $file_contents;
            	$documento->arquivo_nome = $file_name;
            	$documento->arquivo_tipo = $file_type;
            	$documento->arquivo_tamanho = $file_size;
            	
            	$documento->cadastro = date('d/m/Y H:i:s');
            	$documento->usuario_cadastro = $this->login['login'];
            	
            	if ($this->Documentos->save($documento)) {
            		$this->Flash->success(__('O registro de documento foi salvo com sucesso.'));
            		return $this->redirect(['action' => 'view', $documento->id]);
            	} else {
//             		debug($documento);
            		$this->Flash->error(__('O registro de documento não foi salvo. Por favor, tente novamente.'));
            	}
            }
        }
        
        $procedimentos = $this->Documentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'Procedimentos.descricao']);
        $this->set(compact('documento', 'procedimentos'));
        $this->set('_serialize', ['documento']);
    }
    

    /**
     * Edit method
     *
     * @param string|null $id Documento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documento = $this->Documentos->get($id, [
            'contain' => ['Procedimentos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documento = $this->Documentos->patchEntity($documento, $this->request->data);
            /*
             * upload de arquivo - alterar/substituir
             */
            IF($this->request->data['upload']['name']){
//             	debug($this->request->data); exit;
	            $file_path =  $this->request->data['upload']['tmp_name'];
	             
	            $file_name = $this->request->data['upload']['name'];
	            $file_name = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file_name); // LIMPA CARACTERES DO NOME
	            $file_name = mb_ereg_replace("([\.]{2,})", '', $file_name);
	             
	            $file_size =  $this->request->data['upload']['size'];
	            $file_type =  $this->request->data['upload']['type'];
	             
	            $file_contents = file_get_contents ($file_path) ;
	            
	            //             	debug($this->request->data);
	            //             	debug($file_name);
	            //             	debug($file_contents); exit;
	             
	            $documento->arquivo = $file_contents;
	            $documento->arquivo_nome = $file_name;
	            $documento->arquivo_tipo = $file_type;
	            $documento->arquivo_tamanho = $file_size;
            }
            
            $documento->cadastro = date('d/m/Y H:i:s');
            $documento->usuario_cadastro = $this->login['login'];
            
            if ($this->Documentos->save($documento)) {
                $this->Flash->success(__('O registro de documento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $documento->id]);
            } else {
                $this->Flash->error(__('O registro de documento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $procedimentos = $this->Documentos->Procedimentos->find('list', ['conditions' => ['ativo'=>true], 'order'=>'Procedimentos.descricao']);
        $this->set(compact('documento', 'procedimentos'));
        $this->set('_serialize', ['documento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Documento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documento = $this->Documentos->get($id);
        if ($this->Documentos->delete($documento)) {
            $this->Flash->success(__('O registro de documento foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de documento não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function download($id){
    	set_time_limit(0);
    	$file = $this->Documentos->get($id);

    	header('Content-type: '. $file->arquivo_tipo );
    	header('Content-length: ' . $file->arquivo_tamanho); // some people reported problems with this line (see the comments), commenting out this line helped in those cases
    	header('Content-Disposition: attachment; filename="'.$file->arquivo_nome);
    	echo stream_get_contents($file->arquivo);
    	exit();
    }
}
