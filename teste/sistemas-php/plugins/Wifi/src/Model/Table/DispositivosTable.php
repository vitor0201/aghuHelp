<?php
namespace Wifi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Wifi\Model\Entity\Dispositivo;
use Cake\ORM\TableRegistry;


/**
 * Dispositivos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoDispositivos
 * @property \Cake\ORM\Association\BelongsTo $Internautas
 * @property \Cake\ORM\Association\BelongsTo $Situacoes
 */
class DispositivosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
    	
    	$this->addBehavior('Timestamp');
    	
    	
        parent::initialize($config);

        
        
        
        $this->table('wifi.dispositivos');
        $this->displayField('mac');
        $this->primaryKey('id');

        $this->belongsTo('Wifi.TipoDispositivos', [
            'foreignKey' => 'tipo_dispositivo_id',
            'joinType' => 'INNER',
            'className' => 'Wifi.TipoDispositivos'
        ]);
        $this->belongsTo('Wifi.Internautas', [
            'foreignKey' => 'internauta_id',
            'joinType' => 'INNER',
            'className' => 'Wifi.Internautas'
        ]);
        $this->belongsTo('Wifi.Situacoes', [
            'foreignKey' => 'situacao_id',
            'joinType' => 'INNER',
            'className' => 'Wifi.Situacoes'
        ]);
        $this->belongsTo('Wifi.Redes', [
        		'foreignKey' => 'rede_id',
        		'joinType' => 'LEFT',
        		'className' => 'Wifi.Redes'
        		]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('endereco_mac', 'create')
            ->notEmpty('endereco_mac','Campo obrigatório.');

        $validator
        ->add('endereco_mac', 'validMAc',[
        		'rule' => array('custom', '/([a-fA-F0-9]{2}[:|\-]?){6}/'),
        		'message' => 'Endereço MAC inválido.'
        ]);
        
        
        // Nao pode duplicar o mesmo MAC em uma determinada rede.
        // Em redes diferentes pode.
        // Se o mac nao estiver associado a rede nenhuma tbm deixa duplicar
        // Se o aparelho estiver com status "Removido" pode duplicar pq ele não vai para o arquivo dhcp
        $validator
        ->add('endereco_mac', 'validUniqueMAC', [
        		'rule' =>
        		function($value, $context) {

        			$REMOVIDO_ID = \Wifi\Model\Entity\Situacao::$REMOVIDO_ID;
        			
        			$rede_id = isset($context['data']['rede_id']) ? $context['data']['rede_id'] : "IS NULL";
        			
        			//debug($this->find('all', ['conditions'=>['Dispositivos.endereco_mac'=>$value,'Dispositivos.rede_id'=>$rede_id, 'Dispositivos.situacao_id <>'=>$REMOVIDO_ID]])->count()); exit;
        			
        			if($context['newRecord'])
        				return $this->find('all', ['conditions'=>['Dispositivos.endereco_mac'=>$value,'Dispositivos.rede_id'=>$rede_id, 'Dispositivos.situacao_id <>'=>$REMOVIDO_ID]])->count()==0;
        			else
        				return $this->find('all', ['conditions'=>['Dispositivos.endereco_mac'=>$value,'Dispositivos.rede_id'=>$rede_id, 'Dispositivos.situacao_id <>'=>$REMOVIDO_ID, 'Dispositivos.id <>'=>$context['data']['id']]])->count()==0;
        			 
        		},
        		'message' => 'Já existe este MAC na rede escolhida.'
        				]);
        
        
        $validator
            ->requirePresence('justificativa', 'create')
            ->notEmpty('justificativa','Campo obrigatório.');

        $validator
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro','Campo obrigatório.');
        
        $validator
        ->requirePresence('internauta_id', 'create')
        ->notEmpty('internauta_id','Campo obrigatório.');

        
        $validator
        ->add('endereco_ip', 'validUnique', [
        		'rule' =>
        		function($value, $context) {
        			
        			
        			
        			$ativo_id = \Wifi\Model\Entity\Situacao::$ATIVO_ID;
        			
        			
        			
        			if($context['newRecord']){  // se for insert: verifica se ja existe um dispositivo ativo com o mesmo ip
        			
        				return $this->find('all', ['conditions'=>['Dispositivos.endereco_ip'=>$value, 'Dispositivos.situacao_id'=>$ativo_id]])->count()==0;
        			}
        			else { // se for update verifica se existe um dispositivo ativo com o mesmo ip ignorando o proprio que se quer alterar.
        				return $this->find('all', ['conditions'=>['Dispositivos.endereco_ip'=>$value, 'Dispositivos.situacao_id'=>$ativo_id, 'Dispositivos.id <>'=>$context['data']['id']]])->count()==0;
        			}
        			
        		},
        		'message' => 'Já existe um dispositivo ativo com este IP.'
        ]);
        
        
        $validator
        ->add('tipo_dispositivo_id', 'validLimite', [
        		'rule' =>
        		function($value, $context) {
        			 
        			$REMOVIDO_ID = \Wifi\Model\Entity\Situacao::$REMOVIDO_ID;
        			
        			//debug($context); exit;
        			 
        			if($context['newRecord']==true){
        				
        				$internauta = $this->Internautas->get($context['data']['internauta_id']);
        				
        				$limite = $internauta->quantidade_dispositivos;
        				
        				
        				return ( $dispositivos = $this->find('all', ['conditions'=>['Dispositivos.situacao_id <>'=>$REMOVIDO_ID,'Dispositivos.internauta_id'=>$context['data']['internauta_id']]])->count() < $limite );
        				
        				
        			}
        			
        			return true;
        			 
        		},
        		'message' => '[Erro!] Limite de cadastro atingido.'
        ]);
        
      
        
        $validator
        ->add('endereco_ip', 'valid', ['rule' => 'ip', 'message' => 'Por favor, introduza um IP válido.'])
        ->allowEmpty('endereco_ip');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tipo_dispositivo_id'], 'TipoDispositivos'));
        $rules->add($rules->existsIn(['internauta_id'], 'Internautas'));
        $rules->add($rules->existsIn(['situacao_id'], 'Situacoes'));
        return $rules;
    }
    
    public function gerarArquivoDHCP(){
    	
    	$parametros = TableRegistry::get('Base.Parametros');
    	
    	$arquivo = $parametros->findByChave('wifi.dhcp_arquivo_pasta')->first()->valor;
    	$template = $parametros->findByChave('wifi.dhcp_arquivo')->first()->valor;
    	
    	if(!$arquivo || !$template) return;
    	
    	$dispositivos_ativos =
    	$this->find('all', ['order'=>'Redes.nome','conditions'=> ['Dispositivos.situacao_id'=>3]  ,'contain' => ['TipoDispositivos', 'Internautas', 'Situacoes', 'Redes']   ]);
    	 
    	$hosts = "";
    	$interface = "";
    	$rede_id = "";
    	$i=0;
    	$k=0;
    	$names = [];
    	
    	$vet_redes = [];
    	$vet_hosts = [];
    	
    	foreach($dispositivos_ativos as $dispositivo){
    		
    		if(!$dispositivo->rede->nome) continue;
    		
    		if(!$dispositivo->rede->ativo) continue;
    		
    		$vet_redes[$dispositivo->rede->nome] = $dispositivo->rede->conteudo;
    		$interface = $dispositivo->rede->nome;
    		
    		$template_host =
'	host %interface%_%sequencia% {
		hardware ethernet %mac%;
		option dhcp-client-identifier "%nome%";
		fixed-address %ip%;
		option host-name "%nome%";
	}
';
    	
    		$desc = $dispositivo->descricao ? $dispositivo->descricao : $dispositivo->tipo_dispositivo->descricao.'_'.$dispositivo->internauta->login;
    		
    		$desc = str_replace([',','.',':',';','?','!','@','#','$','%','&','*','(',')','_','-','=','+','\\','/','?','[',']','{','}','"',"'",'|',' '], ' ', $desc);
    		$desc = str_replace(' ', '_', $desc);
    		
    		if(in_array($desc, $names)){  // previne nomes duplicados acrescentando $k ao final.
    			$desc .= $k++;
    		}
    		$names[] = $desc;
    		
    		$template_host = str_replace('%interface%', $interface, $template_host);
    		$template_host = str_replace('%sequencia%', $i, $template_host);
    		$template_host = str_replace('%mac%', $dispositivo->endereco_mac, $template_host);
    		$template_host = str_replace('%ip%', $dispositivo->endereco_ip  , $template_host);
    		$template_host = str_replace('%nome%', $desc , $template_host);
    	
    		$i++;
    		
    		$vet_hosts[$dispositivo->rede->nome][] = $template_host;

    	}
    	
    	$result = "";
    	foreach($vet_redes as $nome  => $rede) {
    		
    		$hosts = "";
    		foreach($vet_hosts[$nome] as $host){
    			$hosts .= $host;
    		}
    		$result .= str_replace('%HOSTS%',$hosts,$rede);
    	}
    	
    	$template = str_replace('%HOSTS%', $result, $template);
    	unlink($arquivo);
    	file_put_contents($arquivo, $template);
    }
}
