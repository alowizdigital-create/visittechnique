<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\Mailer;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Http\Client; 



/**
 * SendEmailCron command.
 */
class SendEmailCronCommand extends Command
{
    /**
     * The name of this command.
     *
     * @var string
     */
    protected string $name = 'send_email_cron';

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'send_email_cron';
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

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function sendWelcomeEmail($content, $email, ConsoleIo $io)
    {
        // Récupérer l'utilisateur
       
        // Configurer le mailer
        $mailer = new Mailer('default');
        
        $mailer->setTo($email)
            ->setFrom(['xtechnova.sarl@gmail.com' => 'xtechnova.sarl'])
            ->setSubject('Rappel fin contrat vehicule !')
            ->setEmailFormat('html') // force HTML

            // Configurer template et layout via viewBuilder()
            ->viewBuilder()
                ->setTemplate('shedule') 
                ->setLayout('sympa')       
                ->setVar('content', $content);
        // Envoyer le mail
        try {
            $mailer->deliver(); 
            $io->success("Email envoyé à {$email}");
        } catch (\Exception $e) {
            $io->error("Erreur en envoyant l'email à {$email} : " . $e->getMessage());
        }
    }

       public function SendMessages()
    {
        $to = '00237656262480';
        $message = 'Bonjour c est le contenu dossms';
        $from = 'vehicontrols';
        debug($to);die();

        $http = new Client();

        $response = $http->post('https://api.avlytext.com/v1/sms?api_key=dMoSJgddqOQyB1tir3cnk5jm2eDNr0u0jsbgpvZ8Knwd58ZDU1FlSTClJgaZupwr4K00', [
            'to' => $to,
            'from' => $from,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'dnd',
            'api_key' => 'MacléApi'
        ], [
            'type' => 'json'
        ]);

        $json = $response->isOk() ? $response->getJson() : ['error' => 'Échec de l\'envoi'];

        $this->set([
            'success' => $response->isOk(),
            'response' => $json,
            '_serialize' => ['success', 'response']
        ]);
    }
    public function sendSms($recipient,$content)  {
         // 🚨 CONFIGURATION DE TEST (REMPLACEZ PAR VOS VALEURS RÉELLES) 🚨
        $apiKey    = '4IlrXpZRlqp4bLOdjnBCyS6qk68uleWE7ttHRsOyJF7ydOH97Ti6H7llfmDicjdNbuY2';
        $endpoint  = 'https://api.avlytext.com/v1/sms';
        $sender    = 'DosSMS';
        $recipient = $recipient;
        $text      = $content;
        // debug($recipient);die();
        try {
            // 1. Initialisation du Client HTTP (simule la commande curl)
            $http = new Client();

            // 2. Préparation de l'URL avec la clé API en Query Parameter
            $urlWithKey = $endpoint . '?api_key=' . urlencode($apiKey);
             
            // 3. Définition des données JSON (pour le --data)
            $data = [
                'sender' => $sender,
                'recipient' => $recipient,
                'text' => $text,
            ];
            
            // 4. Options pour le Header et la redirection
            $options = [
                'redirect' => true,      // Simule --location
                'type' => 'json',        // Simule --header 'Content-Type: application/json'
            ];
            // debug($recipient);die();

            // 5. Exécution de la requête POST
            $response = $http->post(
                $urlWithKey, 
                $data, 
                $options
            );
            if ($response->isOk()) {
                $apiResponse = $response->getJson();
                //  debug($apiResponse);die();
                // $this->Flash->success('✅ SMS envoyé avec succès! Statut API: ' . h($apiResponse['status']));
            } else {
                // $this->Flash->error('❌ Échec de l\'envoi. Code HTTP: ' . $response->getStatusCode());
                // $this->Flash->error('Réponse API: ' . $response->getStringBody());
            }
        
        } catch (\Exception $e) {
          
        }
    }

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
        // debug($total);
        // exit();
        if ($total === 0) {
            $io->out("Aucun message à envoyer aujourd'hui.");
            return;
        }

        $io->out("Messages à envoyer aujourd'hui : $total");

        foreach ($query->all() as $message) {
            // debug($message);die();
            // $customer = $this->fetchTable('Customers')->find()->where(['id'=> $message->customer_id])->first();
            // $subject = 'ggg';
            $recipient = '+237' .''. $message->receiver;
            // debug($recipient);die();
            try {
                // $this->sendWelcomeEmail($message->content, $email, $io); // Passe $io à la méthode
                $this->sendSms($recipient,$message->content);
                // Marquer comme envoyé
                $message->status = 'sent';
                $Messages->save($message);

                $io->out("Message envoyé à {$message->receiver}");
            } catch (\Throwable $e) {
                $io->err("Erreur envoi message #{$message->id}: " . $e->getMessage());
            }
        }
        $io->success('Traitement terminé.');
    }

       public function exe(Arguments $args, ConsoleIo $io)
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
            $customer = $this->fetchTable('Customers')->find()->where(['id'=> $message->customer_id])->first();
            $subject = 'ggg';
            $email = $customer->email;
            $io->out(" - #{$message->id} : {$message->content} ({$subject})");
            try {
                $this->sendWelcomeEmail($message->content, $email, $io); // Passe $io à la méthode
                // Marquer comme envoyé
                $message->status = 'sent';
                $Messages->save($message);

                $io->out("Message envoyé à {$message->receiver}");
            } catch (\Throwable $e) {
                $io->err("Erreur envoi message #{$message->id}: " . $e->getMessage());
            }
        }
        $io->success('Traitement terminé.');
    }
    


    



    public function execu(Arguments $args, ConsoleIo $io)
    {
        // Définir le fuseau horaire
        date_default_timezone_set('Africa/Douala');

        // Charger le modèle Messages
        $Messages = $this->fetchTable('Messages');
        // $query = $Messages->find()->where([ 'status' => 'pending',]);
       
        $query = $Messages->find()
            ->where([
                'status' => 'pending',
                // 'sent_date' => $today
            ]);

        $total = $query->count();
        // debug($total);
        // exit();
        if ($total === 0) {
            $io->out("Aucun message à envoyer aujourd'hui.");
            return;
        }

        $io->out("Messages à envoyer aujourd'hui : $total");

        foreach ($query->all() as $message) {
            $subject = 'Test mail';
            $io->out(" - #{$message->id} : {$message->content} ({$subject})");

            try {
                $this->sendWelcomeEmail(1, $io); // Passe $io à la méthode

                // Marquer comme envoyé
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
