<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Mailer;

class SendCommand extends Command
{
    // Nom de la commande CLI
    public static function defaultName(): string
    {
        return 'send';
    }

    public static function getDescription(): string
    {
        return 'Envoi un email de test via cron.';
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $io->out("=== Cron Envoi Email démarré ===");

        // Appel de la méthode d'envoi
        $this->sendTestEmail($io);

        $io->success("Cron terminé !");
        $io->out("Date/heure : " . date('Y-m-d H:i:s'));

        return static::CODE_SUCCESS;
    }

    private function sendTestEmail(ConsoleIo $io)
    {
        // Email de test
        $recipient = 'tonemail@exemple.com';  // Remplace par le vrai destinataire

        $mailer = new Mailer('default'); // Utilise la configuration SMTP 'default'
        $mailer->setTo($recipient)
               ->setFrom(['xtechnova.sarl@gmail.com' => 'xtechnova.sarl'])
               ->setSubject('Test Cron CakePHP Hostinger')
               ->setEmailFormat('html')
               ->deliver('<p>Ceci est un email de test envoyé automatiquement par CakePHP.</p>');

        try {
            $io->success("Email envoyé à {$recipient}");
        } catch (\Exception $e) {
            $io->error("Erreur en envoyant l'email à {$recipient} : " . $e->getMessage());
        }
    }
}
