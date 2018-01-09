<?php
namespace Base\Model\Table;

use Base\Model\Entity\Cargo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cargo Model
 *
 * @property \Cake\ORM\Association\HasMany $Funcionario
 */
class CargosTable extends Table
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

        $this->table('public.cargos');
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
