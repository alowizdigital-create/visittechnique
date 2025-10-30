<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StartupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StartupsTable Test Case
 */
class StartupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StartupsTable
     */
    protected $Startups;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Startups',
        'app.Accounts',
        'app.Admins',
        'app.Customers',
        'app.Genders',
        'app.Motifs',
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
        $config = $this->getTableLocator()->exists('Startups') ? [] : ['className' => StartupsTable::class];
        $this->Startups = $this->getTableLocator()->get('Startups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Startups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\StartupsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
