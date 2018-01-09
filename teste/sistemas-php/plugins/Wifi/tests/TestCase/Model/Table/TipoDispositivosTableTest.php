<?php
namespace Wifi\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Wifi\Model\Table\TipoDispositivosTable;

/**
 * Wifi\Model\Table\TipoDispositivosTable Test Case
 */
class TipoDispositivosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.wifi.tipo_dispositivos',
        'plugin.wifi.dispositivos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TipoDispositivos') ? [] : ['className' => 'Wifi\Model\Table\TipoDispositivosTable'];
        $this->TipoDispositivos = TableRegistry::get('TipoDispositivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoDispositivos);

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
