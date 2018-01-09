<?php
namespace Wifi\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Wifi\Model\Table\DispositivosTable;

/**
 * Wifi\Model\Table\DispositivosTable Test Case
 */
class DispositivosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.wifi.dispositivos',
        'plugin.wifi.tipo_dispositivos',
        'plugin.wifi.internautas',
        'plugin.wifi.situacoes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Dispositivos') ? [] : ['className' => 'Wifi\Model\Table\DispositivosTable'];
        $this->Dispositivos = TableRegistry::get('Dispositivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dispositivos);

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
