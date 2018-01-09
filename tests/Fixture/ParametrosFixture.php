<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParametrosFixture
 *
 */
class ParametrosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'parametros';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'sistema_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'descricao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'chave' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'valor' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'tipo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'ativo' => ['type' => 'boolean', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
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
            'descricao' => 'Lorem ipsum dolor sit amet',
            'chave' => 'Lorem ipsum dolor sit amet',
            'valor' => 'Lorem ipsum dolor sit amet',
            'tipo' => 'Lorem ipsum dolor sit amet',
            'ativo' => 1
        ],
    ];
}
