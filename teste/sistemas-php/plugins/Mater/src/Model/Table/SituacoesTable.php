<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Situacao;

/**
 * Situacoes Model
 *
 * @property \Cake\ORM\Association\HasMany $Agendamentos
 */
class SituacoesTable extends Table
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

        $this->table('mater.situacoes');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->hasMany('Agendamentos', [
            'foreignKey' => 'situacao_id',
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
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        return $validator;
    }
    public function buildRules(RulesChecker $rules)
    {
    
    	$rules->add($rules->isUnique(['descricao'],'Descrição já está cadastrada.'));
    
    	return $rules;
    }
}
