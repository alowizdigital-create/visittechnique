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
        $this->Authentication->addUnauthenticatedActions(['login','add','home','validsignup','obsolete','getvalidlink','forgotpassword','ressetpassword']);
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


    public function dashboard()
    {
       $customers = $this->fetchTable('Customers')->find('list', limit: 200)
                ->where([
                    'OR' => [
                        'create_uid' => $this->currentUser->id,
                        'startup_id' => 1
                    ]
                ])
                ->all();
        $genders = $this->fetchTable('Genders')->find('list', limit: 200)
                ->where([
                    'OR' => [
                        'create_uid' => $this->currentUser->id,
                        'startup_id' => 1
                    ]
                ])
                ->all();
        $query = $this->fetchTable('Vehicles')->find()
                             ->where(['create_uid'=>$this->currentUser->id]);
        // $tasks = $this->paginate($query);
        $vehiclesCount = $this->paginate($query)->count();
        $this->set(compact('vehiclesCount','customers','genders'));
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
            // debug($customer_id);
            // exit();
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
               
            }
           
        }
    }

    public function newRelance() {
        if($this->request->is('post','ajax')){
        //    $register = $this->request->getData('matricule');
           $register = str_replace(' ', '', $this->request->getData('matricule'));
           $vehicle = $this->fetchTable('Vehicles')->find()->where(['registration_number'=>$register])->first();
        //    debug($vehicle);
        //    exit();
           if (empty($vehicle)) {
                $result = ['code'=>'50','msg'=>'Ce véhicule n\'existe pas ou a été supprimé'];
                return $this->Json($result);
           }else{
            $idCustomer = $vehicle->customer_id;
            $customer = $this->fetchTable('Customers')->find()->where(['id'=>$idCustomer])->first();
            $gender_id = $vehicle['gender_id'];
            $gender = $this->fetchTable('Genders')->find()->where(['id'=> $gender_id])->first(); 
            $price = $gender['price'];
           $discount = $this->fetchTable('Discounts')->find()
                ->select(['amount'])
                ->where(['gender_id'=> $gender_id])
                ->first();
            if (is_null($discount)) {
              $discountEnd = 0;
            }else{
                $discountEnd = $discount['amount'];
            }
            $customerPhone = $customer->phone;
            $customerName = $customer->name;
            // recuperer toutes les redcutions
            $discounts = $this->fetchTable('Discounts')
                                    ->find('list', keyField: 'id', valueField: 'amount')
                                    ->toArray(); 
            $result = ['code'=>'200','msg'=>'Ce véhicule n\'existe pas ou a été supprimé','price'=>$price,'discounts'=>$discounts,'customerPhone'=> $customerPhone,'customerName'=> $customerName,'register'=> $register,'gender'=> $gender['name'] ,'gender_id'=> $gender_id ];
            return $this->Json($result);
            }
        }
    }

    public function confirmPayment() {
        if ($this->request->is('ajax','post')) {
           $register = $this->request->getData('register');
           $amount = $this->request->getData('amount');
           $discount = $this->request->getData('discount');
           $gender_id = $this->request->getData('gender_id');
  
            if (empty($register) || empty($amount)) {
                 $result = ['code'=>'400','msg'=>'Information manquante'];
                 return $this->Json($result);
            }
            $vehicle = $this->fetchTable('Vehicles')->find()->where(['registration_number'=>$register])->first();
            $customer_id = $vehicle['customer_id'];
                $Inspections = $this->fetchTable('Inspections');
                $inspection = $Inspections->newEmptyEntity();
                $inspection->vehicle_id = $vehicle['id'];
                $inspection->gender_id = $gender_id;
                $inspection->status = 'confirm';
                $inspection->customer_id = $customer_id;
                $inspection->end_date = (new DateTime())->modify('+90 days');
                $inspection->create_uid = $this->currentUser->id;
                $inspection->write_uid = $this->currentUser->id;
                $inspection->uuid = Text::uuid();
                if ($Inspections->save($inspection)) {
                    $customer = $this->fetchTable('Customers')->find()
                                 ->where(['id'=> $inspection->customer_id ])->first();
                                //   debug($customer);die();
                    $Messages = $this->fetchTable('Messages');
                    $Templates = $this->fetchTable('Templates');
                    $Reminders = $this->fetchTable('Reminders');
                    // $Inspections = $this->fetchTable('Reminders');
                    $reminder = $Reminders->find()->where(['gender_id'=> $gender_id])->first();
                   
                    if (empty($reminder)) {
                           $result = ['code'=>'200','msg'=>'Pas de configurations pour cette relance']; 
                           return $this->Json($result);
                    }
                   
                    $template_id = $reminder['template_id'];
                    $template = $Templates->find()->where(['id'=> $template_id])->first();
                    $content = $template['content'];

                    $replacements = [
                       '[name]' => $customer['name'] ?? '',
                       '[date]' =>  $inspection->end_date->format('d/m/Y') ?? '',
                     ];
                    $finalContent = str_replace(array_keys($replacements), array_values($replacements), $content);
                    // debug($finalContent);die();
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
                           $result = ['code'=>'200','msg'=>'Relance enregistrée']; 
                           return $this->Json($result);
                        }
                    }
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
        $this->viewBuilder()->setLayout('add');
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
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $data['password'])) {
                return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule et un chiffre.']);
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
            $user->startup_id = 1;
            $user->token_expires = (new \DateTime())->modify('+3 hours');
            $email = $user->email;
            
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
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
