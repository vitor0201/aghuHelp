<?php
namespace Wifi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Wifi\Model\Entity\Situacao;

/**
 * Situacoes Model
 *
 * @property \Cake\ORM\Association\HasMany $Dispositivos
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

        $this->table('wifi.situacoes');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->hasMany('Wifi.Dispositivos', [
            'foreignKey' => 'situacao_id',
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
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao','Campo obrigatório.');

        return $validator;
    }
}
