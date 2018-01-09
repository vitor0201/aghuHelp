<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\AgendamentosTable;

/**
 * Mater\Model\Table\AgendamentosTable Test Case
 */
class AgendamentosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.agendamentos',
        'plugin.mater.periodos',
        'plugin.mater.disponibilidades',
        'plugin.mater.medicos',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.procedimentos',
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.documentos',
        'plugin.mater.procedimentos_documentos',
        'plugin.mater.medicos_procedimentos',
        'plugin.mater.situacoes',
        'plugin.mater.salas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Agendamentos') ? [] : ['className' => 'Mater\Model\Table\AgendamentosTable'];
        $this->Agendamentos = TableRegistry::get('Agendamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Agendamentos);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
