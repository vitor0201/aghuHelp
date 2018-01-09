<?php
namespace Indicadores\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Indicadores\Model\Table\FichaIndicadoresTable;

/**
 * Indicadores\Model\Table\FichaIndicadoresTable Test Case
 */
class FichaIndicadoresTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.indicadores.ficha_indicadores',
        'plugin.indicadores.indicadores',
        'plugin.indicadores.configuracao',
        'plugin.indicadores.estilo'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FichaIndicadores') ? [] : ['className' => 'Indicadores\Model\Table\FichaIndicadoresTable'];
        $this->FichaIndicadores = TableRegistry::get('FichaIndicadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FichaIndicadores);

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
