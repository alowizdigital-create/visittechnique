<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;

class TestCronCommand extends Command
{
    protected string $name = 'test_cron';

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $io->out('Cron OK - exécuté le ' . date('Y-m-d H:i:s'));
        return static::CODE_SUCCESS;
    }
}
