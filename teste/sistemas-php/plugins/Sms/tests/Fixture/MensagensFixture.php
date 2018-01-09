<?php
namespace Sms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MensagensFixture
 *
 */
class MensagensFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'mensagens';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'ddd' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'fone' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'texto' => ['type' => 'string', 'length' => 140, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'data_hora' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'login' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            'ddd' => 1,
            'fone' => 1,
            'texto' => 'Lorem ipsum dolor sit amet',
            'data_hora' => 1460730391,
            'status' => 'Lorem ipsum dolor sit amet',
            'login' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
