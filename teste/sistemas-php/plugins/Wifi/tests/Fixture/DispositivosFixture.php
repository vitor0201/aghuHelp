<?php
namespace Wifi\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DispositivosFixture
 *
 */
class DispositivosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'dispositivos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tipo_dispositivo_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'internauta_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'situacao_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'endereco_mac' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'justificativa' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'data_cadastro' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'data_recebimento' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'endereco_ip' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'internautas_dispositivos_fk' => ['type' => 'foreign', 'columns' => ['internauta_id'], 'references' => ['internautas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'situacoes_dispositivos_fk' => ['type' => 'foreign', 'columns' => ['situacao_id'], 'references' => ['situacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tipo_dispositivos_dispositivos_fk' => ['type' => 'foreign', 'columns' => ['tipo_dispositivo_id'], 'references' => ['tipo_dispositivos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'tipo_dispositivo_id' => 1,
            'internauta_id' => 1,
            'situacao_id' => 1,
            'endereco_mac' => 'Lorem ipsum dolor sit amet',
            'justificativa' => 'Lorem ipsum dolor sit amet',
            'data_cadastro' => 1459450603,
            'data_recebimento' => '2016-03-31',
            'endereco_ip' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
