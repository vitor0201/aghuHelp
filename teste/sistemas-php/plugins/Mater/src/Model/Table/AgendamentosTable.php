<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Agendamento;

/**
 * Agendamentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Periodos
 * @property \Cake\ORM\Association\BelongsTo $Situacoes
 * @property \Cake\ORM\Association\BelongsTo $Salas
 */
class AgendamentosTable extends Table
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

        $this->table('mater.agendamentos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Situacoes', [
            'foreignKey' => 'situacao_id',
            'joinType' => 'LEFT',
            'className' => 'Mater.Situacoes'
        ]);
        $this->belongsTo('Salas', [
            'foreignKey' => 'sala_id',
            'joinType' => 'LEFT',
            'className' => 'Mater.Salas'
        ]);
        
        $this->belongsTo('Preceptor', [
        		'foreignKey' => 'medico_id',
        		'joinType' => 'LEFT',
        		'className' => 'Mater.Medicos'
        		]);
        
        $this->belongsTo('Solicitante', [
        		'foreignKey' => 'solicitante_id',
        		'joinType' => 'LEFT',
        		'className' => 'Mater.Medicos'
        ]);
        
      	$this->belongsToMany('Medicos', [
            'foreignKey' => 'agendamento_id',
            'targetForeignKey' => 'medico_id',
            'joinTable' => 'mater.cirurgias_medicos',
        	'dependent' => true,
      		'className' => 'Mater.Medicos',
      		
        ]);
        
        $this->hasMany('CirurgiasProcedimentos', [
        		'foreignKey' => 'agendamento_id',
        		'className' => 'Mater.CirurgiasProcedimentos',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
        		'saveStrategy' => 'replace'
        		
        ]);
        
       $this->belongsTo('Vagas', [
        		'foreignKey' => 'vaga_id',
        		'joinType' => 'LEFT',
        		'className' => 'Mater.Vagas'
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
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro','Campo obrigatório.');

//         $validator
//             ->add('data', 'valid', ['rule' => 'date'])
//             ->requirePresence('data', 'create')
//             ->notEmpty('data','Campo obrigatório.');
        $validator
        ->requirePresence('data', 'create')
        ->notEmpty('paciente_nome','Campo obrigatório.');
    
        $validator
        ->requirePresence('horario', 'create')
        ->notEmpty('paciente_nome','Campo obrigatório.');
        
        $validator
        ->requirePresence('aih', 'create')
        ->notEmpty('aih','Campo obrigatório.');
        
        $validator
        ->requirePresence('caso_clinico', 'create')
        ->notEmpty('caso_clinico','Campo obrigatório.');
        
       

//         $validator
//             ->add('horario', 'valid', ['rule' => 'time'])
//             ->allowEmpty('horario');

        $validator
            ->add('duracao', 'valid', ['rule' => 'time'])
            ->requirePresence('duracao', 'create')
            ->notEmpty('duracao','Campo obrigatório.');

        $validator
            ->requirePresence('paciente_prontuario', 'create')
            ->notEmpty('paciente_prontuario','Campo obrigatório.');

        $validator
            ->requirePresence('paciente_nome', 'create')
            ->notEmpty('paciente_nome','Campo obrigatório.');

//         $validator
//             ->requirePresence('paciente_fone1', 'create')
//             ->notEmpty('paciente_fone1','Campo obrigatório.');

//         $validator
//             ->requirePresence('paciente_fone2', 'create')
//             ->notEmpty('paciente_fone2','Campo obrigatório.');

//         $validator
//             ->requirePresence('paciente_nascimento', 'create')
//             ->notEmpty('paciente_nascimento','Campo obrigatório.');

//         $validator
//             ->requirePresence('aih', 'create')
//             ->notEmpty('aih','Campo obrigatório.');

//         $validator
//             ->requirePresence('observacao', 'create')
//             ->notEmpty('observacao','Campo obrigatório.');

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
        $rules->add($rules->existsIn(['situacao_id'], 'Situacoes'));
        $rules->add($rules->existsIn(['sala_id'], 'Salas'));
        return $rules;
    }
}
