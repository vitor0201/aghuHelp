<?php
namespace Sms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Sms\Model\Entity\Mensagem;

/**
 * Mensagens Model
 *
 */
class MensagensTable extends Table
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

        $this->table('mensagens');
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
            ->add('ddd', 'valid', ['rule' => 'numeric'])
            ->requirePresence('ddd', 'create')
            ->notEmpty('ddd','Campo obrigatório.');

        $validator
            ->requirePresence('fone', 'create')
            ->notEmpty('fone','Campo obrigatório.');

        $validator
            ->requirePresence('texto', 'create')
            ->notEmpty('texto','Campo obrigatório.');

        $validator
            ->requirePresence('data_hora', 'create')
            ->notEmpty('data_hora','Campo obrigatório.');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status','Campo obrigatório.');

        $validator
            ->requirePresence('login', 'create')
            ->notEmpty('login','Campo obrigatório.');
*/
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
        //$rules->add($rules->isUnique(['login']));
        return $rules;
    }
}
