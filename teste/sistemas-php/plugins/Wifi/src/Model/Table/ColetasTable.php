<?php
namespace Wifi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Wifi\Model\Entity\Coleta;

/**
 * Coletas Model
 *
 */
class ColetasTable extends Table
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

        $this->table('coletas');
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

        $validator
            ->allowEmpty('codigo');

        $validator
            ->allowEmpty('descricao');

        /*
        $validator
            ->add('validate', 'valid', ['rule' => 'date'])
            ->requirePresence('validate', 'create')
            ->notEmpty('validate','Campo obrigatório.');
*/
        $validator
            ->allowEmpty('lote');

        $validator
            ->add('quantidade', 'valid', ['rule' => 'decimal'])
            ->requirePresence('quantidade', 'create')
            ->notEmpty('quantidade','Campo obrigatório.');

        return $validator;
    }
}
