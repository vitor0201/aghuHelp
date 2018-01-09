<?php
namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\TipoPendencia;

/**
 * TipoPendencias Model
 */
class TipoPendenciasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config
     *            The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->table('kanban.tipo_pendencias');
        $this->displayField('id');
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator
     *            Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->add('id', 'valid', [
            'rule' => 'numeric'
        ])->allowEmpty('id', 'create');
        
        $validator->requirePresence('descricao', 'create')->notEmpty('descricao', 'Campo obrigatório.');
        
        $validator->add('ativo', 'valid', [
            'rule' => 'boolean'
        ])->notEmpty('ativo', 'Campo Obrigatório');
        
        return $validator;
    }
}
