<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Procedimento;

/**
 * Procedimentos Model
 *
 * @property \Cake\ORM\Association\HasMany $CirurgiasProcedimentos
 * @property \Cake\ORM\Association\HasMany $Documentos
 * @property \Cake\ORM\Association\BelongsToMany $Medicos
 */
class ProcedimentosTable extends Table
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

        $this->table('mater.procedimentos');
        $this->displayField('descricao2');
        $this->primaryKey('id');

        $this->hasMany('CirurgiasProcedimentos', [
            'foreignKey' => 'procedimento_id',
            'className' => 'Mater.CirurgiasProcedimentos'
        ]);
        
    
        
        $this->belongsToMany('Documentos', [
				'foreignKey' => 'procedimento_id',
        		'targetForeignKey' => 'documento_id',
        		'joinTable' => 'mater.procedimentos_documentos',
        		'className' => 'Mater.Documentos'
        ]);
        
        $this->belongsToMany('Medicos', [
            'foreignKey' => 'procedimento_id',
            'targetForeignKey' => 'medico_id',
            'joinTable' => 'mater.medicos_procedimentos',
            'className' => 'Mater.Medicos'
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
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo','Campo obrigatório.');

        $validator
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao','Campo obrigatório.');
        
        $validator
        ->requirePresence('descricao2', 'create')
        ->notEmpty('descricao','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        return $validator;
    }
    
    
    public function buildRules(RulesChecker $rules)
    {
    
    	$rules->add($rules->isUnique(['descricao2'],'Procedimento já está cadastrado.'));
    
    	return $rules;
    }
    
}
