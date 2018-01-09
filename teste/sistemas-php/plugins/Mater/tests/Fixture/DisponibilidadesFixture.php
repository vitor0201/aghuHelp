<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DisponibilidadesFixture
 *
 */
class DisponibilidadesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'disponibilidades';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'medico_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'dia_semana' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'periodo_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ativo' => ['type' => 'boolean', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'medicos_disponibilidades_fk' => ['type' => 'foreign', 'columns' => ['medico_id'], 'references' => ['medicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'periodos_disponibilidades_fk' => ['type' => 'foreign', 'columns' => ['periodo_id'], 'references' => ['periodos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'medico_id' => 1,
            'dia_semana' => 1,
            'periodo_id' => 1,
            'ativo' => 1
        ],
    ];
}
