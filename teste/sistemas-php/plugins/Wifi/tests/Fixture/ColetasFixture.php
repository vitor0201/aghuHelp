<?php
namespace Wifi\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ColetasFixture
 *
 */
class ColetasFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'coletas';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'codigo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'validate' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'lote' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'quantidade' => ['type' => 'decimal', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
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
            'codigo' => 'Lorem ipsum dolor sit amet',
            'descricao' => 'Lorem ipsum dolor sit amet',
            'validate' => '2016-04-02',
            'lote' => 'Lorem ipsum dolor sit amet',
            'quantidade' => 1.5
        ],
    ];
}
