<?php
namespace Sms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Sms\Model\Entity\Recebida;

/**
 * Recebidas Model
 *
 */
class RecebidasTable extends Table
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

        $this->table('recebidas');
        $this->displayField('id');
        $this->primaryKey('id');

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
/*
        $validator
            ->requirePresence('fone', 'create')
            ->notEmpty('fone','Campo obrigatório.');

        $validator
            ->requirePresence('texto', 'create')
            ->notEmpty('texto','Campo obrigatório.');

        $validator
            ->requirePresence('data_hora', 'create')
            ->notEmpty('data_hora','Campo obrigatório.');
*/
        return $validator;
    }
}
