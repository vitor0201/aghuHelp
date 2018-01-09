<?php
namespace Base\Model\Table;

use Base\Model\Entity\Usuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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

/**
 * Usuarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\BelongsToMany $Grupos
 */
class UsuariosTable extends Table
{
	
	public $ldapAd = null;
	public $ldapAdError = "";
	
	private $parametroComponent;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('base.usuarios');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Base.Sistemas', [
            'foreignKey' => 'sistema_id',
            'joinType' => 'INNER',
        	'joinTable' => 'base.sistemas'
        ]);
        $this->belongsToMany('Base.Grupos', [
        		
            'foreignKey' => 'usuario_id',
            'targetForeignKey' => 'grupo_id',
            'joinTable' => 'base.usuarios_grupos'
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
            ->notEmpty('nome');

        $validator
            ->requirePresence('login', 'create')
            ->notEmpty('login');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo');

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
    	
        $rules->add($rules->isUnique(['login','sistema_id'],'Este login já encontra-se em uso.'));   
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));
        return $rules;
    }
    
    public function connectLDAP($parametroComponent){
    	
    	$config = array(
    			'account_suffix' => $parametroComponent->get('admin.ldap.account_suffix'),
    			'domain_controllers' => explode(",", $parametroComponent->get('admin.ldap.domain_controllers')), // servers
    			'base_dn' => $parametroComponent->get('admin.ldap.base_dn'),
    			'ad_port' => $parametroComponent->get('admin.ldap.ad_port'),
    			'user_id_key' => $parametroComponent->get('admin.ldap.user_id_key'),
    			'admin_username' => $parametroComponent->get('admin.ldap.admin_username'),
    			'admin_password' => $parametroComponent->get('admin.ldap.admin_password', FALSE),
    	);
    	//debug($config);
    	try {
    		$this->ldapAd = new Adldap($config);
    		
    	}
    	catch(AdldapException $e) {
			// nothing ...?   
			//debug($e); 		
			$this->ldapAdError = $e->getMessage();
    	}
    	
    	return $this->ldapAd;
    }
    
    
}
