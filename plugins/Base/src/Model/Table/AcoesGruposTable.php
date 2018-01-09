<?php
namespace Base\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Acoes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\BelongsToMany $Grupos
 */
class AcoesGruposTable extends Table
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

        $this->table('base.acoes_grupos');
        $this->displayField('id');
        $this->primaryKey('id');

       
    }
}
