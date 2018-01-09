<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VagasFixture
 *
 */
class VagasFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'vagas';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'sala_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'data' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'horario' => ['type' => 'time', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'data_cadastro' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'usuario_cadastro' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'sala_id' => 1,
            'data' => '2016-11-17',
            'horario' => '12:55:02',
            'data_cadastro' => 1479401702,
            'usuario_cadastro' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
