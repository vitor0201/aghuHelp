<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\BloqueiosTable;

/**
 * Mater\Model\Table\BloqueiosTable Test Case
 */
class BloqueiosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.bloqueios',
        'plugin.mater.medicos',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.agendamentos',
        'plugin.mater.situacoes',
        'plugin.mater.salas',
        'plugin.mater.preceptor',
        'plugin.mater.disponibilidades',
        'plugin.mater.periodos',
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
        $config = TableRegistry::exists('Bloqueios') ? [] : ['className' => 'Mater\Model\Table\BloqueiosTable'];
        $this->Bloqueios = TableRegistry::get('Bloqueios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bloqueios);

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
