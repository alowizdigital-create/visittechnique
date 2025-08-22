<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CashMovementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CashMovementsTable Test Case
 */
class CashMovementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CashMovementsTable
     */
    protected $CashMovements;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CashMovements',
        'app.CashBoxes',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CashMovements') ? [] : ['className' => CashMovementsTable::class];
        $this->CashMovements = $this->getTableLocator()->get('CashMovements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CashMovements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CashMovementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CashMovementsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
