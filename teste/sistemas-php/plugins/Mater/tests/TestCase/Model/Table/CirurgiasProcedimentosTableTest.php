<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\CirurgiasProcedimentosTable;

/**
 * Mater\Model\Table\CirurgiasProcedimentosTable Test Case
 */
class CirurgiasProcedimentosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.agendamentos',
        'plugin.mater.situacoes',
        'plugin.mater.salas',
        'plugin.mater.medicos',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.disponibilidades',
        'plugin.mater.periodos',
        'plugin.mater.procedimentos',
        'plugin.mater.documentos',
        'plugin.mater.procedimentos_documentos',
        'plugin.mater.medicos_procedimentos',
        'plugin.mater.residentes',
        'plugin.mater.cirurgias_medicos',
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
        $config = TableRegistry::exists('CirurgiasProcedimentos') ? [] : ['className' => 'Mater\Model\Table\CirurgiasProcedimentosTable'];
        $this->CirurgiasProcedimentos = TableRegistry::get('CirurgiasProcedimentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CirurgiasProcedimentos);

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
