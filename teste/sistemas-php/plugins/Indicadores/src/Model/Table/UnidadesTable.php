<?php
namespace Indicadores\Model\Table;

use Cake\ORM\Table;

class UnidadesTable extends Table
{

    public function initialize(array $config)
    {
        $unidade = TableRegistry::get('aghu');
    }
}