<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Utility\Text;

class CreateGenderCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        // Récupère l'instance de table (fetchTable est la méthode conseillée en CLI)
        $genders = $this->fetchTable('Genders');

        $gender = $genders->newEmptyEntity();
        $gender->name = 'Genre fictif ' . date('Y-m-d H:i:s');
        $gender->price = 89000;
        $gender->create_uid = 1;
        $gender->write_uid = 1;
        $gender->uuid = Text::uuid();

        if ($genders->save($gender)) {
            $io->out('✅ Genre créé : ' . $gender->name);
            return static::CODE_SUCCESS;
        }

        $io->err('❌ Échec de la sauvegarde du genre');
        return static::CODE_ERROR;
    }
}
