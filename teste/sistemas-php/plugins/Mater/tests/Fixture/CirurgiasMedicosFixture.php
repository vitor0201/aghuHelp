<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CirurgiasMedicosFixture
 *
 */
class CirurgiasMedicosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cirurgias_medicos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'medico_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'cirurgia_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cirurgias_cirurgias_medicos_fk' => ['type' => 'foreign', 'columns' => ['cirurgia_id'], 'references' => ['agendamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'medicos_cirurgias_medicos_fk' => ['type' => 'foreign', 'columns' => ['medico_id'], 'references' => ['medicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'medico_id' => 1,
            'cirurgia_id' => 1
        ],
    ];
}
