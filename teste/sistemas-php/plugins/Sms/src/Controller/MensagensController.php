<?php
namespace Sms\Controller;

use Sms\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;


/**
 * Mensagens Controller
 *
 * @property \Sms\Model\Table\MensagensTable $Mensagens
 */
class MensagensController extends AppController
{

	public function chat($fone){
		$h = TableRegistry::get('Sms.Historicos');
		$msgs = $h->find('all', ['conditions'=>["Historicos.fone"=>$fone],'order'=>'Historicos.data_hora']);
		//debug($msgs); exit;
		$this->set('msgs',$msgs);
		$this->set('fone',$fone);
		
		// marca as mensagens como lidas
		$r = TableRegistry::get('Sms.Recebidas');
		$r->updateAll(
				['lido' =>date('d/m/Y H:i:s'),'lido_login'=> $this->login['login'] ], // fields
				['lido IS NULL', "fone"=>$fone]); // conditions
		
		// prepara para inserção de uma nova msg
		$mensagem = $this->Mensagens->newEntity();
		
		// verifica se o telefone pertence a um paciente do AGHU
		$ddd = (substr($fone,3,2));
		$fone_1 = (substr($fone,5));
		$conn = ConnectionManager::get('aghu');
		
		$pacientes = TableRegistry::get('Pacientes', [
				'table' => 'agh.aip_pacientes',
				'connection' => $conn,
				]);
		
		$query = $pacientes->find();
		$query = $query->where(['OR'=>['ddd_fone_residencial'=>$ddd,'ddd_fone_recado'=>$ddd]]);
		$query = $query->where(['OR'=>['fone_residencial'=>$fone_1,'fone_recado'=>$fone_1]]);
		
		$paciente = [];
		$query = $query->first();
		//debug($query);
		
		if($query)
			$paciente = $query->toArray();
		
		$this->set('paciente',$paciente);
		
		$this->set('mensagem',$mensagem);
	}
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorMensagens']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'fone'=> ['field'=> 'Mensagens.fone', 'operator'=>'ILIKE'],
					'login'=> ['field'=> 'Mensagens.login', 'operator'=>'ILIKE']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterMensagens']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Mensagens->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id,$object->fone,$object->data_hora,$object->texto,$object->login];
    		};
    		$this->Export->CSV('Mensagens_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['_ID','FONE','DATA','MSG','LOGIN'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Mensagens.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('mensagens', $this->paginate($this->Mensagens));
        $this->set('_serialize', ['mensagens']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Mensagem id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mensagem = $this->Mensagens->get($id, [
            'contain' => []
        ]);
        $this->set('mensagem', $mensagem);
        $this->set('_serialize', ['mensagem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	set_time_limit(120);
    	$this->loadComponent('Base.Parametro');
    	
    	$server_url 	= $this->Parametro->get('sms.servidor_gateway');
    	$permite_envio 	= $this->Parametro->get('sms.permitido', FALSE);
    	$ddd 			= $this->Parametro->get('sms.ddd_padrao');
    	$ddds 			= $this->Parametro->get('sms.ddds_permitidos');
    	
    	$arr_ddd = [];
    	$ddds = explode(',',$ddds);
    	foreach($ddds as $d){
    		$arr_ddd[$d]=$d;
    	}
    	$this->set('ddds',$arr_ddd);
    	$this->set('ddd', $ddd);
    	$this->set('permite_envio', $permite_envio);
    	
        $mensagem = $this->Mensagens->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	if(!$permite_envio){
        		$this->Flash->error(__('Envio de SMS está temporariamente indisponível.'));
        		return $this->redirect(['action' => 'add']);
        	}
        	
        	$this->request->data['login'] = $this->login['login'];
        	$this->request->data['data_hora'] = date('d/m/Y H:i:s');
        	$this->request->data['status'] = 'Pendente';
        	//debug()
            $mensagem = $this->Mensagens->patchEntity($mensagem, $this->request->data);
            
            $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç','|','"',"'",'&','~','^','>','<','ª','º','{','}','[',']' );
            // matriz de saída
            $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
            // devolver a string
            $msg = str_replace($what, $by, $this->request->data['texto']);
            $mensagem->texto = $msg;
            
            $mensagem->fone = "+55".$this->request->data['ddd'] . $this->request->data['fone'];
            
            if ($this->Mensagens->save($mensagem)) {
            	
            	$fone = $mensagem->fone;
            	$msg = $mensagem->texto;
				 
				//debug($msg);
				
            	$msg = rawurlencode($msg);
            	
            	//debug($msg); exit;
            	
            	
            	$URL = str_replace('%fone%',$fone,$server_url);
            	$URL = str_replace('%msg%',$msg,$URL);
            	
            	//$URL = "http://10.42.129.26:8090/sendsms?phone=$fone&text=$msg";
            	
            	//debug($URL); exit;
            	
            	$ch = curl_init();
            	// set url
            	curl_setopt($ch, CURLOPT_URL, $URL);
            	//return the transfer as a string
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            	
            	// $output contains the output string
            	$output = curl_exec($ch);
            	
            	//debug($output); exit;
            	
            	// close curl resource to free up system resources
            	curl_close($ch);
            	$mensagem->status = $output;
            	$this->Mensagens->save($mensagem);
            	
            	
                $this->Flash->success(__('Mensagem cadastrada com sucesso.'));
            	
                //return $this->redirect(['action' => 'view', $mensagem->id]);
                //return $this->redirect(['action' => 'chat', $fone]);
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('A mensagem não foi cadastrada. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('mensagem'));
        $this->set('_serialize', ['mensagem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mensagem id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mensagem = $this->Mensagens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mensagem = $this->Mensagens->patchEntity($mensagem, $this->request->data);
            if ($this->Mensagens->save($mensagem)) {
                $this->Flash->success(__('O registro de mensagem foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $mensagem->id]);
            } else {
                $this->Flash->error(__('O registro de mensagem não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('mensagem'));
        $this->set('_serialize', ['mensagem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mensagem id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mensagem = $this->Mensagens->get($id);
        if ($this->Mensagens->delete($mensagem)) {
            $this->Flash->success(__('O registro de mensagem foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de mensagem não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
