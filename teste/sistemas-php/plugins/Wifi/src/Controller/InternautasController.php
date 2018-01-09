<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Internautas Controller
 *
 * @property \Wifi\Model\Table\InternautasTable $Internautas
 */
class InternautasController extends AppController
{
	public $REMOVIDO_ID = 4;
	public $ATIVO_ID = 3; // id da tabela wifi.situacoes;

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorInternautas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'nome'=> ['field'=> 'Internautas.nome', 'operator'=>'ILIKE', 'explode'=>'AND'],
				'cpf'=> ['field'=> 'Internautas.cpf', 'operator'=>'ILIKE'],
				'login'=> ['field'=> 'Internautas.login', 'operator'=>'ILIKE'],
				'setor'=> ['field'=> 'Internautas.setor', 'operator'=>'ILIKE'],
				'email'=> ['field'=> 'Internautas.email', 'operator'=>'ILIKE']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterInternautas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Internautas->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id,$object->nome,$object->cpf,$object->data_nascimento,$object->login,$object->setor,$object->contato,$object->email,$object->quantidade_dispositivos,$object->data_cadastro,$object->data_atualizacao, ];
    		};
    		$this->Export->CSV('Internautas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['_ID','Nome','CPF','Nascimento','Login','Setor','Contato','E-mail','Qtd. Disp. Permitido','Cadastro','Atualização'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Internautas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('internautas', $this->paginate($this->Internautas));
        $this->set('_serialize', ['internautas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Internauta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
    	
        $internauta = $this->Internautas->get($id, [
            'contain' => ['Dispositivos','Dispositivos.TipoDispositivos','Dispositivos.Situacoes']
        ]);
        
        
    	/*
        $internauta = $this->Internautas->find()
        ->contain(['Dispositivos'])
        ->where(['id' =>$id ])
        ->first();
        */
    	
        $this->set('internauta', $internauta);
        $this->set('_serialize', ['internauta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
   
    
    public function add()
    {
    	$internauta = $this->Internautas->newEntity();
    	if ($this->request->is('post')) {
    		$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
    		$this->request->data['data_atualizacao'] = date('d/m/Y H:i:s');
    		$internauta = $this->Internautas->patchEntity($internauta, $this->request->data);
    		if ($this->Internautas->save($internauta)) {
    			$this->Flash->success(__('O registro de internauta foi salvo com sucesso.'));
    			return $this->redirect(['action' => 'view', $internauta->id]);
    		} else {
    			$this->Flash->error(__('O registro de internauta não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    	$this->set(compact('internauta'));
    	$this->set('_serialize', ['internauta']);
    }
    
    /**
     * dados method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
  public function dados()
    {
    	
        //$internauta = $this->Internautas->get($id, [
       //     'contain' => ['Dispositivos']
       // ]);
        
    	$this->set('login', $this->login);
    	
    	$this->set('ativo_id', $this->ATIVO_ID);
        
        $internauta = $this->Internautas->find()
        //->contain(['Dispositivos'])
        ->where(['login' =>$this->login['login'] ])
        ->first();
        
        if(!$internauta)
        	$internauta = $this->Internautas->newEntity();
        
        $disp = TableRegistry::get('Wifi.Dispositivos');
        $dispositivos = $disp->find('all', ['contain' => ['TipoDispositivos','Situacoes'],'conditions'=>['Dispositivos.situacao_id <>'=>$this->REMOVIDO_ID,'Dispositivos.internauta_id'=>$internauta['id']]]);
       // debug($dispositivos);
        
        $this->set('meus_dispositivos', $dispositivos);
        $this->set('internauta', $internauta);
        $this->set('_serialize', ['internauta']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Internauta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
  
    public function meusDados()
    {
    	
    	//debug($this->login);
    	
    	$internauta = $this->Internautas->find()
					    ->where(['login' =>$this->login['login'] ])
					    ->first();
    	
    	if(!$internauta)  	{
    		$internauta = $this->Internautas->newEntity();
	    	$internauta->nome = $this->login['nome'];
	    	$internauta->login = $this->login['login'];
    	}
    	
    	//debug($this->request->is('post'));
    	
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		
    		
    		$this->request->data['nome'] = $this->login['nome'];
    		$this->request->data['login'] = $this->login['login'];
    		$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
    		$this->request->data['data_atualizacao'] = date('d/m/Y H:i:s');
    		
    		
    		$internauta = $this->Internautas->patchEntity($internauta, $this->request->data);
    		
    		
    		
    		if ($this->Internautas->save($internauta)) {
    			
    			$this->Flash->success(__('Dados atualizados com sucesso.'));
    			return $this->redirect(['action' => 'dados']);
    		} else {
    			//debug($internauta->errors());
    			
    			$this->Flash->error(__('Os dados não foram salvos. Por favor, tente novamente.'));
    			//return;
    		}
    	}
    	$this->set(compact('internauta'));
    	$this->set('_serialize', ['internauta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Internauta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $internauta = $this->Internautas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $internauta = $this->Internautas->patchEntity($internauta, $this->request->data);
            if ($this->Internautas->save($internauta)) {
                $this->Flash->success(__('O registro de internauta foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $internauta->id]);
            } else {
                $this->Flash->error(__('O registro de internauta não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('internauta'));
        $this->set('_serialize', ['internauta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Internauta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $internauta = $this->Internautas->get($id);
        if ($this->Internautas->delete($internauta)) {
            $this->Flash->success(__('O registro de internauta foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de internauta não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
