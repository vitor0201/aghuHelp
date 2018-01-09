<?php
namespace Sms\Controller;

use Sms\Controller\AppController;

/**
 * Recebidas Controller
 *
 * @property \Sms\Model\Table\RecebidasTable $Recebidas
 */
class RecebidasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorRecebidas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Recebidas.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterRecebidas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Recebidas->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Recebidas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Recebidas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('recebidas', $this->paginate($this->Recebidas));
        $this->set('_serialize', ['recebidas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Recebida id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recebida = $this->Recebidas->get($id, [
            'contain' => []
        ]);
        $this->set('recebida', $recebida);
        $this->set('_serialize', ['recebida']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	
    	
    	
    	
        $recebida = $this->Recebidas->newEntity();
    	
    	$phone 		= isset($_GET['phone']) 	? $_GET['phone'] 				: '';
    	$center 	= isset($_GET['smscenter']) ? $_GET['smscenter'] 			: '';
    	$text		= isset($_GET['smscenter']) ? rawurldecode($_GET['text']) 	: '';
    	
    	//debug($_GET); exit;
    	
    	$header		 = getallheaders();
    	
    	
	    	$phone = empty($phone) && isset($header['phone']) ? $header['phone'] : $phone;
	    	$center = empty($center) && isset($header['smscenter']) ? $header['smscenter'] : $center;
	    	$text = empty($text) && isset($header['text'])? rawurldecode($header['text']) : $text;
    	
    	if($phone && $text) {
    		$recebida->fone = $phone;
	    	$recebida->texto = $text;
	    	$recebida->smscenter = $center;
	    	$recebida->data_hora = date('d/m/Y H:i:s');
	    	
	    	$this->Recebidas->save($recebida);
    	}
    	
    	exit;
      
    
    }

    /**
     * Edit method
     *
     * @param string|null $id Recebida id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recebida = $this->Recebidas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recebida = $this->Recebidas->patchEntity($recebida, $this->request->data);
            if ($this->Recebidas->save($recebida)) {
                $this->Flash->success(__('O registro de recebida foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $recebida->id]);
            } else {
                $this->Flash->error(__('O registro de recebida não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('recebida'));
        $this->set('_serialize', ['recebida']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recebida id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recebida = $this->Recebidas->get($id);
        if ($this->Recebidas->delete($recebida)) {
            $this->Flash->success(__('O registro de recebida foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de recebida não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
