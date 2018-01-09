<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AjudasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AjudasTable Test Case
 */
class AjudasTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ajudas',
        'app.sistemas',
        'app.acoes',
        'app.grupos',
        'app.acoes_grupos',
        'app.parametros',
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
        $config = TableRegistry::exists('Ajudas') ? [] : ['className' => 'App\Model\Table\AjudasTable'];
        $this->Ajudas = TableRegistry::get('Ajudas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ajudas);

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
