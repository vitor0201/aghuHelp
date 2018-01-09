<?php
namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\Pendencia;

/**
 * Pendencias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoPendencias
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $RemocaoUsuarios
 */
class PendenciasTable extends Table
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
        
        $this->table('kanban.pendencias');
        $this->displayField('id');
        $this->primaryKey('id');
        
        $this->belongsTo('TipoPendencias', [
            'foreignKey' => 'tipo_pendencia_id',
            'className' => 'Indicadores.TipoPendencias'
        ]);

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
        ], 'Usuario incorreto')
        ->allowEmpty('id', 'create');
        
        $validator->allowEmpty('observacao');
        
        $validator->allowEmpty('observacao_remocao');
        
        $validator->requirePresence('data_cadastro', 'create', 'Campo Obrigatório')
        ->notEmpty('data_cadastro', 'create', 'Campo obrigatório');
        
        $validator->allowEmpty('data_remocao');
        
        /*$validator->requirePresence('internacao_id', 'create')
        ->notEmpty('internacao_id', 'create','Escolha uma internação');
*/
        
        $validator->requirePresence('usuario_id', 'create')
        ->notEmpty('usuario_id', 'Campo Obrigatório' );

        $validator->allowEmpty('remocao_usuario_id');
        
        $validator->allowEmpty('internacao_id');
        
        $validator->requirePresence('tipo_pendencia_id', 'create', 'Campo Obrigatório')
        ->notEmpty('tipo_pendencia_id', 'create', 'Campo obrigatório');
        
        return $validator;

    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules
     *            The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn([
            'tipo_pendencia_id'
        ], 'TipoPendencias'));
        /*$rules->add($rules->existsIn([
            'usuario_id'
        ], 'Usuarios'));*/
        // $rules->add($rules->existsIn(['remocao_usuario_id'], 'RemocaoUsuarios'));
        return $rules;
    }
    
}
