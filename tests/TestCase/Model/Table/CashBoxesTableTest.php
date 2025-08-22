<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CashBoxesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CashBoxesTable Test Case
 */
class CashBoxesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CashBoxesTable
     */
    protected $CashBoxes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CashBoxes',
        'app.CashMovements',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CashBoxes') ? [] : ['className' => CashBoxesTable::class];
        $this->CashBoxes = $this->getTableLocator()->get('CashBoxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CashBoxes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CashBoxesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
