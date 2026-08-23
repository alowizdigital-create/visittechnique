<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Reminder;
use App\Model\Entity\User;
use App\Model\Entity\Vehicle;
use Cake\I18n\Date;
use Cake\Utility\Text;
use Cake\Mailer\Mailer;
use DateTime;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Http\Client; 

use function PHPUnit\Framework\isNull;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login','add','home','validsignup','obsolete','getvalidlink','forgotpassword','ressetpassword','welcome']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $this->viewBuilder()->setLayout('authentification');
        if ($this->request->is('post')){
            $email = $this->request->getData('email');
            $user = $this->Users->findByEmail($email)->first();
        if (!$user) {
            return $this->Json([
                'code' => 104,
                'msg' => 'Ce compte n\'existe pas ou a été supprimé faute de validation.'
            ]);
        }
        if ($user->verified !== true) {
            return $this->Json([
                'code' => 105,
                'msg' => 'Compte non activé, verifiez votre boite email pour l\'activation.'
            ]);
        }
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // redirect to /articles after login success
              return $this->Json(['code'=>100,
                                  'msg'=>'Connexion réussie.']);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
           return $this->Json(['code'=>105,
                                  'msg'=>'Mot de passe ou adresse email invalide.']);
        }
        }
    }
    
    
    
   public function welcome() {
        $this->viewBuilder()->setLayout('visitor');
   }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'home']);
        }
    }
    
    public function forgotpassword() {
        $user = $this->Users->newEmptyEntity();
        $this->viewBuilder()->setLayout('authentification');
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
            $email = $data['email'];
            $psw1 = $data['password'];
            $psw2 = $data['password2'];
            $user = $this->Users->find()->where(['email'=>$email])->first();
            if(empty($user)){
                  return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Ce compte n\'existe pas .']);
            }
            if (strlen($data['password']) < 6) {
                 return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Le mot de passe doit contenir au moins 6 caractères.']);
            }
            elseif ($psw1 <> $psw2) {
                 return $this->Json(['status'=>0, 'error'=>4,
                                  'message'=>'Mot de passe non identique.']);
            }
            else {
            $token = text::uuid();
            $user->uuid =  $token;
            $user->token_expires = (new \DateTime())->modify('+3 hours');
            // debug($user);
            // exit();
            $this->ressetmail($token, $email);
            if ($this->Users->save($user)) {
                $email = $user->email;
                    return $this->Json(['status'=>1, 'error'=>0,
                                'message'=>'Vérifiez votre adresse e-mail pour continuer.
                                            Nous venons de vous envoyer un e-mail à l\'adresse : ' . $email . ' .
                                            Veuillez vérifier votre boite e-mail et cliquer sur le lien fourni pour modifier votre mot de passe.',
                                // 'redirect' => 'login' 
                            ]);
            }
            $this->Flash->error(__('Impossible de modifier le mot de passe, Veuillez réessayer.'));
            }
        }
        $this->set(compact('user'));
    }
       public function ressetmail($token , $email)
    {
        $mailer = new Mailer();
        $mailer
            ->setEmailFormat('html')
            ->setTo($email)
            ->setSubject('Resset password')
            ->setFrom('alowizgb@gmail.com')
            ->setViewVars([
                'token' => $token,
            ])
            ->viewBuilder()
                ->setTemplate('ressetpassword')
                ->setLayout('sympa');
        $mailer->deliver();
    }
     public function account(){
        
    }


    public function ressetpassword($token){
       $user = $this->Users->find()->where(['uuid'=>$token])->first();
       debug($user);
       exit();
       if (empty($user)) {
            return $this->Json(['code'=>50,
                                'msg'=>'Ce compte n\'existe pas ou a été supprimé.']);
       }
       $token = Text::uuid();
       $email = $user->email;
       $user->uuid = $token;
       $user->token_expires = (new \DateTime())->modify('+3 hours');
       $this->ressetmail($token, $email);
       if ($this->Users->save($user)) {
                return $this->Json(['code'=>50,
                                'msg'=>'Compte créé avec succès , vous eu un email de validation de compte.']);
        }
                return $this->Json(['code'=>55,
                                'msg'=>'Echec de création de compte.']);
    }
    
     public function collabots() {
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
        $query = $accountTable->find()->where(['startup_id'=> $startup_id ]);
        $collabots = $this->paginate($query);
        $this->set(compact('collabots'));
    }

       public function addCollabot()
    {
        $accountTable = $this->fetchTable('Accounts');
        $this->viewBuilder()->setLayout('add');
        $account = $accountTable->newEmptyEntity();
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
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
            // Vérification du mot de passe
            $phone = $data['phone'];
            $userexist = $accountTable->find()->where(['phone'=>$phone])->first();
            if(!empty($userexist)){
                  return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Un compte existe déjà avec ce numero.']);
            }
            $account = $accountTable->patchEntity($account, $data);
            $token = text::uuid();
            if ($data['role'] == 0) {
                $account->role = 'directeur';
            }elseif($data['role'] == 1){
                $account->role = 'comptable';
            }elseif($data['role'] == 2){
                $account->role = 'caissier';
            }else{
                $account->role = 'secretaire';
            }
            $name = $data['name'];
            $nameWithoutSpace = str_replace(' ', '', $name); 
            $autoPassword = random_int(100000, 999999);
            $account->uuid =  $token;
            $account->name = $data['name'];
            $account->phone = $data['phone'];
            $account->startup_id =  $startup_id;
            $account->create_uid = 1;
            $account->write_uid = 1;
            $account->username = $nameWithoutSpace;
            $account->passwordshow = $autoPassword;
            $account->password =  (string)$autoPassword;
            debug($account);exit();
            if ($accountTable->save($account)) {
                    return $this->Json(['status'=>1, 'error'=>0,
                                'message'=>'Collaborateur créer avec succès !',
                            ]);
            }
            $this->Flash->error(__('Impossible de créer le compte. Veuillez réessayer.'));
        }
        // $this->set(compact('account'));
    }
   

    public function updateAccount() {
        $this->request->allowMethod(['post']);
    
        $data = $this->request->getData();
        $uuid = $data['uuid'];
    
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        
        
        // Cherche l'utilisateur soit dans la table Accounts, soit dans la table Admins
        $user = $accountTable->findByUuid($uuid)->first() ?? $adminTable->findByUuid($uuid)->first();
        debug($user);
        die();
    
        if ($user) {
            // Met à jour les informations de base
            $user->name = $data['name'];
            $user->phone = $data['phone'];
            
            // C'est mieux de ne pas mettre le mot de passe en dur
            // et de le mettre à jour uniquement si le champ est rempli
            if (!empty($data['password'])) {
                $user->password = $data['password'];
                 $user->passwordshow = $data['password'];
            }
    
            // Gestion de l'importation de la photo si elle est présente
            if (!empty($data['file_content'])) {
                // Sépare les métadonnées Base64 du contenu réel
                list($type, $fileContent) = explode(';', $data['file_content']);
                list(, $fileContent) = explode(',', $fileContent);
    
                // Décode le contenu Base64
                $fileData = base64_decode($fileContent);
                $fileName = $data['file_name'];
                
                // Correction ici : ajoute le nom du fichier à la destination
                $destination = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $fileName;
    
                // Crée le répertoire s'il n'existe pas
                if (!is_dir(dirname($destination))) {
                    mkdir(dirname($destination), 0755, true);
                }
                
                // Sauvegarde le fichier sur le serveur
                file_put_contents($destination, $fileData);
                $user->profile = $fileName;
            }
    
            // Sauvegarde l'entité mise à jour
            if (($user->getSource() == 'Accounts' && $accountTable->save($user)) || ($user->getSource() == 'Admins' && $adminTable->save($user))) {
                return $this->Json([
                    'status' => 1,
                    'error' => 0,
                    'message' => 'Informations mises à jour avec succès.',
                ]);
            } else {
                return $this->Json([
                    'status' => 0,
                    'error' => 9,
                    'message' => 'Impossible de modifier les informations. Veuillez vérifier les données.',
                ]);
            }
        } else {
            return $this->Json([
                'status' => 0,
                'error' => 9,
                'message' => 'Utilisateur non trouvé.',
            ]);
        }
    }

     public function dashboard()
    {
        // --- 1. INITIALISATION ET DATES ---
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $today = new \DateTimeImmutable();
        $todayFormatted = $today->format('Y-m-d');
    
        // Début et fin du jour
        $startOfDay = $today->setTime(0, 0, 0);
        $endOfDay = $today->setTime(23, 59, 59);
    
        // Début et fin du mois courant (pour les messages)
        $startOfMonth = $today->modify('first day of this month')->setTime(0, 0, 0);
        $endOfMonth = $today->modify('last day of this month')->setTime(23, 59, 59);
    
        // Détermination de l'utilisateur et de la startup_id
        $adminLogin = $adminTable->findById($user->id)->first();
        $logUser = null;
    
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
            $logUserId = $adminLogin->id;
            $logUser = $adminLogin;
        } else {
            $accountLogin = $accountTable->findById($user->id)->first();
            if ($accountLogin) {
                $startup_id = $accountLogin->startup_id;
                $logUserId = $accountLogin->id;
                $logUser = $accountLogin;
            } else {
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
        }
    
        $cashBoxLoginAccount = $this->fetchTable('CashBoxes')->findByResponsableId($logUserId)->first();
        $cashMov = $this->fetchTable('CashMovements');
        $vehiclesTable = $this->fetchTable('Vehicles');
        $inspectionsTable = $this->fetchTable('Inspections');
    
        // --- 2. AUTOMATISATION DES INSPECTIONS ---
    
          $expiredInspectionsIds = $inspectionsTable
            ->find('list', keyField: 'id', valueField: 'id')
            ->where([
                'Inspections.end_date <' => $today,
                'Inspections.status' => 'confirm',
            ])
            ->group(['id'])
            ->toArray();
         
        // 2.3. Récupération des IDs de véhicules expirés
       $expiredVehicleIds = $inspectionsTable
                ->find('list', keyField: 'vehicle_id', valueField: 'vehicle_id')
                ->where([
                    'Inspections.end_date <' => $today,
                    'Inspections.status' => 'confirm',
                ])
                ->group(['vehicle_id'])
                ->toArray();

            $expiredVehicleIds = array_keys($expiredVehicleIds);
            // 2.4. Mise à jour du statut 'next_shedule'
            if (!empty($expiredVehicleIds)) {
                $vehicles = $vehiclesTable->find()
                    ->where([
                        'Vehicles.id IN' => $expiredVehicleIds,
                        'Vehicles.startup_id' => $startup_id,
                        'Vehicles.next_shedule' => 1,
                    ])
                    ->all();
                foreach ($vehicles as $vehicle) {
                    $vehicle->next_shedule = 0;
                    $vehiclesTable->save($vehicle); // ✅ save() déclenche les événements
                }
            }


         // 2.2. Mise à jour groupée : fermer les inspections expirées
        if (!empty($expiredInspectionsIds)) {
            $inspectionsTable->updateAll(
                ['status' => 'close'],
                ['id IN' => $expiredInspectionsIds]
            );
        }
    
        // --- 3. CALCUL DU CHIFFRE D'AFFAIRES JOURNALIER ---
        $role = $logUser->role;
        $conditionsCash = [
            'created >=' => $startOfDay,
            'created <=' => $endOfDay,
            'startup_id' => $startup_id,
        ];
    
        $daylyCash = 0;
    
        if (!in_array($role, ['directeur', 'admin'])) {
            if (!empty($cashBoxLoginAccount)) {
                $conditionsCash['cash_box_id'] = $cashBoxLoginAccount->id;
            } else {
                goto skip_cash_calculation;
            }
        }
    
        $sum = $cashMov->find('all')
            ->select(['total' => $cashMov->find('all')->func()->sum('montant')])
            ->where($conditionsCash)
            ->first();
    
        $daylyCash = $sum ? $sum->total : 0;
    
        skip_cash_calculation:
    
        // --- 4. RÉCUPÉRATION DES LISTES ET STATISTIQUES ---
        $commonWhere = [
            'OR' => [
                'create_uid' => $this->currentUser->id,
                'startup_id' => $startup_id,
            ],
        ];
    
        $customers = $this->fetchTable('Customers')
            ->find('list', limit: 200)
            ->where($commonWhere)
            ->all();
    
        $genders = $this->fetchTable('Genders')
            ->find('list', limit: 200)
            ->where($commonWhere)
            ->all();
    
        // 4.2. Statistiques des messages
        $thisMonthMessages = $this->fetchTable('Messages')->find('all')
            ->where([
                'Messages.startup_id' => $startup_id,
                'status' => 'sent',
                'sent_date >=' => $startOfMonth,
                'sent_date <=' => $endOfMonth,
            ])
            ->count();
        $allPendingMessages = $this->fetchTable('Messages')->find('all')
            ->where([
                'Messages.startup_id' => $startup_id,
                'status' => 'pending',
                'sent_date >' => $today,
            ])
            ->count();
    
        $allVehicle = $vehiclesTable->find('all')
            ->where(['startup_id' => $startup_id])
            ->count();
    
        // --- 5. ENVOI À LA VUE ---
        $this->set(compact(
            'allPendingMessages',
            'daylyCash',
            'allVehicle',
            'customers',
            'genders',
            'thisMonthMessages'
        ));
    }



    public function addVehicles() {
        $Vehicles = $this->fetchTable('Vehicles');
        // debug($Vehicles);
        // exit();
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
            $Customers = $this->fetchTable('Customers');
            $customer = $Customers->newEmptyEntity();
            $customer_id = $data['customer_id'];
         
            if (!empty($data['newName'])) {
                $customer->name =  $data['newName'];
                $customer->phone = $data['newPhone'];
                $customer->create_uid = $this->currentUser->id;
                $customer->write_uid = $this->currentUser->id;
                $customer->uuid = Text::uuid();
                if ($Customers->save($customer)) {
                    $customer_id = $customer->id;
                } 
            }
            $vehicle = $Vehicles->newEmptyEntity();
            $vehicle->customer_id =  $customer_id;
            $vehicle->gender_id = $data['gender_id']; 
            $vehicle->registration_number = $data['matricule'];
            $vehicle->create_uid = $this->currentUser->id;
            $vehicle->write_uid = $this->currentUser->id;
            $vehicle->uuid = Text::uuid();
            if ($Vehicles->save($vehicle)) {
                $vehicle_id = $vehicle->id;
                $gender_id = $vehicle->gender_id;
                $Inspections = $this->fetchTable('Inspections');
                $inspection = $Inspections->newEmptyEntity();
                $inspection->vehicle_id = $vehicle_id;
                $inspection->gender_id = $gender_id;
                $inspection->status = 'confirm';
                $inspection->customer_id = $data['customer_id'];
                $inspection->end_date = (new DateTime())->modify('+90 days');
                $inspection->create_uid = $this->currentUser->id;
                $inspection->write_uid = $this->currentUser->id;
                $inspection->uuid = Text::uuid();
                debug($inspection);
                exit();
                if ($Inspections->save($inspection)) {
                    $customer = $this->fetchTable('Customers')->find()
                                 ->where(['id'=> $inspection->customer_id ])->first();
                    //              debug($numberPhone);
                    // exit();
                    $Messages = $this->fetchTable('Messages');
                    $Templates = $this->fetchTable('Templates');
                    $Reminders = $this->fetchTable('Reminders');
                    $reminder = $Reminders->find()->where(['gender_id'=> $gender_id])->first();
                    $template_id = $reminder['template_id'];
                    $template = $Templates->find()->where(['id'=> $template_id])->first();
                    $content = $template['content'];
                    $replacements = [
                       '[name]' => $customer['name'] ?? '',
                     ];
                    $finalContent = str_replace(array_keys($replacements), array_values($replacements), $content);
                    $message = $Messages->newEmptyEntity();
                    $message->content = $finalContent;
                    $message->status = 'pending';
                    $message->receiver =  $customer['phone'];
                    $message->inspection_id = $inspection->id;
                    $message->customer_id = $inspection->customer_id;
                    $message->sent_date = $inspection->end_date;
                    $message->create_uid = $this->currentUser->id;
                    $message->write_uid = $this->currentUser->id;
                    $message->uuid = Text::uuid();
                    // debug($message);exit();
                    if ($Messages->save($message)) {
                           $result = ['code'=>'200','msg'=>'Véhicule enregisté']; 
                           return $this->Json($result);
                        }
                    }
                $result = ['code'=>'200','msg'=>'Véhicule enregisté']; 
                return $this->Json($result);
                // debug($vehicle);exit();
                // $this->Flash->success(__('The vehicle has been saved.'));
                // return $this->redirect(['action' => 'index']);
            }
           
        }
    }


    
   public function newRelance() {
        if($this->request->is('post','ajax')){
            $register = $this->request->getData('matricule');
           $vehicle = $this->fetchTable('Vehicles')->find()->where(['registration_number'=>$register])->first();
           if (empty($vehicle)) {
                $result = ['code'=>'50','msg'=>'Ce véhicule n\'existe pas ou a été supprimé'];
                return $this->Json($result);
           }else{

            if ($vehicle->next_shedule == 1)
            {
                $result = ['code'=>'50','msg'=>'Véhicule déja relancé.'];
                return $this->Json($result);
            }
            $idCustomer = $vehicle->customer_id;
            $customer = $this->fetchTable('Customers')->find()->where(['id'=>$idCustomer])->first();
            $gender_id = $vehicle['gender_id'];
            $gender = $this->fetchTable('Genders')->find()->where(['id'=> $gender_id])->first(); 
            $price = $gender['price'];
           $discount = $this->fetchTable('Discounts')->find()
                ->select(['amount'])
                ->where(['gender_id'=> $gender_id])
                ->first();
            $endDate = $this->fetchTable('Discounts')->find()
                ->select(['end_date'])
                ->where(['gender_id'=> $gender_id])
                ->first();
                $today = new \DateTime();
                $todayDate = $today->format('Y-m-d');
                // debug($endDate);exit();
            if (is_null($discount) || $endDate < $todayDate) {
              $discountEnd = 0;
            }else{
                $discountEnd = $discount['amount'];
            }
            // debug($discountEnd);die();
            $customerPhone = $customer->phone;
            $customerName = $customer->name;
            $amountEnd = $price;
            // recuperer toutes les redcutions
            $discounts = $this->fetchTable('Discounts')
                                    ->find('list', keyField: 'id', valueField: 'amount')
                                    ->toArray();
            $result = ['code'=>'200','msg'=>'Ce véhicule n\'existe pas ou a été supprimé','price'=>$price,'discounts'=>$discountEnd,'customerPhone'=> $customerPhone,'customerName'=> $customerName,'register'=> $register,'gender'=> $gender['name'] ,'gender_id'=> $gender_id ];
            return $this->Json($result);
            }
        }
    }


public function confirmPayment() {
    if ($this->request->is(['ajax', 'post'])) {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        
        // 1. DÉTERMINATION DU STARTUP_ID (avec vérifications)
        $adminLogin = $adminTable->findById($user->id)->first();
        $startup_id = null;
        
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        } else {
            $accountLogin = $accountTable->findById($user->id)->first();
            if ($accountLogin) {
                $startup_id = $accountLogin->startup_id;
            }
        }

        if (empty($startup_id)) {
            return $this->Json(['code' => '403', 'msg' => 'Identifiant de startup non trouvé pour cet utilisateur.']);
        }

        $thisStatupData = $this->fetchTable('Startups')->find()->where(['id' => $startup_id])->first();
        // if ($thisStatupData->sms_nbr < 4) {
        //     return $this->Json(['code' => '404', 'msg' => 'Vous n\'avez de SMS pour encaisser le client.']);
        // }
        
        // if (!$thisStatupData) {
        //     return $this->Json(['code' => '404', 'msg' => 'Données de startup non trouvées.']);
        // }
            
        $register = $this->request->getData('register');
        $amount = $this->request->getData('amount');
        $discount = $this->request->getData('discount');

        // 2. CALCUL DU MONTANT FINAL
        if ($discount !== 'Selectionnez' && is_numeric($discount) && is_numeric($amount)) {
            $amountEnd = $amount - $discount;
        } else {
            $amountEnd = $amount;
        }

        $gender_id = $this->request->getData('gender_id');

        // 3. VÉRIFICATION DU GENDER (TYPE DE VISITE)
        $findGender = $this->fetchTable('Genders')->findById($gender_id)->first();
        if (!$findGender) {
            return $this->Json(['code' => '404', 'msg' => 'Type de visite (Gender) non trouvé.']);
        }
        $duration = $findGender->numbermonthvisit; // e.g., 3, 6, 9, 12

        $cashBoxTable = $this->fetchTable('CashBoxes');
        $userId = $this->currentUser->id;
        $cashBox = $cashBoxTable->findByResponsableId($userId)->first();

        // 4. VÉRIFICATION DE LA CAISSE
        if (!$cashBox) {
            return $this->Json(['code' => '201', 'msg' => 'Vous n\'avez pas de caisse']);
        }

        // 5. VÉRIFICATION DES DONNÉES ESSENTIELLES
        if (empty($register) || empty($amount)) {
            return $this->Json(['code' => '400', 'msg' => 'Information manquante (immatriculation ou montant)']);
        }
        
        // 6. VÉRIFICATION DU VÉHICULE
        $Vehicles = $this->fetchTable('Vehicles');
        $vehicle = $Vehicles->find()->where(['registration_number' => $register])->first();
        if (!$vehicle) {
            return $this->Json(['code' => '404', 'msg' => 'Véhicule non trouvé pour cette immatriculation.']);
        }
        $lastvisitDate = $vehicle->lastvisitdate;

        // 7. CRÉATION ET MISE À JOUR DE L'INSPECTION
        $Inspections = $this->fetchTable('Inspections');
        $inspection = $Inspections->newEmptyEntity();

        $inspection->vehicle_id = $vehicle->id;
        $inspection->gender_id = $gender_id;
        $inspection->status = 'confirm';
        $inspection->customer_id = $vehicle->customer_id;
        
        // Calcul de la date de fin (basé sur la durée et la dernière visite)
        $startDate = is_null($lastvisitDate) ? new FrozenTime() : clone $lastvisitDate;

        if ($duration == 3) {
            $inspection->end_date = $startDate->modify('+3 months');
        } elseif ($duration == 6) {
            $inspection->end_date = $startDate->modify('+6 months');
        } elseif ($duration == 9) {
            $inspection->end_date = $startDate->modify('+9 months');
        } else {
            $inspection->end_date = $startDate->modify('+12 months');
        }
        $inspectionUuid =  Text::uuid();
        $inspection->create_uid = $this->currentUser->id;
        $inspection->write_uid = $this->currentUser->id;
        $inspection->uuid =  $inspectionUuid;
        $inspection->startup_id = 12;
        $vehicle->next_shedule = 1;
        $vehicle->shedule = 1; 
        // Pour des raisons d erreurs le champ brand est utilisé pour stocker uuid de l'inpection 
        // ce mecanisme est mis en en place pour le passage chaque vehicule a l'entreprise au centre cela permet de retrouver la derniere inspection liée a ce vehicule 
        $vehicle->brand = $inspectionUuid;
        // debug($vehicle);die();
        // Tentative de sauvegarde
        if ($Vehicles->save($vehicle) && $Inspections->save($inspection)) {
            
            // 8. RÉCUPÉRATION ET VÉRIFICATION DU CLIENT
            $customer = $this->fetchTable('Customers')->find()
                ->where(['id' => $inspection->customer_id])
                ->first();
            
            if (!$customer) {
                return $this->Json(['code' => '200', 'msg' => 'Encaissement enregistré, mais client introuvable pour les relances.']);
            }

            $Reminders = $this->fetchTable('Reminders');
            $reminder = $Reminders->find()->where(['gender_id' => $gender_id])->first();

            if (empty($reminder)) {
                return $this->Json(['code' => '200', 'msg' => 'Encaissement enregistré, mais pas de configurations de relance pour ce type de visite.']);
            }

            // 9. MESSAGES DE RELANCE (Définition des variables de remplacement)
            $Messages = $this->fetchTable('Messages');

            $replacements = [
                '[immatriculation]' => $register ?? '',
                '[nom entreprise]' => $thisStatupData->name ?? '',
                '[name]' => $customer->name ?? '',
                '[date]' => $inspection->end_date ? $inspection->end_date->format('d/m/Y') : '',
            ];

            // Verification de numero mtn ou orange
            $recipient = $customer->phone;
            $nameOfStartup = $thisStatupData->name;
           
            if ($thisStatupData->name != 'CCT GODWIN ')
                {
                $cleanedNumber = preg_replace('/[^0-9]/', '', $recipient);
             

                // On s'assure qu'il s'agit bien d'un numéro mobile (9 chiffres, commence par 6)
                if (strlen($cleanedNumber) !== 9 || !str_starts_with($cleanedNumber, '6')) {
                    return "Erreur : Format de numéro invalide ou inconnu.";
                }
                
                // Récupère les trois premiers chiffres : '653', '699', '677', etc.
                $fullPrefix = substr($cleanedNumber, 0, 3);
                $operateur = 'Inconnu';

                // 2. Logique d'identification (basée sur les trois premiers chiffres)
                
                // --- BLOCS MTN ---
                // Liste des préfixes MTN (67X, 680-683, 650-654)
                if (str_starts_with($fullPrefix, '67') || 
                    ($fullPrefix >= '680' && $fullPrefix <= '683') ||
                    ($fullPrefix >= '650' && $fullPrefix <= '654')
                ) {
                    $operateur = 'MTN';
                } 
                // --- BLOCS ORANGE ---
                // Liste des préfixes Orange (69X, 686-689, 655-659)
                elseif (str_starts_with($fullPrefix, '69') || 
                    ($fullPrefix >= '686' && $fullPrefix <= '689') ||
                    ($fullPrefix >= '655' && $fullPrefix <= '659')
                ) {
                    $operateur = 'Orange';
                }
                
                // --- ENREGISTREMENT DU MESSAGE DE REMERCIEMENT (HORS BOUCLE) ---
            
                if ($operateur == 'Orange')
                {
                    $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
                }else {
                    $thankYouContent = 'Cher client, [nom entreprise] vous remercie pour la visite technique du véhicule [immatriculation]. Nous apprécions votre confiance.';
                }
            }else {
                $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
            }
            
            // debug($thankYouContent);die();
            
                // 1. Nettoyage et extraction des 3 premiers chiffres (le préfixe complet)
            // $cleanedNumber = preg_replace('/[^0-9]/', '', $recipient);
            // debug($cleanedNumber);die();

            // On s'assure qu'il s'agit bien d'un numéro mobile (9 chiffres, commence par 6)
            // if (strlen($cleanedNumber) !== 9 || !str_starts_with($cleanedNumber, '6')) {
            //     return "Erreur : Format de numéro invalide ou inconnu.";
            // }
            
            // Récupère les trois premiers chiffres : '653', '699', '677', etc.
            // $fullPrefix = substr($cleanedNumber, 0, 3);
            // $operateur = 'Inconnu';

            // 2. Logique d'identification (basée sur les trois premiers chiffres)
            
            // --- BLOCS MTN ---
            // Liste des préfixes MTN (67X, 680-683, 650-654)
            // if (str_starts_with($fullPrefix, '67') || 
            //     ($fullPrefix >= '680' && $fullPrefix <= '683') ||
            //     ($fullPrefix >= '650' && $fullPrefix <= '654')
            // ) {
            //     $operateur = 'MTN';
            // } 
            // --- BLOCS ORANGE ---
            // Liste des préfixes Orange (69X, 686-689, 655-659)
            // elseif (str_starts_with($fullPrefix, '69') || 
            //     ($fullPrefix >= '686' && $fullPrefix <= '689') ||
            //     ($fullPrefix >= '655' && $fullPrefix <= '659')
            // ) {
            //     $operateur = 'Orange';
            // }
            
            // --- ENREGISTREMENT DU MESSAGE DE REMERCIEMENT (HORS BOUCLE) ---
           
            // if ($operateur == 'Orange')
            // {
            //     $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
            // }else {
            //     $thankYouContent = 'Cher client, [nom entreprise] vous remercie pour la visite technique du véhicule [immatriculation]. Nous apprécions votre confiance.';
            // }
            // $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
        
            $finalThankYouContent = str_replace(array_keys($replacements), array_values($replacements), $thankYouContent);

            $message = $Messages->newEmptyEntity();
            $message->content = $finalThankYouContent;
            $message->status = 'sent';
            $message->receiver = $customer->phone;
            $message->inspection_id = $inspection->id;
            $message->startup_id = $startup_id;
            $message->customer_id = $inspection->customer_id;
            $message->sent_date = new FrozenTime(); // CORRECTION: Utilisation de FrozenTime()
            $message->create_uid = $this->currentUser->id;
            $message->write_uid = $this->currentUser->id;
            $message->uuid = Text::uuid();
            $content = $finalThankYouContent;
            $startupName = $thisStatupData->name;
           
             if (!empty($nameOfStartup) && $nameOfStartup == 'CCT GODWIN ')
             {
                $this->sendSms(
                    $recipient,
                    $content,
                    $startupName,
                    $operateur ?? ''
                );
            }
            // $this->sendSms($recipient,$content,$startupName,$operateur ?? '');
            $thisStartupTable = $this->fetchTable('Startups');
            $startupData = $thisStartupTable->findById($startup_id)->first();
            $startupData->sms_nbr -= 1;
            // debug($startupData);die();
            $thisStartupTable->save($startupData);
            $Messages->save($message);
            // -----------------------------------------------------------------
            
            // Templates pour les relances DIFFÉRÉES (sans le remerciement)
            $messageTemplates = [
                // Message 1: 7 jours avant l'expiration
                [
                    'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire dans une semaine. Merci de la renouveler.',
                    'offset' => '-7 days',
                ],
                // Message 2: 3 jours avant l'expiration
                
                // [
                //     'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire dans 3 jours. Pensez à la renouveler à temps.',
                //     'offset' => '-3 days',
                // ],
                
                // Message 3: Le jour de l'expiration
                [
                    'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire aujourd\'hui le [date]. Merci de la renouveler.',
                    'offset' => null, // Date d'expiration
                ],
            ];

            // 10. ENREGISTREMENT DES RELANCES DIFFÉRÉES (Boucle)
            foreach ($messageTemplates as $template) {
                $finalContent = str_replace(array_keys($replacements), array_values($replacements), $template['content']);
                $message = $Messages->newEmptyEntity();
                
                $message->content = $finalContent;
                $message->status = 'pending';
                $message->receiver = $customer->phone;
                $message->inspection_id = $inspection->id;
                $message->startup_id = $startup_id;
                $message->customer_id = $inspection->customer_id;
                
                if ($template['offset'] !== null) {
                    // Calcul basé sur le décalage (J-7 ou J-3)
                    // Utilisation de FrozenTime pour la manipulation de date dans CakePHP
                    $message->sent_date = (new FrozenTime($inspection->end_date))->modify($template['offset']); 
                } else {
                    // Date d'expiration (Jour J)
                    $message->sent_date = $inspection->end_date; 
                }
                
                $thisStartupTable = $this->fetchTable('Startups');
                $startupData = $thisStartupTable->findById($startup_id)->first();
                $startupData->sms_nbr -= 1;
                // debug($startupData);die();
                $thisStartupTable->save($startupData);
                
                $message->create_uid = $this->currentUser->id;
                $message->write_uid = $this->currentUser->id;
                $message->uuid = Text::uuid();
                $Messages->save($message); // Sauvegarde des relances
            }
            
            // 11. CRÉATION ET MISE À JOUR DU MOUVEMENT DE CAISSE
            $cashMovTable = $this->fetchTable('CashMovements');
            $cashMov = $cashMovTable->newEmptyEntity();
            $cashMov->montant = $amountEnd;
            $cashMov->cash_box_id = $cashBox->id;
            $cashMov->type = 'entrée';
            $cashMov->motif_id = 2;
            $cashMov->startup_id = $startup_id;
            $cashMov->inspection_id = $inspection->id;
            $cashMov->user_id = $this->currentUser->id;
            $cashMov->justificatif = 'justificatif';
            $cashMov->create_uid = $this->currentUser->id;
            $cashMov->uuid = Text::uuid();

            if ($cashMovTable->save($cashMov)) {
                $cashBox->cashinout += 0;
                $cashBox->cashinput += $amountEnd;
                $cashBox->solde_actuel += $amountEnd;
                
                if ($cashBoxTable->save($cashBox)) {
                    return $this->Json(['code' => '200', 'msg' => 'Encaissement et relance enregistrés avec succès.']);
                }
            }
        }
        
        // Retour d'erreur en cas d'échec de sauvegarde (Inspection ou Mouvement de caisse)
        return $this->Json(['code' => '500', 'msg' => 'Une erreur est survenue lors de l\'enregistrement de l\'inspection ou du mouvement de caisse.']);
    }
    }
    
    
    public function confirmRelance() 
    {
        if ($this->request->is(['ajax', 'post'])) {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        
        // 1. DÉTERMINATION DU STARTUP_ID (avec vérifications)
        $adminLogin = $adminTable->findById($user->id)->first();
        $startup_id = null;
        // debug($startup_id);die();
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        } else {
            $accountLogin = $accountTable->findById($user->id)->first();
            if ($accountLogin) {
                $startup_id = $accountLogin->startup_id;
            }
        }

        if (empty($startup_id)) {
            return $this->Json(['code' => '403', 'msg' => 'Identifiant de startup non trouvé pour cet utilisateur.']);
        }

        $thisStatupData = $this->fetchTable('Startups')->find()->where(['id' => $startup_id])->first();
        //   if ($thisStatupData->sms_nbr < 4) {
        //     return $this->Json(['code' => '404', 'msg' => 'Vous n\'avez de SMS pour encaisser le client.']);
        // }
        if (!$thisStatupData) {
            return $this->Json(['code' => '404', 'msg' => 'Données de startup non trouvées.']);
        }
            
        $register = $this->request->getData('register');
        $amount = $this->request->getData('amount');
        $discount = $this->request->getData('discount');

        // 2. CALCUL DU MONTANT FINAL
        if ($discount !== 'Selectionnez' && is_numeric($discount) && is_numeric($amount)) {
            $amountEnd = $amount - $discount;
        } else {
            $amountEnd = $amount;
        }

        $gender_id = $this->request->getData('gender_id');

        // 3. VÉRIFICATION DU GENDER (TYPE DE VISITE)
        $findGender = $this->fetchTable('Genders')->findById($gender_id)->first();
        if (!$findGender) {
            return $this->Json(['code' => '404', 'msg' => 'Type de visite (Gender) non trouvé.']);
        }
        $duration = $findGender->numbermonthvisit; // e.g., 3, 6, 9, 12

        $cashBoxTable = $this->fetchTable('CashBoxes');
        $userId = $this->currentUser->id;
        $cashBox = $cashBoxTable->findByResponsableId($userId)->first();

        // 4. VÉRIFICATION DE LA CAISSE
        if (!$cashBox) {
            return $this->Json(['code' => '201', 'msg' => 'Vous n\'avez pas de caisse']);
        }

        // 5. VÉRIFICATION DES DONNÉES ESSENTIELLES
        if (empty($register) || empty($amount)) {
            return $this->Json(['code' => '400', 'msg' => 'Information manquante (immatriculation ou montant)']);
        }
        
        // 6. VÉRIFICATION DU VÉHICULE
        $Vehicles = $this->fetchTable('Vehicles');
        $vehicle = $Vehicles->find()->where(['registration_number' => $register])->first();
        if (!$vehicle) {
            return $this->Json(['code' => '404', 'msg' => 'Véhicule non trouvé pour cette immatriculation.']);
        }
        $lastvisitDate = new \DateTime();

        // 7. CRÉATION ET MISE À JOUR DE L'INSPECTION
        $Inspections = $this->fetchTable('Inspections');
        $inspection = $Inspections->newEmptyEntity();

        $inspection->vehicle_id = $vehicle->id;
        $inspection->gender_id = $gender_id;
        $inspection->status = 'confirm';
        $inspection->customer_id = $vehicle->customer_id;
        
        // Calcul de la date de fin (basé sur la durée et la dernière visite)
        $startDate = is_null($lastvisitDate) ? new FrozenTime() : clone $lastvisitDate;

        if ($duration == 3) {
            $inspection->end_date = $startDate->modify('+3 months');
        } elseif ($duration == 6) {
            $inspection->end_date = $startDate->modify('+6 months');
        } elseif ($duration == 9) {
            $inspection->end_date = $startDate->modify('+9 months');
        } else {
            $inspection->end_date = $startDate->modify('+12 months');
        }
        
        $inspection->create_uid = $this->currentUser->id;
        $inspection->write_uid = $this->currentUser->id;
        $inspection->uuid = Text::uuid();
        $vehicle->shedule = 1;
        $vehicle->next_shedule = 1;
        
        // Tentative de sauvegarde
        if ($Vehicles->save($vehicle) && $Inspections->save($inspection)) {
            
            // 8. RÉCUPÉRATION ET VÉRIFICATION DU CLIENT
            $customer = $this->fetchTable('Customers')->find()
                ->where(['id' => $inspection->customer_id])
                ->first();
            
            if (!$customer) {
                return $this->Json(['code' => '200', 'msg' => 'Encaissement enregistré, mais client introuvable pour les relances.']);
            }

            $Reminders = $this->fetchTable('Reminders');
            $reminder = $Reminders->find()->where(['gender_id' => $gender_id])->first();

            if (empty($reminder)) {
                return $this->Json(['code' => '200', 'msg' => 'Encaissement enregistré, mais pas de configurations de relance pour ce type de visite.']);
            }

            // 9. MESSAGES DE RELANCE (Définition des variables de remplacement)
            $Messages = $this->fetchTable('Messages');

            $replacements = [
                '[immatriculation]' => $register ?? '',
                '[nom entreprise]' => $thisStatupData->name ?? '',
                '[name]' => $customer->name ?? '',
                '[date]' => $inspection->end_date ? $inspection->end_date->format('d/m/Y') : '',
            ];

            // Verification de numero mtn ou orange
            $recipient = $customer->phone;
            //     1. Nettoyage et extraction des 3 premiers chiffres (le préfixe complet)
            if ($thisStatupData->name == 'CCT GODWIN')
                {
                $cleanedNumber = preg_replace('/[^0-9]/', '', $recipient);
                // debug($cleanedNumber);die();

                // On s'assure qu'il s'agit bien d'un numéro mobile (9 chiffres, commence par 6)
                if (strlen($cleanedNumber) !== 9 || !str_starts_with($cleanedNumber, '6')) {
                    return "Erreur : Format de numéro invalide ou inconnu.";
                }
                
                // Récupère les trois premiers chiffres : '653', '699', '677', etc.
                $fullPrefix = substr($cleanedNumber, 0, 3);
                $operateur = 'Inconnu';

                // 2. Logique d'identification (basée sur les trois premiers chiffres)
                
                // --- BLOCS MTN ---
                // Liste des préfixes MTN (67X, 680-683, 650-654)
                if (str_starts_with($fullPrefix, '67') || 
                    ($fullPrefix >= '680' && $fullPrefix <= '683') ||
                    ($fullPrefix >= '650' && $fullPrefix <= '654')
                ) {
                    $operateur = 'MTN';
                } 
                // --- BLOCS ORANGE ---
                // Liste des préfixes Orange (69X, 686-689, 655-659)
                elseif (str_starts_with($fullPrefix, '69') || 
                    ($fullPrefix >= '686' && $fullPrefix <= '689') ||
                    ($fullPrefix >= '655' && $fullPrefix <= '659')
                ) {
                    $operateur = 'Orange';
                }
                
                // --- ENREGISTREMENT DU MESSAGE DE REMERCIEMENT (HORS BOUCLE) ---
            
                if ($operateur == 'Orange')
                {
                    $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
                }else {
                    $thankYouContent = 'Cher client, [nom entreprise] vous remercie pour la visite technique du véhicule [immatriculation]. Nous apprécions votre confiance.';
                }
            }else {
                $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
            }

            // $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
        
            $finalThankYouContent = str_replace(array_keys($replacements), array_values($replacements), $thankYouContent);

            $message = $Messages->newEmptyEntity();
            $message->content = $finalThankYouContent;
            $message->status = 'sent';
            $message->receiver = $customer->phone;
            $message->inspection_id = $inspection->id;
            $message->startup_id = $startup_id;
            $message->customer_id = $inspection->customer_id;
            $message->sent_date = new FrozenTime(); 
            $message->create_uid = $this->currentUser->id;
            $message->write_uid = $this->currentUser->id;
            $message->uuid = Text::uuid();
            $content = $finalThankYouContent;
            // Appel pour la function de SMS de remerciement 
            $content = $finalThankYouContent;
            $startupName = $thisStatupData->name;
            
           if (!empty($startupName) && $startupName !== 'VISITE TECH') {
                $this->sendSms(
                    $recipient,
                    $content,
                    $startupName,
                    $operateur ?? ''
                );
            }
            
            $thisStartupTable = $this->fetchTable('Startups');
            $startupData = $thisStartupTable->findById($startup_id)->first();
            $startupData->sms_nbr -= 1;
            // debug($startupData);die();
            $thisStartupTable->save($startupData);
            // $this->sendSms($recipient,$content,$startupName);
            // $this->sendSms($recipient,$content,$startupName,$operateur ?? '');
            $Messages->save($message);
            // -----------------------------------------------------------------
            
            // Templates pour les relances DIFFÉRÉES (sans le remerciement)
            $messageTemplates =
            [
                // Message 1: 7 jours avant l'expiration
                [
                    'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire dans une semaine. Pensez à la renouveler à temps.',
                    'offset' => '-7 days',
                ],
                // Message 2: 3 jours avant l'expiration
                [
                    'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire dans 3 jours. Pensez à la renouveler à temps.',
                    'offset' => '-3 days',
                ],
                // Message 3: Le jour de l'expiration
                [
                    'content' => 'Cher client, la visite technique de votre véhicule [immatriculation] expire aujourd\'hui le [date]. Pensez à la renouveler à temps.',
                    'offset' => null, // Date d'expiration
                ],
            ];

            // 10. ENREGISTREMENT DES RELANCES DIFFÉRÉES (Boucle)
            foreach ($messageTemplates as $template) {
                $finalContent = str_replace(array_keys($replacements), array_values($replacements), $template['content']);
                $message = $Messages->newEmptyEntity();
                
                $message->content = $finalContent;
                $message->status = 'pending';
                $message->receiver = $customer->phone;
                $message->inspection_id = $inspection->id;
                $message->startup_id = $startup_id;
                $message->customer_id = $inspection->customer_id;
                
                if ($template['offset'] !== null) {
                    // Calcul basé sur le décalage (J-7 ou J-3)
                    // Utilisation de FrozenTime pour la manipulation de date dans CakePHP
                    $message->sent_date = (new FrozenTime($inspection->end_date))->modify($template['offset']); 
                } else {
                    // Date d'expiration (Jour J)
                    $message->sent_date = $inspection->end_date; 
                }
                  $thisStartupTable = $this->fetchTable('Startups');
                $startupData = $thisStartupTable->findById($startup_id)->first();
                $startupData->sms_nbr -= 1;
                // debug($startupData);die();
                $thisStartupTable->save($startupData);
                
                $message->create_uid = $this->currentUser->id;
                $message->write_uid = $this->currentUser->id;
                $message->uuid = Text::uuid();
                $Messages->save($message); // Sauvegarde des relances
            }
            
            // 11. CRÉATION ET MISE À JOUR DU MOUVEMENT DE CAISSE
            $cashMovTable = $this->fetchTable('CashMovements');
            $cashMov = $cashMovTable->newEmptyEntity();
            $cashMov->montant = $amountEnd;
            $cashMov->cash_box_id = $cashBox->id;
            $cashMov->type = 'entrée';
            $cashMov->motif_id = 2;
            $cashMov->startup_id = $startup_id;
            $cashMov->inspection_id = $inspection->id;
            $cashMov->user_id = $this->currentUser->id;
            $cashMov->justificatif = 'justificatif';
            $cashMov->create_uid = $this->currentUser->id;
            $cashMov->uuid = Text::uuid();

            if ($cashMovTable->save($cashMov)) {
                $cashBox->cashinout += 0;
                $cashBox->cashinput += $amountEnd;
                $cashBox->solde_actuel += $amountEnd;
                
                if ($cashBoxTable->save($cashBox)) {
                    return $this->Json(['code' => '200', 'msg' => 'Encaissement et relance enregistrés avec succès.']);
                }
            }
        }
        // Retour d'erreur en cas d'échec de sauvegarde (Inspection ou Mouvement de caisse)
        return $this->Json(['code' => '500', 'msg' => 'Une erreur est survenue lors de l\'enregistrement de l\'inspection ou du mouvement de caisse.']);
        }
    }
    


   public function sendSms($recipient,$content,$startupName,$operateur)
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
    
    
    public function sendSs($recipient,$content,$startupName,$operateur)
      {
         // 🚨 CONFIGURATION DE TEST (REMPLACEZ PAR VOS VALEURS RÉELLES) 🚨
        $apiKey    = '4IlrXpZRlqp4bLOdjnBCyS6qk68uleWE7ttHRsOyJF7ydOH97Ti6H7llfmDicjdNbuY2';
        $endpoint  = 'https://api.avlytext.com/v1/sms';
        $chaine_reduite = substr($startupName, 0, 11);

        // if (condition) {
        //    $sender  =  'DosSMS';
        //    $recipient = '+237' .''. 653321288;
        // }else {
        //    $sender =  $chaine_reduite;
        //     $recipient = '+237' .''. 653321288;
        // }
        
        if ($startupName != 'CCT GODWIN')
        {
            if ($operateur == 'MTN') {
            $sender  =  'DosSMS';
            }else{
            $sender  =  $chaine_reduite;
            }
        }else {
            $sender  =  'CCT GODWIN';
            // debug($sender);die();
        }
        // debug($operateur);
        // debug($content);die();

        // $sender =  $chaine_reduite;
        // if ($operateur == 'MTN') {
        //     $sender  =  'DosSMS';
        // }else{
        //     $sender  =  $chaine_reduite;
        // }
       
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
        
        } catch (\Exception $e) {
          
        }
    }
    
    
    
    
    
    
    
    
    public function home() {
        $this->viewBuilder()->setLayout('visitor');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

       public function add()
    {
        $this->viewBuilder()->setLayout('authentification');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
            // Vérification du mot de passe
            $email = $data['email'];
            $userexist = $this->Users->find()->where(['email'=>$email])->first();
        
            if(!empty($userexist)){
                  return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Un compte existe déjà avec cet adresse email.']);
            }
            if (strlen($data['password']) < 6) {
                 return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Le mot de passe doit contenir au moins 6 caractères.']);
            }
            // Vérification de l'email
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                 return $this->Json(['status'=>0, 'error'=>4,
                                  'message'=>'L\'adresse email n\'est pas valide.']);
            }
            else {
            $user = $this->Users->patchEntity($user, $data);
            $token = text::uuid();
            $user->uuid =  $token;
            $user->token_expires = (new \DateTime())->modify('+3 hours');
            $email = $user->email;
            // $this->sendmail($token, $email);
            if ($this->Users->save($user)) {
                $email = $user->email;
                    return $this->Json(['status'=>1, 'error'=>0,
                                'message'=>'Vérifiez votre adresse e-mail pour continuer.
                                            Nous venons de vous envoyer un e-mail à l\'adresse : ' . $email . ' .
                                            Veuillez vérifier votre boite e-mail et cliquer sur le lien fourni pour valider votre compte.',
                                // 'redirect' => 'login' 
                            ]);
            }
            $this->Flash->error(__('Impossible de créer le compte. Veuillez réessayer.'));
            }
        }
        $this->set(compact('user'));
    }
    
    public function sendmail($token, $email)
    {
        $mailer = new Mailer();
        $mailer
            ->setEmailFormat('html')
            ->setTo($email)
            ->setSubject('Nouvelle tâche')
            ->setFrom('alowizgb@gmail.com')
            ->setViewVars([
                'token' => $token,
            ])
            ->viewBuilder()
                ->setTemplate('validcompte')
                ->setLayout('sympa');
        $mailer->deliver();
    }

    public function validsignup($token)  {
        $user = $this->Users->find()->where(['uuid'=>$token])->first();
        // debug($user);
        // exit();
        if (!$user || $user->token_expires < new \DateTime()) {
          return $this->redirect(['action' => 'obsolete', $user->email]);
        }
        $user->verified = true;
        if ($this->Users->save($user)) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'obsolete' ]);
    }
    public function obsolete($email) {
          $this->viewBuilder()->setLayout('authentification');
          $this->set(compact('email'));
    }
    // Mise a jour des liens de validations obsolete

    public function getvalidlink($email) {
        $user = $this->Users->find()->where(['email'=>$email])->first();
        if (!$user) {
           return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $token = Text::uuid();
        $user->uuid = $token;
        $user->token_expires = (new \DateTime())->modify('+3 hours');
        // debug($user);
        // exit;
        $this->sendmail($token,$email);
        if ($this->Users->save($user)) {
                return $this->Json(['code'=>50,
                                'msg'=>'Vous avez recu un nouvel email de validation.']);
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     
   public function edit($id)
    {
        $accountTable = $this->fetchTable('Accounts');
        $account = $this->fetchTable('Accounts')->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Users->patchEntity($account, $this->request->getData());
             $account->name = $this->request->getData('name');
              $account->username = $this->request->getData('name');
             $account->phone = $this->request->getData('phone');
             $account->role = $this->request->getData('role');
             $account->passwordshow = $this->request->getData('passwordshow');
            $account->password = (string)$this->request->getData('passwordshow');
            if ($accountTable->save($account)) {
                return $this->redirect(['action' => 'collabots']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('account'));
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
       public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        // debug($id);die();
        $accountTable = $this->fetchTable('Accounts');
        $account = $this->fetchTable('Accounts')->get($id);
        if ($account->role == 'directeur') {
            return $this->redirect(['action' => 'collabots']);
        }
        // debug($account);die();
        if ($accountTable->delete($account)) {
             return $this->redirect(['action' => 'collabots']);
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
