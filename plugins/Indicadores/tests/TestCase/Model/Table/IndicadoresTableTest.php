<?php
namespace Indicadores\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Indicadores\Model\Table\IndicadoresTable;

/**
 * Indicadores\Model\Table\IndicadoresTable Test Case
 */
class IndicadoresTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.indicadores.indicadores',
        'plugin.indicadores.configuracao'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Indicadores') ? [] : ['className' => 'Indicadores\Model\Table\IndicadoresTable'];
        $this->Indicadores = TableRegistry::get('Indicadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Indicadores);

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
