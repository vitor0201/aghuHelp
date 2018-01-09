<?php
namespace Indicadores\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IndicadoresFixture
 *
 */
class IndicadoresFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'indicadores';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'nome' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            'nome' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
