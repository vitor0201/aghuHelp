<?php
namespace Tutorial\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Tutorial\Model\Entity\Tag;

/**
 * Tags Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Arquivos
 */
class TagsTable extends Table
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

        $this->table('tutorial.tags');
        $this->displayField('id');
        $this->primaryKey('id');

        /*$this->belongsToMany('Arquivos', [
            'foreignKey' => 'tag_id',
            'targetForeignKey' => 'arquivo_id',
            'joinTable' => 'arquivos_tags',
            'className' => 'Tutorial.Arquivos'
        ]);*/
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
            ->notEmpty('descricao','Campo obrigatório.');

        $validator
            ->add('ativo', 'valid', ['rule' => 'boolean'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo','Campo obrigatório.');

        return $validator;
    }
}
