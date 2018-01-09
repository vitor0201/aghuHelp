<?php
namespace Sms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HistoricosFixture
 *
 */
class HistoricosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'historicos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'fone' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'data_hora' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'texto' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'contato' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'fone' => 'Lorem ipsum dolor sit amet',
            'data_hora' => 1460750877,
            'texto' => 'Lorem ipsum dolor sit amet',
            'contato' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
