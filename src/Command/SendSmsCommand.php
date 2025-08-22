<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\FrozenDate;
use Cake\Mailer\Mailer;


/**
 * SendSms command.
 */
class SendSmsCommand extends Command
{
    /**
     * The name of this command.
     *
     * @var string
     */
    protected string $name = 'send_sms';

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'send_sms';
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Command description here.';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/5/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription());
    }

   public function sendApi($content, $receiver, $io)
    {
        // Exemple d’API (fictive)
        $url = "https://api.example.com/send";
        $data = [
            'to'      => $receiver,
            'message' => $content,
            'sender'  => "MyApp" 
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer VOTRE_API_KEY"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false || $httpCode !== 200) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Échec d'envoi : " . ($error ?: $response));
        }
        curl_close($ch);

        $io->out("✅ Message envoyé via API à $receiver");
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
      public function execute(Arguments $args, ConsoleIo $io)
    {
        // Définir le fuseau horaire
        date_default_timezone_set('Africa/Douala');

        // Charger le modèle Messages
        $Messages = $this->fetchTable('Messages');
        // $query = $Messages->find()->where([ 'status' => 'pending',]);
       
        $today = FrozenDate::today('Africa/Douala')->format('Y-m-d');

        $query = $Messages->find()
            ->where([
                'status' => 'pending',
                "DATE(sent_date) =" => $today
            ]);

        $total = $query->count();
   
        if ($total === 0) {
            $io->out("Aucun message à envoyer aujourd'hui.");
            return;
        }

        $io->out("Messages à envoyer aujourd'hui : $total");
        foreach ($query->all() as $message) {
            $io->out(" - #{$message->id} : {$message->content}");
            try {
                $receiver = $message->receiver;
                // debug($receiver);
                // exit();
                $this->sendApi($message->content, $receiver, $io);
                $message->status = 'sent';
                $Messages->save($message);
                $io->out("Message envoyé à {$message->receiver}");
            } catch (\Throwable $e) {
                $io->err("Erreur envoi message #{$message->id}: " . $e->getMessage());
            }
        }
        $io->success('Traitement terminé.');
    }
    
}
