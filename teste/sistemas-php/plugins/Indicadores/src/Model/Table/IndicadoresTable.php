<?php
namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\Indicador;

/**
 * Indicadores Model
 *
 * @property \Cake\ORM\Association\HasMany $Configuracao
 */
class IndicadoresTable extends Table
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

        $this->table('kanban.indicadores');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Configuracao', [
            'foreignKey' => 'indicador_id',
            'className' => 'Indicadores.Configuracao'
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

        return $validator;
    }
}
