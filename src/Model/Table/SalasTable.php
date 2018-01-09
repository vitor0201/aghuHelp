<?php
namespace App\Model\Table;

use App\Model\Entity\Sala;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Salas Model
 *
 * @property \Cake\ORM\Association\HasMany $Agendamentos
 */
class SalasTable extends Table
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

        $this->table('salas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Agendamentos', [
            'foreignKey' => 'sala_id'
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
            ->notEmpty('descricao','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        return $validator;
    }
}
