<?php
namespace Indicadores\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FichaIndicadoresFixture
 *
 */
class FichaIndicadoresFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ficha_indicadores';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'area' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'eixo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'nivel' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'objetivo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'finalidade' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'historico' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'formula' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'indicador_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'homologacao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'identificador' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'tipo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'termos' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'fonte' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'responsavel' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'telefone' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'periocidade' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'estilo_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ficha_indicadores_estilo_id_fkey' => ['type' => 'foreign', 'columns' => ['estilo_id'], 'references' => ['estilo', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ficha_indicadores_indicador_id_fkey' => ['type' => 'foreign', 'columns' => ['indicador_id'], 'references' => ['indicadores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'area' => 'Lorem ipsum dolor sit amet',
            'eixo' => 'Lorem ipsum dolor sit amet',
            'nivel' => 'Lorem ipsum dolor sit amet',
            'objetivo' => 'Lorem ipsum dolor sit amet',
            'finalidade' => 'Lorem ipsum dolor sit amet',
            'historico' => 'Lorem ipsum dolor sit amet',
            'formula' => 'Lorem ipsum dolor sit amet',
            'indicador_id' => 1,
            'homologacao' => 'Lorem ipsum dolor sit amet',
            'identificador' => 'Lorem ipsum dolor sit amet',
            'tipo' => 'Lorem ipsum dolor sit amet',
            'termos' => 'Lorem ipsum dolor sit amet',
            'fonte' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'telefone' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'periocidade' => 'Lorem ipsum dolor sit amet',
            'estilo_id' => 1
        ],
    ];
}
