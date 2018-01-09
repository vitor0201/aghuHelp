<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Bloqueio;

/**
 * Bloqueios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Medicos
 */
class BloqueiosTable extends Table
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

        $this->table('mater.bloqueios');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Medicos', [
            'foreignKey' => 'medico_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Medicos'
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
//             ->add('data', 'valid', ['rule' => 'date'])
            ->requirePresence('data', 'create')
            ->notEmpty('data','Campo obrigatório.');

        $validator
            ->allowEmpty('justificativa');

        $validator
            ->requirePresence('usuario_cadastro', 'create')
            ->notEmpty('usuario_cadastro','Campo obrigatório.');

        $validator
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro','Campo obrigatório.');
        
        $validator
        ->requirePresence('medico_id', 'create')
        ->notEmpty('medico_id','Campo obrigatório.');

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
        $rules->add($rules->existsIn(['medico_id'], 'Medicos'));
        $rules->add($rules->isUnique(['data','medico_id'],'Data já cadastrada.'));
        return $rules;
    }
}
