<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;
use Cake\ORM\TableRegistry;


/**
 * Redes Controller
 *
 * @property \Wifi\Model\Table\RedesTable $Redes
 */
class RedesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	$this->paginate = [
    		'contain' => ['Dispositivos']
    	];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorRedes']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'nome'=> ['field'=> 'Redes.nome', 'operator'=>'ILIKE'],
					'ativo'=> ['field'=> 'Redes.ativo', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterRedes']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Redes->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id, $object->nome, $object->faixa_ip,$object->ativo  ];
    		};
    		$this->Export->CSV('Redes_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','nome','faixa_ip','ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 50;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Redes.nome ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('redes', $this->paginate($this->Redes));
        $this->set('_serialize', ['redes']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Rede id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rede = $this->Redes->get($id, [
           // 'contain' => ['Dispositivos']
        ]);
        
        
        $this->loadComponent('Base.PaginationSession', ['session'=>'paginatorDispositivosView']);
        $this->PaginationSession->restore();
        
        if(!isset($this->request->query['order']))
        	$this->paginate['order'] = ['Dispositivos.data_cadastro DESC'];
        
       // $this->set('url', $this->Filter->getUrl());
        
        if(!isset($this->request->query['limit']))
        	$this->paginate['limit'] = 10;
        
        $this->PaginationSession->save();
        
        $this->set('dispositivos', $this->paginate($this->Redes->Dispositivos->find('all',['contain'=>['TipoDispositivos', 'Internautas', 'Situacoes'],'conditions'=>['Dispositivos.rede_id'=>$id]])));
        
        $this->set('rede', $rede);
        $this->set('_serialize', ['rede']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rede = $this->Redes->newEntity();
        if ($this->request->is('post')) {
            $rede = $this->Redes->patchEntity($rede, $this->request->data);
            if ($this->Redes->save($rede)) {
                $this->Flash->success(__('O registro de rede foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $rede->id]);
            } else {
                $this->Flash->error(__('O registro de rede não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('rede'));
        $this->set('_serialize', ['rede']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rede id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rede = $this->Redes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rede = $this->Redes->patchEntity($rede, $this->request->data);
            if ($this->Redes->save($rede)) {
                $this->Flash->success(__('O registro de rede foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $rede->id]);
            } else {
                $this->Flash->error(__('O registro de rede não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('rede'));
        $this->set('_serialize', ['rede']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rede id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rede = $this->Redes->get($id);
        if ($this->Redes->delete($rede)) {
            $this->Flash->success(__('O registro de rede foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de rede não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
  
    // para requisições ajax, recarregar a lista depois de escolher o sistema
    public function ips(){
    	//debug($this->request->data);
    	$ips = $this->Redes->getIps($this->request->data['rede_id']);
    	
    	foreach($ips as $ip) {
    		echo "<option value='$ip'> $ip</option>";
    	}
    	exit;
    }
    
}
