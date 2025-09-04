<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MotifsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MotifsTable Test Case
 */
class MotifsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MotifsTable
     */
    protected $Motifs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Motifs',
        'app.Startups',
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
        $config = $this->getTableLocator()->exists('Motifs') ? [] : ['className' => MotifsTable::class];
        $this->Motifs = $this->getTableLocator()->get('Motifs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Motifs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MotifsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MotifsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
