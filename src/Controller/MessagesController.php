<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Client;
use DateTime;
use Cake\I18n\FrozenTime;
use Cake\Utility\Text;
use Cake\Mailer\Mailer;

use function Cake\Error\debug;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{

    public function testSend()
    {
        $this->request->allowMethod(['post']); 
        $data = $this->request->getData();
        debug($data);
        exit();
        $to = $data['to'] ?? '';
        $message = $data['message'] ?? '';
        $from = 'vehicontrols';

        $http = new Client();

        $response = $http->post('https://BASE_URL/api/sms/send', [
            'to' => $to,
            'from' => $from,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'dnd',
            'api_key' => 'TA_CLE_API_TERMII_ICI'
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

   public function sent()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');

        // Déterminer si c’est un admin ou un account
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminLogin;
        } else {
            $accountLogin = $accountTable->findById($user->id)->first();
        }

        $startup_id = $accountLogin->startup_id;

        // --- Requête principale ---
        $query = $this->Messages->find()
            ->where([
                'Messages.startup_id' => $startup_id,
                'Messages.status' => 'sent'
            ])
            ->contain([
                'Inspections' => [
                    'Vehicles', // 👈 Ajout des véhicules liés à chaque inspection
                ],
                'Customers'
            ])
            ->limit(200)
            ->order(['Messages.id' => 'DESC']);

        $messages = $query->all()->toArray();

        $this->set(compact('messages'));
    }


      public function pending()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }
            $query = $this->Messages->find()
            ->where(['Messages.startup_id' => $startup_id,'Messages.status'=>'pending'])
            ->contain(['Inspections', 'Customers'])
             ->limit(200)
             ->order(['Messages.id' => 'DESC']); 
            $messages = $query->all()->toArray(); 
        $this->set(compact('messages'));
    }
    

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }
            $query = $this->Messages->find()
            ->where(['Messages.startup_id' => $startup_id])
            ->contain(['Inspections', 'Customers'])
            //  ->contain(['Inspections'])
             ->limit(200)
             ->order(['Messages.id' => 'DESC']); 
            $messages = $query->all()->toArray(); 

        $this->set(compact('messages'));
    }


    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        $message = $this->Messages->get($id, contain: ['Inspections', 'Customers']);
        $this->set(compact('message'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEmptyEntity();
        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $inspections = $this->Messages->Inspections->find('list', limit: 200)->all();
        $customers = $this->Messages->Customers->find('list', limit: 200)->all();
        $this->set(compact('message', 'inspections', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $inspections = $this->Messages->Inspections->find('list', limit: 200)->all();
        $customers = $this->Messages->Customers->find('list', limit: 200)->all();
        $this->set(compact('message', 'inspections', 'customers'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     *
     * Cette partie est reservée aux SMS groupés 
     * 
     */


    //  La page d'accueil
    public function shedule()
    {
        $query = $this->Messages->find()
            ->contain(['Contacts']);
        $messages = $this->paginate($query);
        // $groupes = $this->fetchTable('Teams')->find()->where(['create_uid'=>$this->currentUser->id])->all();
         $groupes = $this->fetchTable('Teams')->find('list', limit: 200)->where(['create_uid'=>$this->currentUser->id])->all();
        // debug($groupes);die();
         $this->set(compact('messages','groupes'));
    }


    
    /**
     * Envoi direct des SMS
     */


     public function sendSms()
    {
        // Accepter uniquement les requêtes POST
        $this->request->allowMethod(['post']);

        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $startup_id = $accountLogin->startup_id;
        }

        $startup = $this->fetchTable('Startups')->find()->where(['id'=>$startup_id])->first();
        $startupTable =  $this->fetchTable('Startups');
        $sms_nbr = $startup->sms_nbr;

        // Récupérer les données du formulaire
        // ATTENTION : $recipient est maintenant une chaîne de numéros séparés par des virgules
        $recipientString = trim($this->request->getData('numero')); 
        $content         = trim($this->request->getData('message'));
        // $nbrMsgForm       = trim($this->request->getData('countMessage'));

        $startupName     = 'TAUKWA';
        
        // debug($nbrMsgForm);die();
       
        // $profileUserTable =  $this->fetchTable('UserProfiles');
        // $profileData = $profileUserTable->find()->where(['user_id'=>$this->currentUser->id])->first();
        // $amount = $profileData->amount;
         $amount = 5000;
        $recipients = explode(',', $recipientString);
        $nbNum = count($recipients);
        $amountRequired =  0.054 * $nbNum;

         // debug($amountRequired);die();
      
        if ($amount < $amountRequired)
        {
            $result = [
                'status' => 'error',
                'code' => '202',
                'msg' => 'Impossible d\'envoyer ce message votre solde est insuffisant , essayez avec moin de numéro.'
            ];
            return $this->Json($result);
        }

        // Séparer la chaîne en un tableau de numéros
        // Cela utilise la liste propre envoyée par le script AJAX
      
        
        // Initialiser les compteurs et les listes de suivi
        $sentCount = 0;
        $invalidNumbers = [];

        // 1. Boucler sur chaque numéro
        foreach ($recipients as $recipient) {
            $currentNumber = trim($recipient); // Nettoyage final
            
            // Si le numéro est vide (cela ne devrait pas arriver avec la logique AJAX, mais sécurité)
            if (empty($currentNumber)) {
                continue;
            }
            // Nettoyage : retirer tous les caractères non numériques
            $cleanedNumber = preg_replace('/[^0-9]/', '', $currentNumber); 
            $operateur     = 'Inconnu';
            $isValid       = false;
            $sender = 'CCT GODWIN';

            // 2. Validation et Détection de l'Opérateur pour le numéro actuel
            // On s'assure qu'il s'agit bien d'un numéro mobile (9 chiffres, commence par 6)
            if (strlen($cleanedNumber) == 9 && str_starts_with($cleanedNumber, '6')) {
                $fullPrefix = substr($cleanedNumber, 0, 3);
                
                // --- BLOCS MTN ---
                if (str_starts_with($fullPrefix, '67') || 
                    ($fullPrefix >= '680' && $fullPrefix <= '683') ||
                    ($fullPrefix >= '650' && $fullPrefix <= '654')
                ) {
                    $operateur = 'MTN';
                    $isValid = true;
                } 
                // --- BLOCS ORANGE ---
                elseif (str_starts_with($fullPrefix, '69') || 
                    ($fullPrefix >= '686' && $fullPrefix <= '689') ||
                    ($fullPrefix >= '655' && $fullPrefix <= '659')
                ) {
                    $operateur = 'Orange';
                    $isValid = true;
                }
            }

            // 3. Traitement basé sur la validation
            if ($isValid && $operateur != 'Inconnu') {
                
                // Définir l'expéditeur (Sender ID)
                
                // --- Logique d'envoi du SMS (DÉCOMMENTER LORSQUE PRÊT) ---
                // $response = $this->sendDirectSms($cleanedNumber, $content, $sender, $operateur);
                // 4. Enregistrement en base de données pour chaque numéro valide

                $message = $this->Messages->newEmptyEntity();
                $message->content    = $content;
                $message->status     = 'sent'; // Supposer que l'envoi réussit ou est en cours
                $message->receiver   = $cleanedNumber; // Enregistrement du numéro nettoyé
                $message->contact_id = 19; // À adapter si vous avez la logique pour trouver l'ID du contact
                $message->sent_date  = new FrozenTime();
                $message->create_uid = $this->currentUser->id;
                $message->write_uid  = $this->currentUser->id;
                $message->uuid       = Text::uuid();
                $message->startup_id      = $startup_id;
               
                //   debug($message);
                //     die();
                // $this->sendDirectSms($recipient,$content,$sender,$operateur,$startupName);
                if ($this->Messages->save($message)) {

                    $startup->sms_nbr -= 1;
                    $startupTable->save($startup);

                    $this->sendDirectSms($recipient,$content,$sender,$operateur,$startupName);
                     $sentCount++;
                } else {
                    // Logique pour gérer l'échec de la sauvegarde en base de données
                }
            } else {
                // Le numéro est invalide (format, ou opérateur inconnu)
                $invalidNumbers[] = $currentNumber;
                // Optionnel : enregistrer le numéro comme "échoué" dans une table de logs
            }
        } // Fin de la boucle foreach

        //    debug('fjf');
        //         die();

        
        // 5. Réponse finale au client
        if ($sentCount > 0) {
            $msg = $sentCount . ' message(s) envoyé(s) avec succès.';
            if (!empty($invalidNumbers)) {
                 $msg .= ' (' . count($invalidNumbers) . ' numéro(s) ignoré(s) ou invalide(s)).';
            }
            $result = [
                'status' => 'success',
                'code' => '200',
                'msg' => $msg
            ];
        } elseif ($sentCount === 0 && !empty($invalidNumbers)) {
            $result = [
                'status' => 'error',
                'code' => '205',
                'msg' => 'Aucun message envoyé. Tous les numéros étaient invalides ou l’opérateur inconnu.'
            ];
        } else {
             $result = [
                'status' => 'error',
                'code' => '500',
                'msg' => 'Une erreur inattendue est survenue. Aucun numéro traité.'
            ];
        }
        
        return $this->Json($result);
    }


  

    /**
     * Envoi direct d’un SMS via l’API AvlyText
     */


    public function sendDirectSms($recipient, $content, $sender)
{
    $apiToken = '1523|0XzFUAtbKmVpjJufqROEEEc9nqePzVquAGiWSv25480b08bf';
    $endpoint = 'https://app.techsoft-sms.com/api/http/sms/send';

    // debug($sender);
    // die();

    $recipient = '237' . $recipient;
    $data = [
        'api_token'  => $apiToken,
        'recipient'  => $recipient,
        'sender_id'  => 'CCT GODWIN',
        'type'       => 'plain',
        'message'    => $content,
    ];

    // $http = new \Cake\Http\Client();

    $http = new Client();

    $response = $http->post(
        $endpoint,
        json_encode($data),
        [
            'type' => 'json',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]
    );

    if ($response->isOk()) {
        //  debug($response->getJson()); die();
    } else {
        // debug($response->getStatusCode());
        // debug($response->getStringBody());
        // die();
    }
}
    
     public function sendDirect($recipient, $content,$sender,$operateur,$startupName)
      {
         // 🚨 CONFIGURATION DE TEST (REMPLACEZ PAR VOS VALEURS RÉELLES) 🚨
        $apiKey    = '1523|0XzFUAtbKmVpjJufqROEEEc9nqePzVquAGiWSv25480b08bf';
        $endpoint  = 'https://app.techsoft-sms.com/api/http/sms/send';
        $chaine_reduite = substr($startupName, 0, 11);
        $chaine_reduite = $sender;


        // if (condition) {
        //    $sender  =  'DosSMS';
        //    $recipient = '+237' .''. 653321288;
        // }else {
        //    $sender =  $chaine_reduite;
        //     $recipient = '+237' .''. 653321288;
        // }

        // $sender =  'CCT GODWIN';
        if (!is_null($operateur)||!empty($operateur))
        {
            if ($operateur == 'MTN') {
            $sender  =  'CCT GODWIN';
            }else
            {
            $sender  =  $chaine_reduite;
            }
        }else
        {
            $sender  =  'CCT GODWIN';
        }

        $sender = 'TECHSOF-SMS';
       
        $recipient = '+237' .''. $recipient;    
        $text      = $content;

        // debug($sender);die();
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
                // debug($response);die();
                $apiResponse = $response->getJson();
                //  debug($apiResponse);die();
                // $this->Flash->success('✅ SMS envoyé avec succès! Statut API: ' . h($apiResponse['status']));
            } else {
                $this->Flash->error('❌ Échec de l\'envoi. Code HTTP: ' . $response->getStatusCode());
                $this->Flash->error('Réponse API: ' . $response->getStringBody());
            }
        
        } catch (\Exception $e) {
           debug($response);die();
        }
    }


    public function sendCampaignSms()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $startup_id = $accountLogin->startup_id;
        }
        $startup = $this->fetchTable('Startups')->find()->where(['id'=>$startup_id])->first();
        $startupTable =  $this->fetchTable('Startups');
        $sms_nbr = $startup->sms_nbr;

        // Accepter uniquement les requêtes POST
        $this->request->allowMethod(['post']);

        // 1. Récupérer et valider les données de la requête
        $groupeId = $this->request->getData('groupe_id');
        $content  = trim($this->request->getData('message'));

        
            $sender = 'CCT GODWIN';
            if (is_null($sender)||empty($sender)) 
            {
                $result = [
                        'status' => 'error',
                        'code' => '202',
                        'msg' => "Configurez le nom d'expéditeur avant de continuer."
                    ];
                return $this->Json($result);
            
            }
        $startupName   = 'CCT GODWIN';

        // debug($startupName);
        // die();
        if (empty($groupeId) || empty($content)) {
            return $this->Json([
                'status' => 'error',
                'code'   => '400',
                'msg'    => 'Groupe ou message manquant.'
            ]);
        }
        // debug($groupeId);die();
        
        // Initialisation des compteurs
        $sentCount = 0;
        $invalidCount = 0;
        // 2. Récupérer les IDs de contact du groupe (via la table de liaison ContactsTeams)
        try {
            $ContactsTeams = $this->fetchTable('ContactsTeams');
            
            // Exécution de la requête (all()) pour obtenir la Collection, puis map()
            $contactIds = $ContactsTeams->find()
                ->select(['contact_id'])
                ->where(['team_id' => $groupeId])
                ->all() // Exécute la requête, retourne la Collection
                ->map(function ($entity) { 
                    return $entity->contact_id;
                })
                ->toArray();
                $nbNum = count($contactIds);
                // debug($sms_nbr);die();

                if ($nbNum > $sms_nbr)
                {
                    $result = [
                        'status' => 'error',
                        'code' => '202',
                        'msg' => 'Impossible d\'envoyer ce message votre solde est insuffisant.'
                    ];
                    return $this->Json($result);
                }
                // debug($amountRequired);die();
        } catch (\Exception $e) {
            return $this->Json([
                'status' => 'error',
                'code'   => '500',
                'msg'    => 'Erreur lors de la récupération des IDs de contact du groupe.'
            ]);
        }
        
        // 3. Récupérer les numéros de téléphone (optimisation : une seule requête IN)
        if (empty($contactIds)) {
            return $this->Json([
                'status' => 'error',
                'code'   => '205',
                'msg'    => 'Le groupe sélectionné ne contient aucun numéro de téléphone.'
            ]);
        }
        // debug($contactIds);die();


        try {
            // debug($groupeId);die();
        $ContactsTable = $this->fetchTable('Contacts');

        // debug($groupeId);die();

            
            // Exécution de la requête (all()) pour obtenir la Collection, puis map()
            $contacts = $ContactsTable->find()
                ->select(['phone'])
                ->where(['Contacts.id IN' => $contactIds]) 
                ->all() // Exécute la requête, retourne la Collection
                ->map(function ($entity) { 
                    return $entity->phone;
                })
                ->toArray();
                //  debug($contacts);die();
        } catch (\Exception $e) {
            //  debug($groupeId);die();
            return $this->Json([
                'status' => 'error',
                'code'   => '500',
                'msg'    => 'Erreur lors de la récupération des données de contact.'
            ]);
        }
        
        // La variable $contacts contient maintenant un tableau de numéros
        $totalAttempts = count($contacts);
        // debug($contacts);die();
        
         
        // 4. Boucle d'envoi et de validation
        foreach ($contacts as $currentNumber) {
            // debug($contacts);die();
            
            $currentNumber = trim($currentNumber);
            
            // Nettoyage et préparation
            $cleanedNumber = preg_replace('/[^0-9]/', '', $currentNumber); 
            $operateur     = 'Inconnu';
            $isValid       = false;

            // Validation et Détection de l'Opérateur (logique de filtrage)
            if (strlen($cleanedNumber) == 9 && str_starts_with($cleanedNumber, '6')) {
                $fullPrefix = substr($cleanedNumber, 0, 3);
                
                // Logique de détection MTN
                if (str_starts_with($fullPrefix, '67') || 
                    ($fullPrefix >= '680' && $fullPrefix <= '683') ||
                    ($fullPrefix >= '650' && $fullPrefix <= '654')
                ) {
                    $operateur = 'MTN';
                    $isValid = true;
                // Logique de détection Orange
                } elseif (str_starts_with($fullPrefix, '69') || 
                    ($fullPrefix >= '686' && $fullPrefix <= '689') ||
                    ($fullPrefix >= '655' && $fullPrefix <= '659')
                ) {
                    $operateur = 'Orange';
                    $isValid = true;
                }
            }

            if ($isValid && $operateur != 'Inconnu') {
                $sender = 'Taukwa';
                $recipient = $cleanedNumber;
                // Enregistrement de l'historique
                $MessagesTable = $this->fetchTable('Messages');
                $message = $MessagesTable->newEmptyEntity();
                $message->content    = $content;
                $message->status     = 'sent';
                $message->receiver   = $cleanedNumber;
                $message->sent_date  = new FrozenTime();
                // Assurez-vous que $this->currentUser existe bien
                $message->create_uid = $this->currentUser->id ?? null; 
                $message->write_uid  = $this->currentUser->id ?? null;
                $message->uuid       = Text::uuid();
                $message->contact_id  =  19;
                $message->startup_id = $startup_id;
                if ($MessagesTable->save($message))
                    {
                    $startup->sms_nbr -= 1;
                    $startupTable->save($startup);
                    // $this->sendDirectSms($recipient,$content,$sender,$operateur,$startupName);
                    $sentCount++;
                } 
            } else {
                $invalidCount++;
            }
        } // Fin de la boucle d'envoi

        //   debug($contactIds);die();

        // 5. Réponse finale
        $msg = "**$sentCount message(s) envoyé(s)** sur $totalAttempts contacts.";
        
        if ($invalidCount > 0) {
            $msg .= " ($invalidCount numéro(s) ignoré(s) ou invalide(s)).";
        }

        $result = [
            'status' => 'success',
            'code' => '200',
            'msg' => $msg
        ];
        return $this->Json($result);
    }
}
