<?php
namespace Base\Model\Table;

use Base\Model\Entity\Grupo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grupos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\BelongsToMany $Acoes
 * @property \Cake\ORM\Association\BelongsToMany $Parametros
 * @property \Cake\ORM\Association\BelongsToMany $Usuarios
 */
class GruposTable extends Table
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

        $this->table('base.grupos');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->belongsTo('Base.Sistemas', [
            'foreignKey' => 'sistema_id',
            'joinType' => 'INNER',
        	'dependent' => true,
        	'joinTable' => 'base.sistemas'
        ]);
        
        $this->belongsToMany('Base.Acoes', [
            'foreignKey' => 'grupo_id',
            'targetForeignKey' => 'acao_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
            'joinTable' => 'base.acoes_grupos'
        ]);
        
        $this->belongsToMany('Base.Parametros', [
            'foreignKey' => 'grupo_id',
            'targetForeignKey' => 'parametro_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
            'joinTable' => 'base.parametros_grupos'
        ]);
        $this->belongsToMany('Base.Usuarios', [
            'foreignKey' => 'grupo_id',
            'targetForeignKey' => 'usuario_id',
        		'dependent' => true,
        		'cascadeCallbacks' => true,
            'joinTable' => 'base.usuarios_grupos'
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
            ->notEmpty('descricao', 'Campo obrigatório.');

        $validator
            ->requirePresence('atividade', 'create')
            ->notEmpty('atividade', 'Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo', 'Campo obrigatório.');

        $validator
            ->requirePresence('sigla', 'create')
            ->notEmpty('sigla', 'Campo obrigatório.');

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
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));
        return $rules;
    }
}
