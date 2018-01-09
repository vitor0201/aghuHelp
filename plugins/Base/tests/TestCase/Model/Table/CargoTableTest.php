<?php
namespace Base\Test\TestCase\Model\Table;

use Base\Model\Table\CargoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Base\Model\Table\CargoTable Test Case
 */
class CargoTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.base.cargo',
        'plugin.base.funcionario'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cargo') ? [] : ['className' => 'Base\Model\Table\CargoTable'];
        $this->Cargo = TableRegistry::get('Cargo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cargo);

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
