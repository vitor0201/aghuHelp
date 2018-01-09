<?php
namespace Base\Model\Table;

use Base\Model\Entity\Parametro;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parametros Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\BelongsToMany $Grupos
 */
class ParametrosTable extends Table
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

        $this->table('base.parametros');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->belongsTo('Base.Sistemas', [
            'foreignKey' => 'sistema_id',
            'joinType' => 'INNER',
        	'joinTable' => 'base.sistemas'
        ]);
        $this->belongsToMany('Grupos', [
        		'className' => 'Base.Grupos',
            'foreignKey' => 'parametro_id',
            'targetForeignKey' => 'grupo_id',
            'joinTable' => 'base.parametros_grupos',
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
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->requirePresence('chave', 'create')
            ->notEmpty('chave');

        $validator
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

        $validator
            ->requirePresence('tipo', 'create')
            ->notEmpty('tipo');

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
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));
        return $rules;
    }
}
