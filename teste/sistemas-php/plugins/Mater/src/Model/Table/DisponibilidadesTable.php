<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Disponibilidade;

/**
 * Disponibilidades Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Medicos
 * @property \Cake\ORM\Association\BelongsTo $Periodos
 */
class DisponibilidadesTable extends Table
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

        $this->table('mater.disponibilidades');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Medicos', [
            'foreignKey' => 'medico_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Medicos'
        ]);
        $this->belongsTo('Periodos', [
            'foreignKey' => 'periodo_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Periodos'
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
            ->add('dia_semana', 'valid', ['rule' => 'numeric'])
            ->requirePresence('dia_semana', 'create')
            ->notEmpty('dia_semana','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

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
        $rules->add($rules->existsIn(['periodo_id'], 'Periodos'));
        return $rules;
    }
}
