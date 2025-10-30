<?php
declare(strict_types=1);

namespace App\Controller\Account;
use App\Controller\AppController;

use Cake\utility\Text;
use Cake\Routing\Router;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 */
class AccountsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configurez l'action de connexion pour ne pas exiger d'authentification,
        // évitant ainsi le problème de la boucle de redirection infinie
        $this->Authentication->addUnauthenticatedActions(['login','add']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Admins->find();
        $admins = $this->paginate($query);
        $this->set(compact('admins'));
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $this->viewBuilder()->setLayout('authentification');
        if ($this->request->is('post')){
           
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
        // indépendamment de POST ou GET, rediriger si l'utilisateur est connecté
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['action' => 'login']);
        }
    }


    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $admin = $this->Admins->get($id, contain: []);
        $this->set(compact('admin'));
    }

      public function addCollabot()
    {
        // $this->Accounts = $this->fetchTable('Accounts');
        $this->viewBuilder()->setLayout('add');
        $account = $this->Accounts->newEmptyEntity();
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
           
            // Vérification du mot de passe
            $phone = $data['phone'];
            $userexist = $this->Accounts->find()->where(['phone'=>$phone])->first();
            if(!empty($userexist)){
                  return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Un compte existe déjà avec cet adresse email.']);
            }
            $account = $this->Accounts->patchEntity($account, $data);
            $token = text::uuid();
            $account->uuid =  $token;
            $account->name = $data['name'];
            $account->phone = $data['phone'];
            $account->role = 'u';
            $account->startup_id = 1;
            $account->create_uid = 1;
            $account->username = 'hdhdh';
            $account->password = 'kdjjfkkf';
            //  debug($account);exit();
            if ($this->Accounts->save($account)) {
                    return $this->Json(['status'=>1, 'error'=>0,
                                'message'=>'Collaborateur créer avec succès !',
                            ]);
            }
            $this->Flash->error(__('Impossible de créer le compte. Veuillez réessayer.'));
        }
        // $this->set(compact('account'));
    }
    
    public function collabots() {
        $user = $this->currentUser;
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        //using of this request is necessary to recover good startup_id
        // when session's data modified by exemple when admin move from one statup to other
        $startup_id = $adminLogin->startup_id;
        $query = $this->Accounts->find()->where(['startup_id'=> $startup_id ]);
        $collabots = $this->paginate($query);
        $this->set(compact('collabots'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('add');
        $account = $this->Accounts->newEmptyEntity();
        $user = $this->currentUser;
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        }else {
            $accountLogin = $this->Accounts->findById($user->id)->first();
            $startup_id = $accountLogin->startup_id;
        }
        if ($this->request->is('post','ajax')) {
            $data = $this->request->getData();
             
            // Vérification du mot de passe
            $phone = $data['phone'];
            $userexist = $this->Accounts->find()->where(['phone'=>$phone])->first();
            if(!empty($userexist)){
                  return $this->Json(['status'=>0, 'error'=>3,
                                  'message'=>'Un compte existe déjà avec ce numero.']);
            }
            $account = $this->Accounts->patchEntity($account, $data);
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
            $data['role'];
            $autoPassword = random_int(100000, 999999);
            $account->uuid =  $token;
            $account->name = $data['name'];
            $account->phone = $data['phone'];
            $account->startup_id =  $startup_id;
            $account->create_uid = 1;
            $account->write_uid = 1;
            $account->username = $account->role;
            $account->passwordshow = $autoPassword;
            $account->password =  (string)$autoPassword;
            // debug($account);exit();
            if ($this->Accounts->save($account)) {
                    return $this->Json(['status'=>1, 'error'=>0,
                                'message'=>'Collaborateur créer avec succès !',
                            ]);
            }
            $this->Flash->error(__('Impossible de créer le compte. Veuillez réessayer.'));
        }
        // $this->set(compact('account'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $admin = $this->Admins->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}