<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AcoesFixture
 *
 */
class AcoesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'acoes';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'sistema_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'prefix' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'action' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'controller' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'ativo' => ['type' => 'boolean', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'tipo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            'sistema_id' => 1,
            'prefix' => 'Lorem ipsum dolor sit amet',
            'action' => 'Lorem ipsum dolor sit amet',
            'controller' => 'Lorem ipsum dolor sit amet',
            'ativo' => 1,
            'tipo' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
