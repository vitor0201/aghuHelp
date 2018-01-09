<?php
namespace Base\Model\Table;

use Base\Model\Entity\Sistema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sistemas Model
 *
 * @property \Cake\ORM\Association\HasMany $Acoes
 * @property \Cake\ORM\Association\HasMany $Ajudas
 * @property \Cake\ORM\Association\HasMany $Grupos
 * @property \Cake\ORM\Association\HasMany $Menus
 * @property \Cake\ORM\Association\HasMany $Parametros
 * @property \Cake\ORM\Association\HasMany $Usuarios
 */
class SistemasTable extends Table
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

        $this->table('base.sistemas');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->hasMany('Base.Grupos', [
        		'className' => 'Base.Grupos',
        		'foreignKey' => 'sistema_id',
        		'bindingKey'=>true,
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.grupos'
        ]);
        
        $this->hasMany('Base.Acoes', [
            	'foreignKey' => 'sistema_id',
        		'className' => 'Base.Acoes',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.acoes'
        ]);
        $this->hasMany('Base.Ajudas', [
        		'className' => 'Base.Ajudas',
            'foreignKey' => 'sistema_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.ajudas'
        ]);
       
        $this->hasMany('Base.Menus', [
        		'className' => 'Base.Menus',
            'foreignKey' => 'sistema_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.menus'
        ]);
        $this->hasMany('Base.Parametros', [
        		'className' => 'Base.Parametros',
            'foreignKey' => 'sistema_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.parametros'
        ]);
        $this->hasMany('Base.Usuarios', [
        		'className' => 'Base.Usuarios',
            'foreignKey' => 'sistema_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'joinTable' => 'base.usuarios'
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
            ->notEmpty('nome', 'Campo obrigatório');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo', 'Campo obrigatório');

        $validator
            ->add('criado_em', 'valid', ['rule' => ['date', 'dmy']])
            ->requirePresence('criado_em', 'create')
            ->notEmpty('criado_em', 'Campo obrigatório');

    
        return $validator;
    }
}
