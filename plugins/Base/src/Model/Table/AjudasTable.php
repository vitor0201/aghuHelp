<?php
namespace Base\Model\Table;

use Base\Model\Entity\Ajuda;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ajudas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentAjudas
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\HasMany $ChildAjudas
 */
class AjudasTable extends Table
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

        $this->table('base.ajudas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Tree');

        $this->belongsTo('Base.ParentAjudas', [
            'className' => 'Base.Ajudas',
            'foreignKey' => 'parent_id',
        	'joinTable' => 'base.ajudas'
        ]);
        $this->belongsTo('Base.Sistemas', [
            'foreignKey' => 'sistema_id',
            'joinType' => 'INNER',
        	'joinTable' => 'base.sistemas'
        ]);
        $this->hasMany('Base.ChildAjudas', [
            'className' => 'Base.Ajudas',
            'foreignKey' => 'parent_id',
        	'joinTable' => 'base.ajudas'
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
            ->requirePresence('conteudo', 'create')
            ->notEmpty('conteudo');

        $validator
            ->add('lft', 'valid', ['rule' => 'numeric'])
            ->requirePresence('lft', 'create')
            ->notEmpty('lft');

        $validator
            ->add('rght', 'valid', ['rule' => 'numeric'])
            ->requirePresence('rght', 'create')
            ->notEmpty('rght');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentAjudas'));
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));
        return $rules;
    }
}
