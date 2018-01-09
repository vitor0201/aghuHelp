<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CirurgiasProcedimentosFixture
 *
 */
class CirurgiasProcedimentosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cirurgias_procedimentos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'cirurgia_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'procedimento_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'resultado_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'observacao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cirurgias_cirurgias_procedimentos_fk' => ['type' => 'foreign', 'columns' => ['cirurgia_id'], 'references' => ['agendamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'procedimentos_cirurgias_procedimentos_fk' => ['type' => 'foreign', 'columns' => ['procedimento_id'], 'references' => ['procedimentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resultados_cirurgias_procedimentos_fk' => ['type' => 'foreign', 'columns' => ['resultado_id'], 'references' => ['resultados', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'cirurgia_id' => 1,
            'procedimento_id' => 1,
            'resultado_id' => 1,
            'observacao' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
