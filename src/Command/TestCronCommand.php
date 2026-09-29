<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\Http\Client;

class TestCronCommand extends Command
{
    protected string $name = 'test_cron';

    public static function defaultName(): string
    {
        return 'test_cron';
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $io->out('Cron OK - exécuté le ' . date('Y-m-d H:i:s'));

        $numero = '656262480'; // ⚠️ remplace par ton propre numéro sans le 237
        $apiToken = Configure::read('Sms.apiToken');
        $endpoint = 'https://app.techsoft-sms.com/api/http/sms/send';

        $data = [
            'api_token' => $apiToken,
            'recipient' => '237' . $numero,
            'sender_id' => 'CCT GODWIN',
            'type' => 'plain',
            'message' => 'Test cron SMS - ' . date('Y-m-d H:i:s'),
        ];

        $http = new Client();
        $response = $http->post($endpoint, json_encode($data), [
            'type' => 'json',
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        ]);

        if ($response->isOk()) {
            $io->success('SMS de test envoyé à ' . $numero . '. Réponse API: ' . json_encode($response->getJson()));
            return static::CODE_SUCCESS;
        }

        $io->error('Échec envoi SMS. Code HTTP: ' . $response->getStatusCode() . ' - ' . $response->getStringBody());
        return static::CODE_ERROR;
    }
}
