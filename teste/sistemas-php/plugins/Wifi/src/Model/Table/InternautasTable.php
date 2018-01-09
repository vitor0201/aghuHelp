<?php
namespace Wifi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Wifi\Model\Entity\Internauta;

/**
 * Internautas Model
 *
 * @property \Cake\ORM\Association\HasMany $Dispositivos
 */
class InternautasTable extends Table
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

        $this->table('wifi.internautas');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->hasMany('Wifi.Dispositivos', [
        		'dependent' => true,
        		'cascadeCallbacks' => true,
            'foreignKey' => 'internauta_id',
            'className' => 'Wifi.Dispositivos'
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
            ->notEmpty('nome','Campo obrigatório.');

        $validator
            ->requirePresence('cpf', 'create')
            ->notEmpty('cpf','Campo obrigatório.');

       /* $validator
            ->add('data_nascimento', 'valid', ['rule' => 'date'])
            ->requirePresence('data_nascimento', 'create')
            ->notEmpty('data_nascimento','Campo obrigatório.');
*/
        $validator
            ->requirePresence('setor', 'create')
            ->notEmpty('setor','Campo obrigatório.');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email','Campo obrigatório.');

        $validator
            ->requirePresence('contato', 'create')
            ->notEmpty('contato','Campo obrigatório.');

        $validator
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro','Campo obrigatório.');

        $validator
            ->requirePresence('data_atualizacao', 'create')
            ->notEmpty('data_atualizacao','Campo obrigatório.');

        $validator
            ->requirePresence('login', 'create')
            ->notEmpty('login','Campo obrigatório.');

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
        $rules->add($rules->isUnique(['email'], 'Este e-mail já encontra-se em uso.'));
        $rules->add($rules->isUnique(['cpf'], 'Este CPF já encontra-se em uso.'));
        $rules->add($rules->isUnique(['login'], 'Este login já encontra-se em uso.'));
        return $rules;
    }
}
