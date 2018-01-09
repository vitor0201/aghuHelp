<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\DisponibilidadesTable;

/**
 * Mater\Model\Table\DisponibilidadesTable Test Case
 */
class DisponibilidadesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.disponibilidades',
        'plugin.mater.medicos',
        'plugin.mater.cirurgias_medicos',
        'plugin.mater.procedimentos',
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.documentos',
        'plugin.mater.medicos_procedimentos',
        'plugin.mater.periodos',
        'plugin.mater.agendamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Disponibilidades') ? [] : ['className' => 'Mater\Model\Table\DisponibilidadesTable'];
        $this->Disponibilidades = TableRegistry::get('Disponibilidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Disponibilidades);

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
