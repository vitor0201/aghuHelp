<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AgendamentosFixture
 *
 */
class AgendamentosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'agendamentos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'periodo_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'situacao_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'sala_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'data_cadastro' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'data' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'dia_semana' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'sequencia' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'horario' => ['type' => 'time', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'duracao' => ['type' => 'time', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'paciente_prontuario' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'prontuario' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'paciente_nome' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'paciente_fone1' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'paciente_fone2' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'paciente_nascimento' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'aih' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'observacao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'salas_cirurgias_fk' => ['type' => 'foreign', 'columns' => ['sala_id'], 'references' => ['salas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'situacoes_agendamentos_fk' => ['type' => 'foreign', 'columns' => ['situacao_id'], 'references' => ['situacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'periodo_id' => 1,
            'situacao_id' => 1,
            'sala_id' => 1,
            'data_cadastro' => 1478281299,
            'data' => '2016-11-04',
            'dia_semana' => 'Lorem ipsum dolor sit amet',
            'sequencia' => 'Lorem ipsum dolor sit amet',
            'horario' => '13:41:39',
            'duracao' => '13:41:39',
            'paciente_prontuario' => 'Lorem ipsum dolor sit amet',
            'prontuario' => 'Lorem ipsum dolor sit amet',
            'paciente_nome' => 'Lorem ipsum dolor sit amet',
            'paciente_fone1' => 'Lorem ipsum dolor sit amet',
            'paciente_fone2' => 'Lorem ipsum dolor sit amet',
            'paciente_nascimento' => 'Lorem ipsum dolor sit amet',
            'aih' => 'Lorem ipsum dolor sit amet',
            'observacao' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
