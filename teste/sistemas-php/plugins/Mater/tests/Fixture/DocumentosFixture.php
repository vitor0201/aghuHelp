<?php
namespace Mater\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentosFixture
 *
 */
class DocumentosFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'documentos';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'procedimento_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ativo' => ['type' => 'boolean', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'titulo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'cadastro' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'usuario_cadastro' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'arquivo' => ['type' => 'binary', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'arquivo_tamanho' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'arquivo_tipo' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'arquivo_nome' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'procedimentos_documentos_fk' => ['type' => 'foreign', 'columns' => ['procedimento_id'], 'references' => ['procedimentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'procedimento_id' => 1,
            'ativo' => 1,
            'titulo' => 'Lorem ipsum dolor sit amet',
            'cadastro' => 1478027166,
            'usuario_cadastro' => 'Lorem ipsum dolor sit amet',
            'arquivo' => 'Lorem ipsum dolor sit amet',
            'arquivo_tamanho' => 1,
            'arquivo_tipo' => 'Lorem ipsum dolor sit amet',
            'arquivo_nome' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
