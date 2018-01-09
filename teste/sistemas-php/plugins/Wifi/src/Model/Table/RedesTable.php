<?php
namespace Wifi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Wifi\Model\Entity\Rede;
use Cake\ORM\TableRegistry;	
/**
 * Redes Model
 *
 */
class RedesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('wifi.redes');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->hasMany('Wifi.Dispositivos', [
        		'foreignKey' => 'rede_id',
        		'className' => 'Wifi.Dispositivos'
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
            ->requirePresence('nome', 'create')
            ->notEmpty('nome','Campo obrigatório.');

        $validator
            ->requirePresence('faixa_ip', 'create')
            ->notEmpty('faixa_ip','Campo obrigatório.');

        $validator
            ->requirePresence('conteudo', 'create')
            ->notEmpty('conteudo','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
    	$rules->add($rules->isUnique(['nome'], 'Este nome já está em uso.'));
    	
    	return $rules;
    }
    
    //$range  = "194.8.42.0/24";
    private function ipListFromRange($range){
    	$parts = explode('/',$range);
    	$exponent = 32-$parts[1].'-';
    	$count = pow(2,$exponent);
    	$start = ip2long($parts[0]);
    	$end = $start+$count;
    	return array_map('long2ip', range($start, $end) );
    }
    
    
    public function getIps($id){
    	//debug($this->request->data);
    
    	$rede = $this->get($id);
    	$range = $rede->faixa_ip;
    	$dispositivos = TableRegistry::get('Wifi.Dispositivos');
    	 
    	$ips_ativos = $dispositivos->find('list', ['conditions'=> ['Dispositivos.situacao_id'=>3], 'keyField' => 'id', 'valueField' => 'endereco_ip'  ]);
    	$ips_ativos = $ips_ativos->toArray();
    	 
    	//debug($range);
    	 
    	// processa os ips possiveis dentro da subnet
    	$ips =  $this->ipListFromRange($range);
    	 
    	//debug($ips);
    	$return = array();
    	 
    	foreach($ips as $ip) {
    		 
    		if(in_array($ip,$ips_ativos ))	continue;
    		 
    		$tmp_ip = explode('.',$ip);
    		$final = $tmp_ip[3];
    		 
    		if($final < 10 || $final > 250) continue;
    		 
    		$return[$ip] = $ip;
    	}
    	
    	return $return;
    }
}
