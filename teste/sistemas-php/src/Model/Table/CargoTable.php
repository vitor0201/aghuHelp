<?php
namespace App\Model\Table;

use App\Model\Entity\Cargo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cargo Model
 *
 * @property \Cake\ORM\Association\HasMany $Funcionario
 */
class CargoTable extends Table
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

        $this->table('cargo');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Funcionario', [
            'foreignKey' => 'cargo_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('cargo_descricao');

        $validator
            ->allowEmpty('cargo_codigo');

        $validator
            ->allowEmpty('cargo_observacao');

        return $validator;
    }
}
