<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Filesystem\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\I18n\FrozenTime;
use Cake\Http\Client;

use function Cake\Error\debug;

/**
 * Teams Controller
 *
 * @property \App\Model\Table\TeamsTable $Teams
 */
class TeamsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     public function index()
    {
         $query = $this->Teams->find()
                ->where(['Teams.create_uid'=> $this->currentUser->id]);
        // $query = $this->Teams->find();
        $teams = $this->paginate($query);
        $this->set(compact('teams'));
    }

    /**
     * View method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
      public function view($uuid)
    {
        $userId = $this->currentUser->id;
    
        //  Récupération du team + contacts
        $team = $this->Teams
            ->findByUuid($uuid)
            ->contain(['Contacts'])
            ->firstOrFail();
    
        //  Nombre de messages programmés
        $sentMessageNbr = $this->fetchTable('Messages')
            ->find()
            ->where([
                'create_uid' => $userId,
                'status' => 'sent'
            ])
            ->count();
    
        //  Nombre de contacts dans l'équipe
        $contactNbr = $this->fetchTable('ContactsTeams')
            ->find()
            ->where(['team_id' => $team->id])
            ->count();
    
        $this->set(compact('team', 'contactNbr', 'sentMessageNbr'));
    }


public function sendGroMessage($uuid)
    {
        $this->request->allowMethod(['post']);

        $team = $this->Teams->find()
            ->where(['uuid' => $uuid])
            ->contain(['Contacts'])
            ->firstOrFail();

        $messageContent = $this->request->getData('message');

        // -- 1. Enregistrer le message en base --
        $messagesTable = $this->fetchTable('Messages');
       

        // -- 2. Envoyer le SMS à tous les contacts --
        foreach ($team->contacts as $contact)
        {
            // Ton service SMS
          
            // $this->Sms->send($contact->phone, $messageContent);
            $message = $messagesTable->newEmptyEntity();
            $message->content    = $messageContent;
            $message->status     = 'sent';
            $message->receiver   = $contact->phone;
            $message->sent_date  = new FrozenTime();
            $message->team_id = $team->id;
            // Assurez-vous que $this->currentUser existe bien
            $message->create_uid = $this->currentUser->id ?? null; 
            $message->write_uid  = $this->currentUser->id ?? null;
            $message->uuid    = Text::uuid();
            // debug($message);die();
            $messagesTable->save($message);
        }
        // -- 3. Confirmation --
        $this->Flash->success("Message enregistré et envoyé à " . count($team->contacts) . " contacts.");
        return $this->redirect($this->referer());
    }
    
     public function sendGroupMessage($uuid)
    {
        $this->request->allowMethod(['post']);
        $team = $this->Teams->find()
            ->where(['uuid' => $uuid])
            ->contain(['Contacts'])
            ->firstOrFail();
        $nbNum = count($team->contacts);
        $profileUserTable =  $this->fetchTable('UserProfiles');
        $profileData = $profileUserTable->find()->where(['user_id'=>$this->currentUser->id])->first();
        $amount = $profileData->amount;
        $amountRequired =  0.054 * $nbNum;
        
        $userProfilData = $this->fetchTable('UserProfiles')->find()->where(['user_id'=>$this->currentUser->id])->first();
        $sender = $userProfilData->company_name;
        if (is_null($sender)||empty($sender)) {
             $this->Flash->error("Configurez le nom d'expéditeur avant de continuer.");
            return $this->redirect($this->referer());
        }
        
        
        if ($amount < $amountRequired)
        {
            $this->Flash->error("Impossible d\'envoyer ces messages votre solde est insuffisant.");
            return $this->redirect($this->referer());
        }
        $messageContent = $this->request->getData('message');

        // -- 1. Enregistrer le message en base --
        $messagesTable = $this->fetchTable('Messages');

        // -- 2. Envoyer le SMS à tous les contacts --
        foreach ($team->contacts as $contact)
        {
            // Ton service SMS
            // debug($contact);die();
            $currentNumber = trim($contact->phone);
        
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
            // $this->Sms->send($contact->phone, $messageContent);
            $message = $messagesTable->newEmptyEntity();
            $message->content    = $messageContent;
            $message->status     = 'sent';
            $message->receiver   = $contact->phone;
            $message->sent_date  = new FrozenTime();
            $message->team_id = $team->id;
            // Assurez-vous que $this->currentUser existe bien
            $message->create_uid = $this->currentUser->id ?? null; 
            $message->write_uid  = $this->currentUser->id ?? null;
            $message->uuid    = Text::uuid();
            // debug($message);die();
            $recipient = $contact->phone;
            $content = $messageContent;
            $startupName = 'TAUKWA';
            if ($messagesTable->save($message)) {
                  $profileData->amount -= 0.054;
                  $profileUserTable->save($profileData);
                  $this->sendDirectSms($recipient,$content,$sender,$operateur,$startupName);
            }
             } else 
             {
               $this->Flash->success("Impossible d'envoyer le message");
               return $this->redirect($this->referer());
             }
        }
        // -- 3. Confirmation --
        $this->Flash->success("Message enregistré et envoyé à " . count($team->contacts) . " contacts.");
        return $this->redirect($this->referer());
    }
    
    
     public function sendDirectSms($recipient, $content,$sender,$operateur,$startupName)
      {
         // 🚨 CONFIGURATION DE TEST (REMPLACEZ PAR VOS VALEURS RÉELLES) 🚨
        $apiKey    = '4IlrXpZRlqp4bLOdjnBCyS6qk68uleWE7ttHRsOyJF7ydOH97Ti6H7llfmDicjdNbuY2';
        $endpoint  = 'https://api.avlytext.com/v1/sms';
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
            $sender  =  'TAUKWA';
            }else{
            $sender  =  $chaine_reduite;
            }
        }else
        {
            $sender  =  'TAUKWA';
        }
        // debug($sender);die();
       
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
                $apiResponse = $response->getJson();
                //  debug($apiResponse);die();
                // $this->Flash->success('✅ SMS envoyé avec succès! Statut API: ' . h($apiResponse['status']));
            } else {
                // $this->Flash->error('❌ Échec de l\'envoi. Code HTTP: ' . $response->getStatusCode());
                // $this->Flash->error('Réponse API: ' . $response->getStringBody());
            }
        
        } catch (\Exception $e) 
        {
          
        }
    }


    public function scheduleGroupMessage($uuid)
    {
        $this->request->allowMethod(['post']);

        $team = $this->Teams->find()
            ->where(['uuid' => $uuid])
            ->contain(['Contacts'])
            ->firstOrFail();
            
        $userProfilData = $this->fetchTable('UserProfiles')->find()->where(['user_id'=>$this->currentUser->id])->first();
        $sender = $userProfilData->company_name;
        if (is_null($sender)||empty($sender)) {
             $this->Flash->error("Configurez le nom d'expéditeur avant de continuer.");
            return $this->redirect($this->referer());
        }
        
        

        $sendAt = $this->request->getData('send_at');
        $content = $this->request->getData('message');
        $messagesTable = $this->fetchTable('Messages');

        foreach ($team->contacts as $contact) {
            $msg = $messagesTable->newEmptyEntity();

            $msg->team_id = $team->id;
            $msg->contact_id = $contact->id;
            $msg->content = $content;
            $msg->receiver = $contact->phone;
            $msg->send_at = $sendAt;
            $msg->status = 'scheduled'; 
            $msg->sent_date  = $sendAt;
            // Assurez-vous que $this->currentUser existe bien
            $msg->create_uid = $this->currentUser->id;
            $msg->write_uid  = $this->currentUser->id;
            $msg->uuid      = Text::uuid();
            // debug($msg);die();
            $messagesTable->save($msg);
        }
        $this->Flash->success("Message programmé pour " . count($team->contacts) . " contacts.");
        return $this->redirect($this->referer());
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
      public function add()
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
        $team = $this->Teams->newEmptyEntity();
        if ($this->request->is('post')) {
            $team = $this->Teams->patchEntity($team, $this->request->getData());
            $team->create_uid = $this->currentUser->id;
            $team->write_uid =  $this->currentUser->id;
             $team->startup_id = $startup_id;
            $team->uuid = Text::uuid();
            // $this->create(60);
            // debug($team);die();
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $contacts = $this->Teams->Contacts->find('list', limit: 200)->where(['create_uid'=>$this->currentUser->id])->toArray();
        $this->set(compact('team', 'contacts'));
     }

    //  Creer des groupes en fonction des types de vehicules
    //  a partir des contacts clients

    public function create($vehicleId)
     {
        $vehicleTable = $this->fetchTable('Vehicles');
        $vehicle = $vehicleTable->find()->where(['id'=>$vehicleId])->contain(['customers'])->first();
     
        debug($vehicle->customer->id);
        die();

        $existingContact = $this->fetchTable('Contacts')->find()
            ->where(['customer_id' => $vehicle->customer->id])
            ->first();

        if ($existingContact) {
            // contact déjà existant → on ne fait rien
            return $existingContact;
        }

        $contact = $this->Contacts->newEntity([
            'customer_id' => $vehicle->customer->id,
            'name'  => $vehicle->customer->name,
            'email' => $vehicle->customer->email,
            'phone' => $vehicle->customer->phone
        ]);

        $this->Contacts->save($contact);

     }


     
       public function import()
    {
        $this->request->allowMethod(['post']);
        $file = $this->request->getData('file');
        $nameGroup = trim($this->request->getData('group_name'));
        $countryCode = '237'; // tu peux le rendre dynamique aussi
        $userId = $this->currentUser->id;

        if (!$file || !$file->getClientFilename()) {
            $this->Flash->error(__('Veuillez choisir un fichier.'));
            return $this->redirect(['action' => 'index']);
        }

        // 1️⃣ Vérifier ou créer le groupe
        $teamsTable = $this->fetchTable('Teams');
        $existingGroup = $teamsTable->find()
            ->where(['name' => $nameGroup, 'create_uid' => $userId])
            ->first();

        if (!$existingGroup) {
            $newGroup = $teamsTable->newEntity([
                'name' => $nameGroup,
                'create_uid' => $userId,
                'write_uid' => $userId,
                'uuid' => Text::uuid()
            ]);
            $teamsTable->save($newGroup);
            $groupId = $newGroup->id;
        } else {
            $groupId = $existingGroup->id;
        }

        // 2️⃣ Sauvegarde temporaire du fichier
        $filePath = WWW_ROOT . 'uploads/' . $file->getClientFilename();
        $file->moveTo($filePath);

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $contacts = [];

        try {
            if ($ext === 'csv') {
                $handle = fopen($filePath, 'r');
                $header = fgetcsv($handle);

                while (($row = fgetcsv($handle)) !== false) {
                    $data = array_combine($header, $row);
                    $contacts[] = [
                        'name' => $data['Name'] ?? null,
                        'phone' => $countryCode . preg_replace('/\D/', '', $data['Phone Number'] ?? ''),
                        'email' => $data['Email'] ?? null,
                        'create_uid' => $userId,
                        'write_uid' => $userId,
                        'uuid' => Text::uuid()
                    ];
                }
                fclose($handle);
            } elseif (in_array($ext, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray(null, true, true, true);
                $header = array_shift($rows);

                foreach ($rows as $row) {
                    $data = array_combine($header, $row);
                    $contacts[] = [
                        'name' => $data['Name'] ?? null,
                        'phone' => $countryCode . preg_replace('/\D/', '', $data['Phone Number'] ?? ''),
                        'email' => $data['Email'] ?? null,
                        'create_uid' => $userId,
                        'write_uid' => $userId,
                        'uuid' => Text::uuid()
                    ];
                }
            }

            if (!empty($contacts)) {
                $contactsTable = $this->fetchTable('Contacts');
                $entities = $contactsTable->newEntities($contacts);
                $savedContacts = $contactsTable->saveMany($entities);

                if ($savedContacts) {
                    // 3️⃣ Associer les contacts au groupe
                    $contactsTeamsTable = $this->fetchTable('ContactsTeams');
                    $relations = [];

                    foreach ($savedContacts as $contact) {
                        $relations[] = [
                            'contact_id' => $contact->id,
                            'team_id' => $groupId
                        ];
                    }

                    $relationsEntities = $contactsTeamsTable->newEntities($relations);
                    $contactsTeamsTable->saveMany($relationsEntities);

                    $this->Flash->success(count($savedContacts) . ' contacts importés et ajoutés au groupe "' . h($nameGroup) . '".');
                } else {
                    $this->Flash->warning(__('Erreur lors de l’enregistrement des contacts.'));
                }
            } else {
                $this->Flash->warning(__('Aucun contact trouvé dans le fichier.'));
            }

        } catch (\Exception $e) {
            $this->Flash->error(__('Erreur lors de l’importation : ') . $e->getMessage());
        }
        return $this->redirect(['action' => 'index']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($uuid)
    {
        $team = $this->Teams->findByUuid($uuid)->contain(['Contacts'])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $team = $this->Teams->patchEntity($team, $this->request->getData());
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $contacts = $this->Teams->Contacts->find('list', limit: 200)->all();
        $this->set(compact('team', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($uuid)
    {
        $this->request->allowMethod(['post', 'delete']);
        $team = $this->Teams->findByUuid($uuid)->first(); 
        if ($this->Teams->delete($team)) {
            $this->Flash->success(__('The team has been deleted.'));
        } else {
            $this->Flash->error(__('The team could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
