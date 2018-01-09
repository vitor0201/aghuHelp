<?php
namespace Mater\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Mater\Model\Table\ProcedimentosTable;

/**
 * Mater\Model\Table\ProcedimentosTable Test Case
 */
class ProcedimentosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mater.procedimentos',
        'plugin.mater.cirurgias_procedimentos',
        'plugin.mater.documentos',
        'plugin.mater.medicos',
        'plugin.mater.medicos_procedimentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Procedimentos') ? [] : ['className' => 'Mater\Model\Table\ProcedimentosTable'];
        $this->Procedimentos = TableRegistry::get('Procedimentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Procedimentos);

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
