<?php
namespace Tutorial\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Tutorial\Model\Entity\Arquivo;

/**
 * Arquivos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categorias
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 */
class ArquivosTable extends Table
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

        $this->table('tutorial.arquivos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Categorias', [
            'foreignKey' => 'categoria_id',
            'joinType' => 'INNER',
            'className' => 'Tutorial.Categorias'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'arquivo_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'arquivos_tags',
            'className' => 'Tutorial.Tags'
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
            ->requirePresence('titulo', 'create')
            ->notEmpty('titulo','Campo obrigatório.');

        $validator
            ->requirePresence('autor', 'create')
            ->notEmpty('autor','Campo obrigatório.');

        $validator
            ->allowEmpty('descricao');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_caminho', 'create')
            ->notEmpty('arquivo_caminho','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_tamanho', 'create')
            ->notEmpty('arquivo_tamanho','Campo obrigatório.');

        $validator
            ->requirePresence('arquivo_type', 'create')
            ->notEmpty('arquivo_type','Campo obrigatório.');

        $validator
            ->add('data_publicacao', 'valid', ['rule' => 'date'])
            ->requirePresence('data_publicacao', 'create')
            ->notEmpty('data_publicacao','Campo obrigatório.');

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
        $rules->add($rules->existsIn(['categoria_id'], 'Categorias'));
        return $rules;
    }
}
