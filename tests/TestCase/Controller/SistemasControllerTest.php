<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SistemasController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SistemasController Test Case
 */
class SistemasControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sistemas',
        'app.acoes',
        'app.grupos',
        'app.acoes_grupos',
        'app.parametros',
        'app.parametros_grupos',
        'app.usuarios',
        'app.usuarios_grupos',
        'app.ajudas',
        'app.menus'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
