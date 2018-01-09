<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Vaga;

/**
 * Vagas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Salas
 * @property \Cake\ORM\Association\HasMany $Agendamentos
 */
class VagasTable extends Table
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

        $this->table('mater.vagas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Salas', [
            'foreignKey' => 'sala_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Salas'
        ]);
        $this->hasMany('Agendamentos', [
            'foreignKey' => 'vaga_id',
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

        $validator
//             ->add('data', 'valid', ['rule' => 'date'])
            ->requirePresence('data', 'create')
            ->notEmpty('data','Campo obrigatório.');

        $validator
//             ->add('horario', 'valid', ['rule' => 'time'])
            ->requirePresence('horario', 'create')
            ->notEmpty('horario','Campo obrigatório.');

        $validator
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro','Campo obrigatório.');

        $validator
            ->requirePresence('usuario_cadastro', 'create')
            ->notEmpty('usuario_cadastro','Campo obrigatório.');

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
        $rules->add($rules->existsIn(['sala_id'], 'Salas'));
        $rules->add($rules->isUnique(['sala_id','horario','data'],'Data/Hora já cadastrada.'));
        return $rules;
    }
}
