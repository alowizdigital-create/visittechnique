<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\FrozenDate;
use Cake\Http\Client;

class SendEmailCronCommand extends Command
{
    protected string $name = 'send_email_cron';

    public static function defaultName(): string
    {
        return 'send_email_cron';
    }

    public static function getDescription(): string
    {
        return "Envoie les SMS en attente pour la journée en cours.";
    }

    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription());
    }

    protected function sendSms(string $recipient, string $content, ConsoleIo $io): bool
    {
        $apiToken = '1523|0XzFUAtbKmVp*zVquAGiWSv25480b08bf';
        $endpoint = 'https://app.techsoft-sms.com/api/http/sms/send';

        $data = [
            'api_token' => $apiToken,
            'recipient' => '237' . $recipient,
            'sender_id' => 'CCT GODWIN',
            'type' => 'plain',
            'message' => $content,
        ];

        try {
            $http = new Client();
            $response = $http->post(
                $endpoint,
                json_encode($data),
                [
                    'type' => 'json',
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                ]
            );

            if ($response->isOk()) {
                return true;
            }

            $io->error("Échec SMS vers {$recipient}. Code HTTP: " . $response->getStatusCode() . ' - ' . $response->getStringBody());
            return false;
        } catch (\Throwable $e) {
            $io->error("Erreur envoi SMS à {$recipient} : " . $e->getMessage());
            return false;
        }
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        date_default_timezone_set('Africa/Douala');

        $Messages = $this->fetchTable('Messages');
        $today = FrozenDate::today('Africa/Douala')->format('Y-m-d');

        $query = $Messages->find()
            ->where([
                'status' => 'pending',
                'DATE(sent_date) =' => $today,
            ]);

        $total = $query->count();

        if ($total === 0) {
            $io->out("Aucun message à envoyer aujourd'hui.");
            return static::CODE_SUCCESS;
        }

        $io->out("Messages à envoyer aujourd'hui : {$total}");

        $errors = 0;

        foreach ($query->all() as $message) {
            $sent = $this->sendSms($message->receiver, $message->content, $io);

            if ($sent) {
                $message->status = 'sent';
                $Messages->save($message);
                $io->out("Message envoyé à {$message->receiver}");
            } else {
                $errors++;
                $io->error("Échec de l'envoi du message #{$message->id} à {$message->receiver}");
            }
        }

        if ($errors > 0) {
            $io->warning("{$errors} message(s) n'ont pas pu être envoyés.");
            return static::CODE_ERROR;
        }

        $io->success('Traitement terminé.');
        return static::CODE_SUCCESS;
    }
}
