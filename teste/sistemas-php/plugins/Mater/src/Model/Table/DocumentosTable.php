<?php
namespace Mater\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mater\Model\Entity\Documento;

/**
 * Documentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Procedimentos
 */
class DocumentosTable extends Table
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

        $this->table('mater.documentos');
        $this->displayField('titulo');
        $this->primaryKey('id');



        $this->belongsToMany('Procedimentos', [
        		'foreignKey' => 'documento_id',
        		'targetForeignKey' => 'procedimento_id',
        		'joinTable' => 'mater.procedimentos_documentos',
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
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        $validator
            ->requirePresence('titulo', 'create')
            ->notEmpty('titulo','Campo obrigatório.');

        $validator
            ->requirePresence('cadastro', 'create')
            ->notEmpty('cadastro','Campo obrigatório.');

        $validator
            ->requirePresence('usuario_cadastro', 'create')
            ->notEmpty('usuario_cadastro','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo', 'create')
            ->notEmpty('arquivo','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_tamanho', 'create')
            ->notEmpty('arquivo_tamanho','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_tipo', 'create')
            ->notEmpty('arquivo_tipo','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_nome', 'create')
            ->notEmpty('arquivo_nome','Campo obrigatório.');

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
//         $rules->add($rules->existsIn(['procedimento_id'], 'Procedimentos'));

    	$rules->add($rules->isUnique(['titulo'],'Título já está cadastrado.'));
//     	$rules->add($rules->isUnique(['arquivo_nome','arquivo_tipo','arquivo_tamanho'],'Este arquivo já está cadastrado.'));
    	
        return $rules;
    } 
}
