<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\CirurgiasProcedimento;

/**
 * CirurgiasProcedimentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Agendamentos
 * @property \Cake\ORM\Association\BelongsTo $Procedimentos
 * @property \Cake\ORM\Association\BelongsTo $Resultados
 */
class CirurgiasProcedimentosTable extends Table
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

        $this->table('mater.cirurgias_procedimentos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Agendamentos', [
            'foreignKey' => 'agendamento_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Agendamentos'
        ]);
        $this->belongsTo('Procedimentos', [
            'foreignKey' => 'procedimento_id',
            'joinType' => 'INNER',
            'className' => 'Mater.Procedimentos'
        ]);
        $this->belongsTo('Resultados', [
            'foreignKey' => 'resultado_id',
            'className' => 'Mater.Resultados'
        ]);
        
//         $this->belongsTo('Motivos', [
//         		'foreignKey' => 'motivo_id',
//         		'className' => 'Mater.Motivos'
//         ]);

        $this->belongsToMany('Motivos', [
        		'foreignKey' => 'cirurgias_procedimento_id',
        		'targetForeignKey' => 'motivo_id',
        		'joinTable' => 'mater.cirurgias_procedimentos_motivos',
        		'dependent' => true,
        		'className' => 'Mater.Motivos',
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
            ->allowEmpty('observacao');

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
    
        $rules->add($rules->existsIn(['procedimento_id'], 'Procedimentos'));
        $rules->add($rules->existsIn(['resultado_id'], 'Resultados'));
//         $rules->add($rules->existsIn(['motivo_id'], 'Motivos'));
        return $rules;
    }
}
