<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\Mailer;

/**
 * TestCron command.
 */
class TestCronCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $io->out("=== Envoi d'email démarré ===");

        try {
            $mailer = new Mailer('default');
            $mailer->setTo('etetudesprojets@gmail.com')
                   ->setSubject('Test Cron CakePHP')
                   ->deliver('Bonjour, ceci est un email envoyé automatiquement par le cron !');

            $io->success("Email envoyé avec succès !");
        } catch (\Exception $e) {
            $io->error("Erreur lors de l'envoi de l'email : " . $e->getMessage());
            return static::CODE_ERROR;
        }

        $io->out("Date/heure : " . date('Y-m-d H:i:s'));
        return static::CODE_SUCCESS;
    }

    /**
     * The name of this command.
     *
     * @var string
     */
    protected string $name = 'test_cron';

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'test_cron';
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Command de test pour le cron.';
    }

    /**
     * Définir les options et arguments de la commande
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription());
    }

    /**
     * Logique du cron
     */
   
}
