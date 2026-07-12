<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use DateTime;

/**
 * Vehicles Controller
 *
 * @property \App\Model\Table\VehiclesTable $Vehicles
 */
class VehiclesController extends AppController
{
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

    // 1. DÉTERMINATION DU STARTUP_ID
    $startup_id = null;
    $adminLogin = $adminTable->findById($user->id)->first();
    
    if ($adminLogin) {
        $startup_id = $adminLogin->startup_id;
    } else {
        $accountLogin = $accountTable->findById($user->id)->first();
        if ($accountLogin) { 
            $startup_id = $accountLogin->startup_id;
        }
    }

    // Gestion d'erreur si le startup_id n'est pas trouvé
    if (empty($startup_id)) {
        $this->Flash->error(__('Impossible de déterminer la startup de l\'utilisateur.'));
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // 2. EXÉCUTION DE LA REQUÊTE AVEC LIMIT ET TRI DIRECTS
    $query = $this->Vehicles->find()
        ->where(['Vehicles.startup_id' => $startup_id])
        ->contain(['Customers','Genders'])
        // Limite à 200 résultats
        ->limit(500) 
        // Tri par les plus récents (ID décroissant)
        ->order(['Vehicles.id' => 'DESC']); 

    // CORRECTION : Utilisation de all()->toArray() pour garantir la compatibilité
    $vehicles = $query->all()->toArray(); 
    $this->set(compact('vehicles'));
}



    /**
     * View method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vehicle = $this->Vehicles->get($id, contain: ['Customers']);
        $this->set(compact('vehicle'));
    }

 


  public function add()
{
    $vehicle = $this->Vehicles->newEmptyEntity();

    // Date du jour par défaut
    $vehicle->lastvisitdate = date('Y-m-d');

    // Recuperer l id de startup de la personne connecter
    $user = $this->currentUser;
    $accountTable = $this->fetchTable('Accounts');
    $adminTable = $this->fetchTable('Admins');

    $adminLogin = $adminTable->findById($user->id)->first();

    if ($adminLogin) {
        $startup_id = $adminLogin->startup_id;
    } else {
        $accountLogin = $accountTable->findById($user->id)->first();
        $startup_id = $accountLogin->startup_id;
    }

    if ($this->request->is('post')) {

        $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());

        $numberPhone = $this->request->getData('phone');
        $longueur = strlen((string)$numberPhone);

        if ($longueur < 9 || $longueur > 9) {
            return $this->redirect(['action' => 'add']);
        }

        $motAvecEspace = $vehicle->registration_number;
        $motSansEspace = ltrim($motAvecEspace);

        $registerImma = $this->Vehicles->find()
            ->where(['registration_number' => $motSansEspace])
            ->first();

        if ($registerImma) {
            $this->Flash->error(__('Ce véhicule est déjà enregistré.'));
            return $this->redirect(['action' => 'add']);
        }

        $register = $vehicle->registration_number;
        $register1 = str_replace(' ', '', $vehicle->registration_number);

        $vehicleTest = $this->Vehicles->find()
            ->where([
                'OR' => [
                    'registration_number' => $register,
                    'registration_number' => $register1
                ]
            ])
            ->first();

        if (!empty($vehicleTest)) {
            $this->Flash->error(__('Ce véhicule est déjà enregistré.'));
            return $this->redirect(['action' => 'add']);
        }

        $customer_id = $this->request->getData('custome');
        $customer_phone = $this->request->getData('phone');

        // Date par défaut si aucune date n'est saisie
        $lastVisitDateTrue = $this->request->getData('date');

        if (empty($lastVisitDateTrue)) {
            $lastVisitDateTrue = date('Y-m-d');
        }

        $lastVisitDate = new DateTime($lastVisitDateTrue);
        $endAndSentDate = (clone $lastVisitDate)->modify('+90 days');

        $customerId = $customer_id[0];
        $convert = (int)$customer_id[0];

        if ($convert == 0) {

            $Customers = $this->fetchTable('Customers');

            $customer = $Customers->newEmptyEntity();
            $customer->name = $customer_id;
            $customer->phone = $customer_phone;
            $customer->create_uid = $this->currentUser->id;
            $customer->write_uid = $this->currentUser->id;
            $customer->startup_id = $startup_id;
            $customer->uuid = Text::uuid();

            if ($Customers->save($customer)) {
                $customerId = $customer->id;
            }

            $contact = $this->fetchTable('Contacts')
                ->find()
                ->where(['phone' => $customer_phone])
                ->first();

            if (empty($contact)) {

                $Contacts = $this->fetchTable('Contacts');

                $contact = $Contacts->newEmptyEntity();
                $contact->name = $customer_id;
                $contact->phone = $customer_phone;
                $contact->create_uid = $this->currentUser->id;
                $contact->startup_id = $startup_id;
                $contact->uuid = Text::uuid();

                if ($Contacts->save($contact)) {
                    $contactId = $contact->id;
                }

            } else {
                $contactId = $contact->id;
            }
        }

        $vehicle->lastvisitdate = $lastVisitDateTrue;
        $vehicle->customer_id = $customerId;
        $vehicle->create_uid = $this->currentUser->id;
        $vehicle->write_uid = $this->currentUser->id;
        $vehicle->startup_id = $startup_id;
        $vehicle->uuid = Text::uuid();

        $gender_id = $vehicle->gender_id;

        if ($this->Vehicles->save($vehicle)) {

            $TeamTable = $this->fetchTable('Teams');
            $ContactTeamTable = $this->fetchTable('ContactsTeams');

            $hisTeam = $TeamTable->find()
                ->where(['gender_id' => $gender_id])
                ->first();

            if ($hisTeam && !empty($contactId)) {

                $contactTeam = $ContactTeamTable->newEmptyEntity();
                $contactTeam->contact_id = $contactId;
                $contactTeam->team_id = $hisTeam->id;

                $ContactTeamTable->save($contactTeam);
            }

            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);
    }

    $Reminders = $this->fetchTable('Reminders');

    $genders = $this->fetchTable('Genders')
        ->find('list', limit: 200)
        ->all();

    $loginstartupId = $startup_id;

    $customers = $this->Vehicles->Customers->find()
        ->where(['startup_id' => $loginstartupId])
        ->select(['id', 'name', 'phone'])
        ->limit(200)
        ->all();

    $customerOptions = [];

    foreach ($customers as $customer) {
        $customerOptions[$customer->id] = $customer->name . ' (' . $customer->phone . ')';
    }

    $this->set(compact('vehicle', 'customers', 'customerOptions', 'genders'));
}
    

public function ad()
    {
        $vehicle = $this->Vehicles->newEmptyEntity();
         // Recuperer l id de startup de la personne connecter
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
        if ($this->request->is('post')) {
            $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());
            
            $numberPhone = $this->request->getData('phone');
            $longueur = strlen((string)$numberPhone);
            if ($longueur < 9 || $longueur > 9 ) {
                return $this->redirect(['action' => 'add']);
            }

            $motAvecEspace = $vehicle->registration_number;
            $motSansEspace = ltrim($motAvecEspace);
            $registerImma = $this->Vehicles->find()->where(['registration_number'=>$motSansEspace])->first();
            
            if ($registerImma)
            {
                 $this->Flash->error(__('Ce véhicule est déja enregistré.'));
                return $this->redirect(['action' => 'add']);
            }
            
            $register = $vehicle->registration_number;
            $register1 = str_replace(' ', '', $vehicle->registration_number);
            $vehicleTest = $this->Vehicles->find()
          ->where([
                'OR' => [
                'registration_number' => $register,
                'registration_number' => $register1
                  ]
              ])
              ->first();

            if (!empty($vehicleTest)) { 
                $this->Flash->error(__('Ce véhicule est déja enregistré.'));
                return $this->redirect(['action' => 'add']);
            }
            
            $customer_id = $this->request->getData('custome');
            $customer_phone = $this->request->getData('phone');
            $lastVisitDateTrue = $this->request->getData('date');
            $lastVisitDate = $this->request->getData('date');
            if ($lastVisitDate) {
                $lastVisitDate = new DateTime($lastVisitDate);
                $endAndSentDate = ($lastVisitDate)->modify('+90 days');
            }else{
                $endAndSentDate =  (new DateTime())->modify('+90 days');
            }
            $customerId = $customer_id[0];
            // debug($endAndSentDate);die();
            $convert = (int)$customer_id[0];
            // debug($convert);die();
            if ($convert == 0) {
                $Customers = $this->fetchTable('Customers');
                $customer = $Customers->newEmptyEntity();
                $customer->name = $customer_id;
                $customer->phone = $customer_phone;
                $customer->create_uid = $this->currentUser->id;
                $customer->write_uid = $this->currentUser->id;
                $customer->startup_id = $startup_id;
                $customer->uuid = Text::uuid();
                if ($Customers->save($customer)) {
                  $customerId = $customer->id;
                }
            }
            $vehicle->lastvisitdate = $lastVisitDateTrue;
            $vehicle->customer_id = $customerId;
            $vehicle->create_uid = $this->currentUser->id;
            $vehicle->write_uid = $this->currentUser->id;
            $vehicle->startup_id = $startup_id;
            $vehicle->uuid = Text::uuid();
            // debug($vehicle);die();
            if ($this->Vehicles->save($vehicle)) {
                 return $this->redirect(['action' => 'index']);

                    }
                 return $this->redirect(['action' => 'index']);

            // }
        }
        $Reminders = $this->fetchTable('Reminders');
    
        $genders = $this->fetchTable('Genders')->find('list', limit: 200)->all();

        $loginstartupId = $startup_id;
        $customers = $this->Vehicles->Customers->find()->where(['startup_id'=>$loginstartupId])
            ->select(['id', 'name', 'phone'])
            ->limit(200)
            ->all();

        $customerOptions = [];
            foreach ($customers as $customer) {
                $customerOptions[$customer->id] = $customer->name . ' (' . $customer->phone . ')';
            }
      $this->set(compact('vehicle', 'customers', 'customerOptions', 'genders'));
    }




    /**
     * Edit method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     public function edit($id)
        {
            $vehicle = $this->Vehicles->get($id, contain: []);
            $customer = $this->fetchTable('Customers')->findById($vehicle->customer_id)->first();
            
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
            // $vehicle = $this->Vehicles->findByUuid()->contain([]);
            if ($this->request->is(['patch', 'post', 'put'])) {
              $createDate = $vehicle->created->format('Y-m-d H:i:s');
              
              $inspection = $this->fetchTable('Inspections')
                    ->find()
                    ->where([
                        'vehicle_id' => $id,
                        'DATE(created)' => $vehicle->created->format('Y-m-d')
                    ])
                    ->first();
                       if (is_null($inspection)) {
                        $vehicle->registration_number = $this->request->getData('registration_number');
                        $vehicle->gender_id = $this->request->getData('gender_id');
                        $phone = $this->request->getData('phone');
                        $customerName = $this->request->getData('customer');
                        $customer->phone = $phone;
                        $customer->name = $customerName;
                        $this->fetchTable('Customers')->save($customer);
                        $this->fetchTable('Vehicles')->save($vehicle);
                        return $this->redirect(['action' => 'index']);
                    }

                $phone = $this->request->getData('phone');
                $customerName = $this->request->getData('customer');
                $customer->phone = $phone;
                $customer->name = $customerName;
                $this->fetchTable('Customers')->save($customer);
                // debug($inspection);die();
                
                $newgenderId = (int)$this->request->getData('gender_id');
                // debug($newgenderId);die();
    
                $register = $vehicle->registration_number;
                $gender = $this->fetchTable('Genders')->findById($newgenderId)->first();
                $duration = $gender->numbermonthvisit;
                // LE PRIX DU GENRE DE VEHICULE
                $genderPrice = $gender->price ?? 0;
                
                $discount = $this->fetchTable('Discounts')->findByGenderId($gender->id)->where(['startup_id'=>$startup_id])->first();
                // LA REDUCTION
                $discountAmount = $discount->amount ?? 0;
                // Le nouveau montant final
                $newAmount = $genderPrice - $discountAmount;
                // debug($inspection);die();
                // recuperer et modifier le mouvement lié a cette inspection
                $thisCashMov =  $this->fetchTable('CashMovements')->findByInspectionId($inspection->id)->first();
               
                // debug($thisCashMov);die();
               
                $thisCashMovInitAmount = $thisCashMov->montant;
                // debug($thisCashMovInitAmount);die();
                // recuperer la difference entre le prix avant et le nouveau frais de visite
                if ($thisCashMovInitAmount < $newAmount) {
                     $amountDiff = $newAmount + $thisCashMovInitAmount;
                    //  debug($newAmount);die();
                    $thisCashMov->montant = $newAmount;
                    // debug($newAmount);die();
                    $this->fetchTable('CashMovements')->save($thisCashMov);
                    $thisInspectionsCashBox =  $this->fetchTable('CashBoxes')->findById($thisCashMov->cash_box_id)->first();
                    $thisInspectionsCashBox->solde_actuel +=  $amountDiff;
                    $this->fetchTable('CashBoxes')->save($thisInspectionsCashBox);
                    // debug($thisInspectionsCashBox);die();
                }else {
                     $amountDiff =  $thisCashMovInitAmount - $newAmount;
                    $thisCashMov->montant = $newAmount;
                    $this->fetchTable('CashMovements')->save($thisCashMov);
                    $thisInspectionsCashBox =  $this->fetchTable('CashBoxes')->findById($thisCashMov->cash_box_id)->first();
                    $thisInspectionsCashBox->solde_actuel -=  $amountDiff;
                    $this->fetchTable('CashBoxes')->save($thisInspectionsCashBox);
                }
                
               // 1. Récupérer tous les messages liés à l'inspection
                $messages = $this->fetchTable('Messages')
                    ->find()
                    ->where(['Messages.inspection_id' => $inspection->id])
                    ->all();
                // 2. Obtenir la Table des Messages (déjà fait, mais important)
                $messagesTable = $this->fetchTable('Messages');
    
                // 3. Itérer sur chaque message et le supprimer
                foreach ($messages as $message) {
                // debug($vehicle);die();
                    $this->confirmPayment($message,$gender,$register,$newAmount);
                    //  $messagesTable->delete($message);
                    //  $this->deleteMessage($id);
                }
             
                if(!empty($this->request->getData('date'))){
                     $vehicle->lastvisitdate = $this->request->getData('date');
                }
               
                //  debug($vehicle);die();
                if ($this->Vehicles->save($vehicle))
                {
                // debug($vehicle);die();
                 $data = $this->Vehicles->Inspections->find('list', limit: 200)->all();
                    // $this->deleteMessage($id);
                    $this->Flash->success(__('The vehicle has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
            }
            $customers = $this->Vehicles->Customers->find('list', limit: 200)->all();
            $genders = $this->Vehicles->Genders->find('list', limit: 200)->all();
            $this->set(compact('vehicle', 'customer','genders'));
        }
    
    
     public function confirmPayment($message,$gender,$register,$newAmount) {
        // if ($this->request->is('ajax','post')) {
          $duration = $gender->numbermonthvisit;
                if ($duration == 3) {
                    $newEndDate = (new DateTime())->modify('+90 days'); 
                }elseif ($duration == 6) {
                    $newEndDate = (new DateTime())->modify('+180 days');
                }elseif ($duration == 9) {
                    $newEndDate = (new DateTime())->modify('+270 days');
                } else {
                     $newEndDate = (new DateTime())->modify('+360 days');
                }
                $message->sent_date = $newEndDate;
                $Templates = $this->fetchTable('Templates');
                $Reminders = $this->fetchTable('Reminders');
                // debug($message);die();
                // $Inspections = $this->fetchTable('Reminders');
                $reminder = $Reminders->find()->where(['gender_id'=> $gender->id])->first();
                //  debug($gender);die();
                $template_id = $reminder['template_id'];
                $template = $Templates->find()->where(['id'=> $template_id])->first();
                $content = $template['content'];
                $replacements = [
                    '[immatriculation]' => $register ?? '',
                    '[nom entreprise]' => $thisStatupData->name ?? '',
                    '[name]' => $customer['name'] ?? '',
                    '[date]' =>  $newEndDate->format('d/m/Y') ?? '',
                    ];
                $finalContent = str_replace(array_keys($replacements), array_values($replacements), $content);
                // debug($finalContent);die();
                $message->content = $finalContent;
                $this->fetchTable('Messages')->save($message);
                // debug($message);die();
    }


    /**
     * Delete method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vehicle = $this->Vehicles->get($id);
        if ($this->Vehicles->delete($vehicle)) {
            $this->Flash->success(__('The vehicle has been deleted.'));
        } else {
            $this->Flash->error(__('The vehicle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
