<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Medico;

/**
 * Medicos Model
 *
 * @property \Cake\ORM\Association\HasMany $CirurgiasMedicos
 * @property \Cake\ORM\Association\HasMany $Disponibilidades
 * @property \Cake\ORM\Association\BelongsToMany $Procedimentos
 */
class MedicosTable extends Table
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

        $this->table('mater.medicos');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->hasMany('CirurgiasMedicos', [
            'foreignKey' => 'medico_id',
            'className' => 'Mater.CirurgiasMedicos'
        ]);
        $this->hasMany('Disponibilidades', [
            'foreignKey' => 'medico_id',
            'className' => 'Mater.Disponibilidades',
        	'dependent' => true,
        ]);
        
        $this->hasMany('Bloqueios', [
        		'foreignKey' => 'medico_id',
        		'className' => 'Mater.Bloqueios',
        		'dependent' => true,
        		]);
        
        $this->belongsToMany('Procedimentos', [
            'foreignKey' => 'medico_id',
            'targetForeignKey' => 'procedimento_id',
            'joinTable' => 'mater.medicos_procedimentos',
            'className' => 'Mater.Procedimentos',
        		'dependent' => true,
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

        $validator
            ->requirePresence('crm', 'create')
            ->notEmpty('crm','Campo obrigatório.');

        $validator
            ->add('residente', 'valid', ['rule' => 'boolean'])
            ->requirePresence('residente', 'create')
            ->notEmpty('residente','Campo obrigatório.');

        $validator
            ->add('preceptor', 'valid', ['rule' => 'boolean'])
            ->requirePresence('preceptor', 'create')
            ->notEmpty('preceptor','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

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
    	 
    	$rules->add($rules->isUnique(['crm','nome'],'Médico já está cadastrado.'));

    	return $rules;
    }
    
}
