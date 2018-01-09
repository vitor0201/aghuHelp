<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\MotivosTable;

/**
 * Mater\Model\Table\MotivosTable Test Case
 */
class MotivosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.motivos',
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.agendamentos',
        'plugin.mater.situacoes',
        'plugin.mater.salas',
        'plugin.mater.preceptor',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.medicos',
        'plugin.mater.disponibilidades',
        'plugin.mater.periodos',
        'plugin.mater.bloqueios',
        'plugin.mater.procedimentos',
        'plugin.mater.documentos',
        'plugin.mater.procedimentos_documentos',
        'plugin.mater.medicos_procedimentos',
        'plugin.mater.solicitante',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.vagas',
        'plugin.mater.resultados'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Motivos') ? [] : ['className' => 'Mater\Model\Table\MotivosTable'];
        $this->Motivos = TableRegistry::get('Motivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Motivos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
