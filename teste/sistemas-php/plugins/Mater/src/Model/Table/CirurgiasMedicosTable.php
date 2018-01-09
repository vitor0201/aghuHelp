<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\CirurgiasMedico;

/**
 * CirurgiasMedicos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Medicos
 * @property \Cake\ORM\Association\BelongsTo $Agendamentos
 */
class CirurgiasMedicosTable extends Table
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

        $this->table('mater.cirurgias_medicos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Medicos', [
            'foreignKey' => 'medico_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Medicos'
        ]);
        $this->belongsTo('Agendamentos', [
            'foreignKey' => 'cirurgia_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Agendamentos'
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
        $rules->add($rules->existsIn(['cirurgia_id'], 'Agendamentos'));
        return $rules;
    }
}
