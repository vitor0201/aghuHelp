<?php
namespace Base\Model\Table;

use Base\Model\Entity\Menu;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\HasMany $ChildMenus
 */
class MenusTable extends Table
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

        $this->table('base.menus');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->addBehavior('Tree');

        $this->belongsTo('Base.ParentMenus', [
            'className' => 'Base.Menus',
            'foreignKey' => 'parent_id',
        	'joinTable' => 'base.menus'
        ]); 
        $this->belongsTo('Base.Sistemas', [
            'foreignKey' => 'sistema_id',
            'joinType' => 'INNER',
        	'joinTable' => 'base.sistemas'
        ]);
        $this->belongsTo('Base.Acoes', [
        		'foreignKey' => 'acao_id',
        		'joinType' => 'LEFT',
        		'joinTable' => 'base.acoes'
        ]);
        
        $this->hasMany('Base.ChildMenus', [
            'className' => 'Base.Menus',
            'foreignKey' => 'parent_id',
        	'joinTable' => 'base.menus'
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
            ->allowEmpty('prefix');

        $validator
        ->requirePresence('descricao', 'create')
        ->notEmpty('descricao');
        
        $validator
            ->allowEmpty('controller');

        $validator
            ->allowEmpty('controller');
        
        

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo');

        /*$validator
            ->add('lft', 'valid', ['rule' => 'numeric'])
            ->requirePresence('lft', 'create')
            ->notEmpty('lft');

        $validator
            ->add('rght', 'valid', ['rule' => 'numeric'])
            ->requirePresence('rght', 'create')
            ->notEmpty('rght');
            */

       // $validator
       //     ->add('parent_id', 'valid', ['rule' => 'numeric']);
           // ->requirePresence('parent_id', 'create')
           // ->notEmpty('parent_id');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));
        return $rules;
    }
}
