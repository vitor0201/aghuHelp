<?php
namespace Wifi\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

use Cake\I18n\Time;
use Cake\Database\Type;
use Adldap\Adldap;
use Adldap\Classes\Utilities;
use Adldap\Exceptions\AdldapException;
use Adldap\Exceptions\PasswordPolicyException;
use Adldap\Exceptions\WrongPasswordException;
use Adldap\Models\Traits\HasDescriptionTrait;
use Adldap\Models\Traits\HasLastLogonAndLogOffTrait;
use Adldap\Models\Traits\HasMemberOfTrait;
use Adldap\Objects\AccountControl;
use Adldap\Objects\BatchModification;
use Adldap\Schemas\ActiveDirectory;



Time::$defaultLocale = 'pt-BR';
Time::setToStringFormat('dd/MM/YYYY HH:mm:ss');
Type::build('datetime')->useLocaleParser();

class ExecShell extends Shell
{
	
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Wifi.Dispositivos');
		$this->loadModel('Base.Parametros');
		$this->loadModel('Wifi.Situacoes');
		
	}
	
	public function main()
	{
		set_time_limit(0);
		$this->out('Escolha um metodo');
	}
	
	public function desativar()
	{
		set_time_limit(0);
		$this->out('Buscando vencidos ativos...');
		$dispositivos = $this->Dispositivos->find('all',['contain'=>['Internautas'],'conditions'=>['Dispositivos.data_validade < CURRENT_TIMESTAMP','Dispositivos.situacao_id'=>3 ]]);
		$this->out('Encontrados: '.$dispositivos->count());
		
		foreach ($dispositivos as $aparelho) {
			$this->out('Iniciando envio de e-mail...');
			if($this->enviarEmailRemovido($aparelho->id))
				$this->out('OK! e-mail para: '. $aparelho->internauta->email );
			else
				$this->out('ERRO! e-mail para: '. $aparelho->internauta->email );
		}
		
		$total = $this->Dispositivos->updateAll(
				['situacao_id' => 4], // fields = situacao 4 REMOVIDO
				['data_validade < CURRENT_TIMESTAMP', 'situacao_id'=>3]) ; // conditions = vencidos

		$this->out('Total removido: '. $total);
		
		$this->desativarUser();
		
		$this->out('Finalizado!');
	}
	
	private function desativarUser(){
		$this->out('Configurando LDAP/AD...');
		
		$config = array(
		
				'account_suffix' => $this->Parametros->findByChave('admin.ldap.account_suffix')->first()->valor,
				'domain_controllers' => explode(",", $this->Parametros->findByChave('admin.ldap.domain_controllers')->first()->valor), // servers
				'base_dn' => $this->Parametros->findByChave('admin.ldap.base_dn')->first()->valor,
				'ad_port' => $this->Parametros->findByChave('admin.ldap.ad_port')->first()->valor,
				'user_id_key' => $this->Parametros->findByChave('admin.ldap.user_id_key')->first()->valor,
				'admin_username' => $this->Parametros->findByChave('admin.ldap.admin_username')->first()->valor,
				'admin_password' => $this->Parametros->findByChave('admin.ldap.admin_password')->first()->valor,
		);
		
		
		$user = new Adldap($config);
		$this->out('Conectado no LDAP/AD...');
		
		$dispositivos = $this->Dispositivos->find('all',['contain'=>['Internautas'],'conditions'=>['Dispositivos.situacao_id'=>3 ]]);
		$total = 0;
		foreach($dispositivos as $disp){
			$login = $disp->internauta->login;
			$login_ad =	$user->users()->find($login);
			
			$status_ad = $login_ad->getUserAccountControl();
			//$this->out('Aparelho: '.$disp->endereco_mac.', Usuario '.$login .": status ". $status_ad);
			
			if($status_ad & 2) { // 2 => status inativo
				// esta inativo
				$aparaelho = $disp;
				$aparaelho->situacao_id = 4; // muda para inativo
				$this->out('Inativando aparelho: '.$disp->endereco_mac.', Usuario '.$login );
				$this->Dispositivos->save($aparaelho);
				$total++;
				
			}
		}
		$this->out('Total removido por AD/Status: '.$total);
		$this->out('Fim da verificadao de status no AD');
		
	}
	public function arquivoDhcp()
	{
		set_time_limit(0);
		$this->out('Gerando arquivo DHCP');
 		$this->Dispositivos->gerarArquivoDHCP();
 		$this->out('Arquivo DHCP gerado.');
	}
	
	// envia e-mail para informando que os aparelhos foram removidos.
	private function enviarEmailRemovido($id) {
		
		set_time_limit(0);
	
		$dispositivo = $this->Dispositivos->get($id, [
				'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes']
				]);
		 
		$situacao = $this->Situacoes->get(4); // 4 = REMOVIDO;
			
		$config = array(
				'host' => $this->Parametros->findByChave('wifi.smtp_host')->first()->valor, //'ssl://smtp.gmail.com',
				'port' => $this->Parametros->findByChave('wifi.smtp_port')->first()->valor, //465,
				'username' => $this->Parametros->findByChave('wifi.smtp_username')->first()->valor, //'censohu@nhu.ufms.br',
				'password' => $this->Parametros->findByChave('wifi.smtp_password')->first()->valor, //'hu123456789',
				'className' => 'Smtp'
		);
	
		$from = $this->Parametros->findByChave('wifi.smtp_from')->first()->valor;
		$assunto = $situacao->assunto_mail; //$this->Parametro->get('wifi.smtp_subject');
	
	
		//debug($config);
	
		$template = $situacao->template_mail; //$this->Parametro->get($template_id);
	
		$template = str_replace('%TIPO%',$dispositivo->tipo_dispositivo->descricao, $template );
	
		$template = str_replace('%NOME%',$dispositivo->internauta->nome, $template );
		$template = str_replace('%MAC%',$dispositivo->endereco_mac, $template );
	
		$template = str_replace('%STATUS%',$situacao->descricao, $template );
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
		
			$email->subject($assunto);
			$email->send($template);
			 
		}
		catch(Exception $e){
			return false;
		}
		return true;
	}
	
}