<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParametrosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParametrosTable Test Case
 */
class ParametrosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parametros',
        'app.sistemas',
        'app.acoes',
        'app.ajudas',
        'app.grupos',
        'app.acoes_grupos',
        'app.parametros_grupos',
        'app.usuarios',
        'app.usuarios_grupos',
        'app.menus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Parametros') ? [] : ['className' => 'App\Model\Table\ParametrosTable'];
        $this->Parametros = TableRegistry::get('Parametros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parametros);

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
