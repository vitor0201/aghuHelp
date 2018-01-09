<?php
namespace Wifi\Controller;

use Wifi\Controller\AppController;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;


/**
 * Dispositivos Controller
 *
 * @property \Wifi\Model\Table\DispositivosTable $Dispositivos
 */
class DispositivosController extends AppController
{

	public $REMOVIDO_ID = 4; // id da tabela wifi.situacoes;
	public $ATIVO_ID = 3; // id da tabela wifi.situacoes;
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    	
    	
        $this->paginate = [
            'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes','Redes']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorDispositivos']);
    	$this->PaginationSession->restore();

    	
    	$tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list');
    	
    	$redes = $this->Dispositivos->Redes->find('list');
    	
    	$situacoes = $this->Dispositivos->Situacoes->find('list');
    	$this->set(compact('dispositivo', 'tipoDispositivos', 'situacoes', 'redes'));
    	
		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro_data_cadastro_inicio'=> ['field'=> 'Dispositivos.data_cadastro', 'operator'=>'>='],
					'filtro_data_cadastro_fim'=> ['field'=> 'Dispositivos.data_cadastro', 'operator'=>'<='],
					'filtro_data_validade_inicio'=> ['field'=> 'Dispositivos.data_validade', 'operator'=>'>='],
					'filtro_data_validade_fim'=> ['field'=> 'Dispositivos.data_validade', 'operator'=>'<='],
					'tipo_dispositivo_id'=> ['field'=> 'Dispositivos.tipo_dispositivo_id', 'operator'=>'IN'],
					'filtro_login'=> ['field'=> 'Internautas.login', 'operator'=>'ILIKE'],
					'situacao_id'=> ['field'=> 'Dispositivos.situacao_id', 'operator'=>'IN'],
					'filtro_mac'=> ['field'=> 'Dispositivos.endereco_mac', 'operator'=>'ILIKE'],
					'filtro_ip'=> ['field'=> 'Dispositivos.endereco_ip', 'operator'=>'ILIKE'],
					'rede_id'=> ['field'=> 'Dispositivos.rede_id', 'operator'=>'IN'],
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterDispositivos']);
    	//debug($conditions);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Dispositivos->find('all', ['conditions'=> $conditions  ,'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes','Redes']   ]);
    		$callback = function ($object){
    			return [$object->id,$object->internauta->nome, $object->internauta->login, $object->tipo_dispositivo->descricao,$object->situacao->descricao,$object->endereco_mac,$object->endereco_ip,$object->rede->nome,$object->data_cadastro,$object->data_validade, $object->justificativa, $object->created,$object->modified,   ];
    		};
    		$this->Export->CSV('Dispositivos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['_ID','Internauta','Login','Tipo','Status','MAC','IP','Int.Rede','Cadastro','Validade','Justificativa','Created','Modified'], $callback );
    	}
    	
    	// SEND MAIL p/ TODOS
    	if(isset($this->request->query['export']) && $this->request->query['export']=='mail'){
    		set_time_limit(0);
    		$data_export = $this->Dispositivos->find('all', ['conditions'=> $conditions  ,'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes']   ]);
    		$count_ok=0;
    		foreach($data_export as $aparelho) {
    			
    			if($this->enviarEmail($aparelho->id, false)==true)
    				$count_ok++;
    			
    		}
    		if($count_ok)
    			$this->Flash->success(__('Foram enviados '. $count_ok . ' e-mails.'));
    		else 
    			$this->Flash->error(__('Erro: Nenhum e-mail foi enviado.'));
    		
    		return $this->redirect(['action' => 'index']);
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Dispositivos.data_cadastro DESC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('dispositivos', $this->paginate($this->Dispositivos));
        $this->set('_serialize', ['dispositivos']);
        
         $this->PaginationSession->save();
    }
    
    
    public function meusDispositivos()
    {
    	$this->paginate = [
    	'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes']
    	];
    
    	$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorDispositivos']);
    	$this->PaginationSession->restore();
    
    	$this->loadComponent('Base.Filter');
    	$this->Filter->addFilter([
    			'filtro1'=> ['field'=> 'Dispositivos.id', 'operator'=>'=']
    			// ...
    			]);
    	 
    	$conditions = $this->Filter->getConditions(['session'=>'filterDispositivos']);
    	$this->set('url', $this->Filter->getUrl());
    	 
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Dispositivos->find('all', ['conditions'=> $conditions  ,'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Dispositivos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	 
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Dispositivos.id ASC'];
    
    
    	$this->paginate['conditions']	= $conditions;
    	 
    	$this->set('dispositivos', $this->paginate($this->Dispositivos));
    	$this->set('_serialize', ['dispositivos']);
    
    	$this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Dispositivo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dispositivo = $this->Dispositivos->get($id, [
            'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes','Redes']
        ]);
        $this->set('dispositivo', $dispositivo);
        $this->set('_serialize', ['dispositivo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dispositivo = $this->Dispositivos->newEntity();
        if ($this->request->is('post')) {
        	
        	$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
        	$this->request->data['endereco_mac'] = strtolower($this->request->data['endereco_mac']); 
        	
            $dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->data);
            
            //$dispositivo->situacao_id = 1;
            
            if ($this->Dispositivos->save($dispositivo)) {
            	
            	$this->Dispositivos->gerarArquivoDHCP();
            	
                $this->Flash->success(__('O registro de dispositivo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $dispositivo->id]);
            } else {
                $this->Flash->error(__('O registro de dispositivo não foi salvo. Por favor, tente novamente.'));
            }
        }

      
        
        $redes = $this->Dispositivos->Redes->find('list',['conditions'=>['ativo'=>true]]);
        $tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list');
        $internautas = $this->Dispositivos->Internautas->find('list');
        $situacoes = $this->Dispositivos->Situacoes->find('list');
        $this->set(compact('dispositivo', 'tipoDispositivos', 'internautas', 'situacoes','redes'));
        $this->set('_serialize', ['dispositivo']);
    }
    
    public function termo($id, $save_path=false){
    	$dispositivo = $this->Dispositivos->get($id, [
    			'contain' => ['TipoDispositivos','Internautas','Situacoes']
    			]);
    	//debug($dispositivo); exit;
    	$this->loadComponent('Base.Parametro');
    	$config = array(
    			'documento_titulo' => $this->Parametro->get('termo_wifi.titulo'),
    			'documento_corpo' =>  $this->Parametro->get('termo_wifi.corpo_documento', FALSE),
    	);
    	
    	$this->set('save_path', $save_path);
    	
    	$this->set('dispositivo', $dispositivo);
    	
    	$this->set('partes', $config);
    	
    	$partes = $config;

    	$pdf = new \fpdf\FPDF();
    	
    	$pdf->SetMargins(15,10,15);
    	$pdf->AddPage();
    	$pdf->SetFont('arial','B',12);
    	$pdf->Cell(0,5,utf8_decode($partes['documento_titulo']),0,1,'C');
    	
    	$pdf->Ln(10);
    	$pdf->SetFont('arial','',11);
    	
    	$corpo = $partes['documento_corpo'];
    	
    	$corpo = str_replace('%NOME%', $dispositivo->internauta->nome, $corpo);
    	$corpo = str_replace('%CPF%', $dispositivo->internauta->cpf, $corpo);
    	$corpo = str_replace('%NASCIMENTO%', $dispositivo->internauta->data_nascimento, $corpo);
    	$corpo = str_replace('%SETOR%', $dispositivo->internauta->setor, $corpo);
    	$corpo = str_replace('%EMAIL%', $dispositivo->internauta->email, $corpo);
    	$corpo = str_replace('%FONE%', $dispositivo->internauta->contato, $corpo);
    	$corpo = str_replace('%LOGIN%', $dispositivo->internauta->login, $corpo);
    	$corpo = str_replace('%DISPOSITIVO%', $dispositivo->tipo_dispositivo->descricao, $corpo);
    	$corpo = str_replace('%MAC%', $dispositivo->endereco_mac, $corpo);
    	$corpo = str_replace('%JUSTIFICATIVA%', $dispositivo->justificativa, $corpo);
    	$corpo = str_replace('%DATA%', $dispositivo->data_cadastro, $corpo);
    	$corpo = str_replace('%HOJE%', date('d/m/Y'), $corpo);
    	$corpo = str_replace('%ASSINATURA_USUARIO%', "Assinatura do usuário", $corpo);
    	$corpo = str_replace('%ASSINATURA_CHEFIA%', "Assinatura da chefia", $corpo);
    	
    	
    	$corpo = utf8_decode($corpo);
    	
    	$pdf->MultiCell(0, 6, $corpo,0,'J');
    	
    	$pdf->Ln(8);
    	
    	
    	$nome = explode(" ",$dispositivo->internauta->nome);
    	if($save_path){
    		$pdf->Output($save_path,"F");
    		// 	$pdf->Output(ROOT.DS.'tmp'.DS."Termo_Responsabilidade_".$nome[0]."_".date('dmYHis').".pdf","F");
    	}
    	else {
    		$pdf->Output("Termo_Responsabilidade_".$nome[0]."_".date('dmYHis').".pdf","D");
    	}
    	
    	
    	$this->response->type('pdf');
    	$this->viewBuilder()->layout('Base.pdf');
    	
    	
    	
    }
    
    public function cadastrar($id=null)
    {
    	
    	$internauta = $this->Dispositivos->Internautas->find()
    	->where(['login' =>$this->login['login'] ])
    	->first();
    	 
    	//debug($internauta);
    	
    	$tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list');
    	
    	if(!$internauta)  	{
    		$this->Flash->error(__('A atualização de seus dados pessoais é necessária.'));
    		return $this->redirect(['controller'=>'internautas','action' => 'meus-dados']);
    	}
    	
    	$dispositivo = $this->Dispositivos->newEntity();
    	if($id) {
    		$dispositivo = $this->Dispositivos->get($id, [
    			'contain' => []
    			]);
    	}
    	
    	if ($this->request->is('post')) {
    		$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
    		$this->request->data['situacao_id'] = 1;
    		$this->request->data['internauta_id'] = $internauta->id;
    		$this->request->data['endereco_mac'] = strtolower($this->request->data['endereco_mac']);
    		
    		$disps = $tipoDispositivos->toArray();
    		
    		$this->request->data['descricao'] = $disps[$this->request->data['tipo_dispositivo_id']] . '_' . $internauta->login;
    		
    		$dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->data);
    		
    		
    		if ($this->Dispositivos->save($dispositivo)) {
    			
    			$this->enviarEmail($dispositivo->id, false);
    			
    			
    			$this->Flash->success(__('O aparelho foi salvo com sucesso. Imprima o Termo de Resposabilidade.'));
    			
    			return $this->redirect(['controller'=>'internautas','action' => 'dados']);
    			
    		} else {
    			$this->Flash->error(__('O aparelho não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    	$tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list', ['conditions'=>['TipoDispositivos.ativo'=>true, 'TipoDispositivos.is_public'=>true]]);
    	//$internautas = $this->Dispositivos->Internautas->find('list');
    	//$situacoes = $this->Dispositivos->Situacoes->find('list');
    	$this->set(compact('dispositivo', 'tipoDispositivos'));
    	$this->set('_serialize', ['dispositivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dispositivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dispositivo = $this->Dispositivos->get($id, [
            'contain' => ['Internautas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	$this->request->data['endereco_mac'] = strtolower($this->request->data['endereco_mac']);
        	
            $dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->data);
            if ($this->Dispositivos->save($dispositivo)) {
            	
            	$this->Dispositivos->gerarArquivoDHCP();
            	
            	$email_ok = "";
            	if(isset($this->request->data['enviar_email'])){
            		 
            		$email_ok = $this->enviarEmail($id, false);
            		if($email_ok)
            			$email_ok = 'Email Enviado com sucesso';
            		else $email_ok = 'Erro ao enviar o e-mail';
            	}
            	
                $this->Flash->success(__('O registro de dispositivo foi salvo com sucesso. '. $email_ok));
                return $this->redirect(['action' => 'view', $dispositivo->id]);
            } else {
                $this->Flash->error(__('O registro de dispositivo não foi salvo. Por favor, tente novamente.'));
            }
        }
        // BUSCA A LISTA DE IPS DA REDE DO DISPOSITIVO.
        $ips = array();
//         debug($dispositivo->rede_id);
        if($dispositivo->rede_id) {
	        $ips = $this->Dispositivos->Redes->getIps($dispositivo->rede_id);
	        $ips[$dispositivo->endereco_ip] = $dispositivo->endereco_ip;
        }
        $this->set('ips', $ips);
        
        $redes = $this->Dispositivos->Redes->find('list',['conditions'=>['ativo'=>true]]);
        $tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list',['conditions'=>['TipoDispositivos.ativo'=>true]]);
        $internautas = $this->Dispositivos->Internautas->find('list');
        $situacoes = $this->Dispositivos->Situacoes->find('list');
        $this->set(compact('dispositivo', 'tipoDispositivos', 'internautas', 'situacoes', 'redes'));
        $this->set('_serialize', ['dispositivo']);
    }

    /**
     * Alterar method
     *
     * @param string|null $id Dispositivo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function alterar($id = null)
    {
    	$dispositivo = $this->Dispositivos->get($id, [
    			'contain' => []
    			]);
    	
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		
    		$dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->data);

    		if ($this->Dispositivos->save($dispositivo)) {
    			$this->Flash->success(__('O de dispositivo foi alterado com sucesso.'));
    			return $this->redirect(['controller'=>'internautas','action' => 'dados']);
    		} else {
    			$this->Flash->error(__('O dispositivo não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    	$tipoDispositivos = $this->Dispositivos->TipoDispositivos->find('list',['conditions'=>['TipoDispositivos.ativo'=>true, 'TipoDispositivos.is_public'=>true]]);
    	//$internautas = $this->Dispositivos->Internautas->find('list', ['limit' => 200]);
    	//$situacoes = $this->Dispositivos->Situacoes->find('list', ['limit' => 200]);
    	$this->set(compact('dispositivo', 'tipoDispositivos'));
    	$this->set('_serialize', ['dispositivo']);
    }
    
    // remocao logica apenas marca como removido.
    public function remover($id = null)
    {
    	$this->request->allowMethod(['post', 'delete']);
    	$dispositivo = $this->Dispositivos->get($id);
    	
    	$dispositivo->situacao_id =$this->REMOVIDO_ID; 
    	
    	if ($this->Dispositivos->save($dispositivo)) {
    		$this->Flash->success(__('O dispositivo foi removido com sucesso.'));
    	} else {
    		$this->Flash->error(__('O dispositivo não foi removido. Por favor, tente novamente.'));
    	}
    	return $this->redirect(['controller'=>'internautas','action' => 'dados']);
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Dispositivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dispositivo = $this->Dispositivos->get($id);
        if ($this->Dispositivos->delete($dispositivo)) {
            $this->Flash->success(__('O registro de dispositivo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de dispositivo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function enviarEmail($id, $redirect=true ){
    	
    	$dispositivo = $this->Dispositivos->get($id, [
            'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes']
        ]);
    	
    	$this->set('dispositivo', $dispositivo);
    	
    	
    	if($dispositivo->situacao->template_mail) { 
    	
    		$this->loadComponent('Base.Parametro');
    		$config = array(
    				'host' => $this->Parametro->get('wifi.smtp_host') , //'ssl://smtp.gmail.com',
    				'port' => $this->Parametro->get('wifi.smtp_port'), //465,
    				'username' => $this->Parametro->get('wifi.smtp_username'), //'censohu@nhu.ufms.br',
    				'password' => $this->Parametro->get('wifi.smtp_password'), //'hu123456789',
    				'className' => 'Smtp'
    		);
    		
    		$from = $this->Parametro->get('wifi.smtp_from');
    		$assunto = $dispositivo->situacao->assunto_mail; //$this->Parametro->get('wifi.smtp_subject');
    		
    		
    		//debug($config);
    		
    		$template = $dispositivo->situacao->template_mail; //$this->Parametro->get($template_id);
    		
    		$template = str_replace('%TIPO%',$dispositivo->tipo_dispositivo->descricao, $template );
    		
    		$template = str_replace('%NOME%',$dispositivo->internauta->nome, $template );
    		$template = str_replace('%MAC%',$dispositivo->endereco_mac, $template );
    		
    		$template = str_replace('%STATUS%',$dispositivo->situacao->descricao, $template );
    		$template = str_replace('%IP%',$dispositivo->endereco_ip, $template );
    		$template = str_replace('%VALIDADE%',substr($dispositivo->data_validade,0,10), $template );
    		$template = str_replace('%CADASTRO%',substr($dispositivo->data_cadastro,0,10), $template );
    		
    		//debug($template); exit;
    		try {
		    	Email::dropTransport('default');
		    	Email::configTransport('default', $config);
		    	$email = new Email();
		    	
		    	$email->from([$config['username'] =>$from]);
		    	$email->addTo($dispositivo->internauta->email, $dispositivo->internauta->nome);
		    	
		    	$email->emailFormat('html');
		    	
		    	if($dispositivo->situacao->anexar_termo){

		    		$save_path = ROOT.DS.'tmp'.DS."Termo_Responsabilidade_".$dispositivo->id.".pdf";
		    		 
		    		$this->termo($dispositivo->id, $save_path);
		    		
		    		$email->attachments([
			    			"Termo_Responsabilidade_$id.pdf" => [
			    			'file' => $save_path,
			    			'mimetype' => 'application/pdf',
				    			]
			    			]);
    			}

    			$email->subject($assunto);
		    	$email->send($template);
		    	
    		}
    		catch(Exception $e){
    			if($redirect){
	    			$this->Flash->error(__('Erro ao enviar o e-mail. Por favor, tente novamente.'));
	    			return $this->redirect(['action' => 'index']);
    			}
    			else { return false; /*'Erro ao enviar o e-mail. Por favor, tente novamente';*/ 
    			}
    		}
    		if($redirect){
	    		$this->Flash->success(__('E-mail enviado com sucesso.'));
	    		return $this->redirect(['action' => 'index']);
    		}
    		else{
    			 return true; //'E-mail enviado com sucesso.';
    		}
    	
    	} // fim do if existe template-mail
    	
   		if($redirect){
	    	$this->Flash->error(__('Não existe template/e-mail para envio'));
	    	return $this->redirect(['action' => 'index']);
    	}
    	else{
    		return false; //'E-mail enviado com sucesso.';
    	}
    }
    

    public function arquivo($gerar=0){
    	
    	if($gerar){
    		$this->Dispositivos->gerarArquivoDHCP();
    		return $this->redirect(['action' => 'arquivo']);
    	}
    	
    	$parametros = TableRegistry::get('Base.Parametros'); 
    	$arquivo = $parametros->findByChave('wifi.dhcp_arquivo_pasta')->first()->valor;
    	
    	$file = file_get_contents ($arquivo);
    	$this->set('file', $file);
    	$this->set('arquivo', $arquivo);
    		
    }
    
    
    public function processar() {
    	$file = file_get_contents (TMP.'dhcpd.conf');
    	
    	$linhas = explode("\n",$file);
    	
    	$redes = [];
    	$hosts = [];
    	$i=0;
    	$k=0;
    	foreach($linhas as $ln) {
    		
    		$registro = trim($ln);
    		$partes = explode(" ", $registro);
    		
    		if(!count($partes)) continue;
    		//debug($registro);
    		
    		$reg = $partes[0];
    		
    		if($reg=="subnet"){
    			echo "SUB";
    			$k++;
    			$redes[$k] = [];
    			$redes[$k]['name'] = str_replace('.','_',$partes[0]) . '_' . str_replace('.','_',$partes[1]). '_' . str_replace('.','_',$partes[3]);
    		}
    		if($reg=="host"){
    			$i++;
    			$hosts[$i] = [];
    			$hosts[$i]['rede_id'] = $k;
    			$hosts[$i]['rede_name'] = $redes[$k]['name'];
    			
    		}
    		if($reg=="hardware"){
    			$hosts[$i]['mac'] = str_replace(['"',';'],'',$partes[2]);
    		}
    		if($reg=="fixed-address"){
    			$hosts[$i]['ip'] = str_replace(['"',';'],'',$partes[1]);
    		}
    		if($reg=="option" && $partes[1]=="host-name"){
    			$hosts[$i]['desc'] = str_replace(['"',';'],'',$partes[2]);
    		}
    		
    	}
    	
    	foreach($redes as $rd){
    		$rede = $this->Dispositivos->Redes->newEntity();
    		$rede->nome = $rd['name'];
    		$rede->faixa_ip = '0.0.0.0/0';
    		$rede->conteudo = '{  }';
    		$rede->ativo = false;
    		
    		//debug($rede);
    		
    		//$this->Dispositivos->Redes->save($rede);
    		
    	}
    	$data_cad = date('d/m/Y H:i:s');
    	echo "TOTAL: " . debug(count($hosts));
    	
    	foreach($hosts as $host){
    		set_time_limit(0);
    		
    		
    		$rede = $this->Dispositivos->Redes->findByNome($host['rede_name'])->first();
    		
    		//debug($rede);
    		
    		$existe_mac = $this->Dispositivos->find('all', ['conditions'=>['Dispositivos.rede_id'=>$rede->id,'Dispositivos.endereco_mac'=>strtolower(trim($host['mac']))]])->count();
    		$existe_ip = $this->Dispositivos->find('all', ['conditions'=>['Dispositivos.endereco_ip'=>strtolower(trim($host['ip']))]])->count();
    		
    		//debug(strtolower(trim($host['ip'])));
    		if($existe_mac) { 
    			echo "EXISTE MAC:". $host['mac'].'<br/>';
    			continue;
    		}
    		
    		if($existe_ip) {
    			echo "EXISTE IP:". $host['ip'].'<br/>';
    			continue;
    		}
    		
    		$aparelho = $this->Dispositivos->newEntity();
    		
    		$aparelho->internauta_id = 590;
    		$aparelho->rede_id = $rede->id;
    		$aparelho->tipo_dispositivo_id = 9;
    		$aparelho->situacao_id = 3;
    		$aparelho->endereco_mac = $host['mac'];
    		$aparelho->endereco_ip = $host['ip'];
    		$aparelho->justificativa = 'IMPORTADO';	
    		$aparelho->descricao = $host['desc'];
    		$aparelho->data_cadastro = $data_cad;
    		
//     		if($host['mac']=="") {
//     			debug($aparelho);
//     		}
    		
    		if(!$this->Dispositivos->save($aparelho)){
    			echo "ERRO: " . $aparelho->endereco_mac . " - " .$aparelho->endereco_ip;
    			debug($aparelho);
    		}
    		
    	}
    	//debug($redes);
    	//debug($hosts);
    	exit;
    	
    	
    }
  
}
