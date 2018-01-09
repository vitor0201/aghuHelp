<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\CirurgiasMedicosTable;

/**
 * Mater\Model\Table\CirurgiasMedicosTable Test Case
 */
class CirurgiasMedicosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.medicos',
        'plugin.mater.disponibilidades',
        'plugin.mater.periodos',
        'plugin.mater.agendamentos',
        'plugin.mater.situacoes',
        'plugin.mater.salas',
        'plugin.mater.residentes',
        'plugin.mater.procedimentos',
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.resultados',
        'plugin.mater.documentos',
        'plugin.mater.procedimentos_documentos',
        'plugin.mater.medicos_procedimentos',
        'plugin.mater.cirurgias_medicos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CirurgiasMedicos') ? [] : ['className' => 'Mater\Model\Table\CirurgiasMedicosTable'];
        $this->CirurgiasMedicos = TableRegistry::get('CirurgiasMedicos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CirurgiasMedicos);

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
