<?php
namespace Indicadores\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Indicadores\Model\Table\EstiloTable;

/**
 * Indicadores\Model\Table\EstiloTable Test Case
 */
class EstiloTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.indicadores.estilo',
        'plugin.indicadores.ficha_indicadores',
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
        $config = TableRegistry::exists('Estilo') ? [] : ['className' => 'Indicadores\Model\Table\EstiloTable'];
        $this->Estilo = TableRegistry::get('Estilo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Estilo);

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
