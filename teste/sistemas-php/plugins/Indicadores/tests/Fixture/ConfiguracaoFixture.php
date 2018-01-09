<?php
namespace Indicadores\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConfiguracaoFixture
 *
 */
class ConfiguracaoFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'configuracao';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'data' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'valor' => ['type' => 'decimal', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'indicador_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'indicadores_configuracao_fk' => ['type' => 'foreign', 'columns' => ['indicador_id'], 'references' => ['indicadores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'data' => '2017-06-05',
            'valor' => 1.5,
            'indicador_id' => 1
        ],
    ];
}
