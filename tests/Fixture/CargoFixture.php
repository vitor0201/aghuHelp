<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CargoFixture
 *
 */
class CargoFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cargo';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => true],
        'cargo_descricao' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'cargo_codigo' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'cargo_observacao' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            'id' => '',
            'cargo_descricao' => 'Lorem ipsum dolor sit amet',
            'cargo_codigo' => 'Lorem ipsum dolor sit amet',
            'cargo_observacao' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
