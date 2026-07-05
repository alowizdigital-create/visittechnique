<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Startups Controller
 *
 * @property \App\Model\Table\StartupsTable $Startups
 */
class StartupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Startups->find();
        $startups = $this->paginate($query);
        // debug($startups);die();
        $this->set(compact('startups'));
    }

    /**
     * View method
     *
     * @param string|null $id Startup id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $startup = $this->Startups->get($id, contain: ['Accounts', 'Admins', 'Customers', 'Genders', 'Motifs', 'Users']);
        $this->set(compact('startup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $startup = $this->Startups->newEmptyEntity();
        if ($this->request->is('post')) {
           
            // Creation d'un compte pour utilisateur
                $accountTable = $this->fetchTable('Accounts');
                $account = $accountTable->newEmptyEntity();
                $autoPassword = random_int(100000, 999999);
                $account->uuid =  Text::uuid();
                $account->name = 'fondateur';
                $account->phone = 5678;
                $account->startup_id = 1;
                $account->create_uid = 1;
                $account->write_uid = 1;
                $account->username = 'fondateur';
                $account->role = 'fondateur';
                $account->passwordshow = $autoPassword;
                $account->password =  (string)$autoPassword;
                $accountTable->save($account);
                // Saving startup with logo
                $startup = $this->Startups->patchEntity($startup, $this->request->getData());
                    $allowedFileTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/jpg'
                ];
                $file = $this->request->getUploadedFiles();
                if (isset($file['logo'])) {
                    $uploadedFile = $file['logo'];
                    $fileType = $uploadedFile->getClientMediaType(); 
                    if (in_array($fileType, $allowedFileTypes)) {
                        $filename = $uploadedFile->getClientFilename();
                        //  $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/img/';
                        //  $destination = public_html . 'img' . DS . $filename;
                        // // $destination = WWW_ROOT . 'img' . DS . $filename;
                        // if (!is_dir(dirname($destination))) {
                        //     mkdir(dirname($destination), 0755, true);
                        // }
                        // $uploadedFile->moveTo($destination);
                        // $startup->logo = $filename;
                         $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/img/';
        
                            // Ensure the directory exists and is writable
                            if (!is_dir($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                    
                            // Generate a unique filename to prevent overwrites
                            $filename = uniqid() . '_' . $uploadedFile->getClientFilename();
                            $fullPath = $destinationPath . $filename;
                            
                            // Move the uploaded file to the destination
                            $uploadedFile->moveTo($fullPath);
                            
                            // Save the relative path to the database
                            // This path is relative to the web root, which is what the HtmlHelper expects
                            $startup->logo = $filename;
                
                    } else {
                        $this->Flash->success(__('Type de fichier non autorisé .'));
                    }
                } else {
                    $this->Flash->success(__('Aucun fichier uploadé .'));
                }
                $startup->uuid = Text::uuid();
                $startup->create_uid = $this->currentUser->id;
                $startup->account_id = $account->id;
                // debug($startup);die();
            if ($this->Startups->save($startup)) {
                // $accountTable = $this->fetchTable('Accounts');
                // $account = $accountTable->newEmptyEntity();
                // $autoPassword = random_int(100000, 999999);
                // $account->uuid =  Text::uuid();
                // // $account->name = $data['name'];
                // // $account->phone = $data['phone'];
                // $account->startup_id = $startup->id;
                // $account->create_uid = 1;
                // $account->write_uid = 1;
                // $account->username = $account->role;
                // $account->passwordshow = $autoPassword;
                // $account->password =  (string)$autoPassword;
                // // debug($account);die();
                // $accountTable->save($account);
                $this->Flash->success(__('The startup has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The startup could not be saved. Please, try again.'));
        }
        
         
        $this->set(compact('startup'));
    }
    
    // Fonction d'enregistrement d'entreprise enfant
    
     public function child()
    {
        $startup = $this->Startups->newEmptyEntity();
        if ($this->request->is('post')) {
           
            // Creation d'un compte pour utilisateur
                $accountTable = $this->fetchTable('Accounts');
                $account = $accountTable->newEmptyEntity();
                $autoPassword = random_int(100000, 999999);
                $account->uuid =  Text::uuid();
                $account->name = 'fondateur';
                $account->phone = 5678;
                $account->startup_id = 1;
                $account->create_uid = 1;
                $account->write_uid = 1;
                $account->username = 'fondateur';
                $account->role = 'fondateur';
                $account->passwordshow = $autoPassword;
                $account->password =  (string)$autoPassword;
                $accountTable->save($account);
                // Saving startup with logo
                $startup = $this->Startups->patchEntity($startup, $this->request->getData());
                    $allowedFileTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/jpg'
                ];
                $file = $this->request->getUploadedFiles();
                if (isset($file['logo'])) {
                    $uploadedFile = $file['logo'];
                    $fileType = $uploadedFile->getClientMediaType(); 
                    if (in_array($fileType, $allowedFileTypes)) {
                        $filename = $uploadedFile->getClientFilename();
                        //  $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/img/';
                        //  $destination = public_html . 'img' . DS . $filename;
                        // // $destination = WWW_ROOT . 'img' . DS . $filename;
                        // if (!is_dir(dirname($destination))) {
                        //     mkdir(dirname($destination), 0755, true);
                        // }
                        // $uploadedFile->moveTo($destination);
                        // $startup->logo = $filename;
                         $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/img/';
        
                            // Ensure the directory exists and is writable
                            if (!is_dir($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                    
                            // Generate a unique filename to prevent overwrites
                            $filename = uniqid() . '_' . $uploadedFile->getClientFilename();
                            $fullPath = $destinationPath . $filename;
                            
                            // Move the uploaded file to the destination
                            $uploadedFile->moveTo($fullPath);
                            
                            // Save the relative path to the database
                            // This path is relative to the web root, which is what the HtmlHelper expects
                            $startup->logo = $filename;

                
                    } else {
                        $this->Flash->success(__('Type de fichier non autorisé .'));
                    }
                } else {
                    $this->Flash->success(__('Aucun fichier uploadé .'));
                }
               $parentId = $this->request->getData('parent');
               $parent = $this->Startups->find()->where(['id'=>$parentId])->first();
            //   debug($parent);
            //   die();
                $startup->matricule = $parent->matricule;
                $startup->uuid = Text::uuid();
                $startup->account_id = $account->id;
                // debug($startup);die();
            if ($this->Startups->save($startup)) {
                // $accountTable = $this->fetchTable('Accounts');
                // $account = $accountTable->newEmptyEntity();
                // $autoPassword = random_int(100000, 999999);
                // $account->uuid =  Text::uuid();
                // // $account->name = $data['name'];
                // // $account->phone = $data['phone'];
                // $account->startup_id = $startup->id;
                // $account->create_uid = 1;
                // $account->write_uid = 1;
                // $account->username = $account->role;
                // $account->passwordshow = $autoPassword;
                // $account->password =  (string)$autoPassword;
                // // debug($account);die();
                // $accountTable->save($account);
                $this->Flash->success(__('The startup has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The startup could not be saved. Please, try again.'));
        }
        
        $startups = $this->Startups->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('startup','startups'));
    }
    

    
    public function changeStartup() {
       $data = $this->request->getData();
       $uuid = $data['uuid'];
       
       $startup = $this->Startups->findByUuid($uuid)->first();
       $startupAskLogin =  $startup->id;
        // debug($startupAskLogin);die();
       $adminsTable = $this->fetchTable('Admins');
       $admin = $adminsTable->findById($this->currentUser->id)->first();
       $admin->startup_id = $startupAskLogin;
   
       if ($adminsTable->save($admin)) {
        // 1. Récupérer l'objet utilisateur de la session
        //  $this->Authentication->setIdentity($admin);

        // 4. Déboguer pour confirmer que la session est mise à jour
        // debug($this->Authentication->getIdentity());
        // exit();
           return $this->Json(['code'=>105,
                                  'msg'=>'Mutation effectuée avec succès.']);
       }
    }

    public function changeCenter() {
      $data = $this->request->getData();
      $uuid = $data['uuid'];
    // debug($admin);die();
      $startup = $this->Startups->findByUuid($uuid)->first();
      $startupAskLogin =  $startup->id;
      $accountTable = $this->fetchTable('Accounts');
      $account = $accountTable->findById($this->currentUser->id)->first();
      $account->startup_id = $startupAskLogin;
    //   debug($admin);die();
      if ($accountTable->save($account)) {
        // 1. Récupérer l'objet utilisateur de la session
        //  $this->Authentication->setIdentity($admin);

        // 4. Déboguer pour confirmer que la session est mise à jour
        // debug($this->Authentication->getIdentity());
        // exit();
          return $this->Json(['code'=>105,
                                  'msg'=>'Mutation effectuée avec succès.']);
      }
    }

    /**
     * Edit method
     *
     * @param string|null $id Startup id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     
    public function edit($id)
    {
        $startup = $this->Startups->get($id, contain: []);
        // debug($startup);die();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // 1. CORRECTION: Récupérer 'name'
            $name = $this->request->getData('name');
            
            // 2. NOUVELLE VARIABLE: Récupérer 'phone'
            $phone = $this->request->getData('phone');
            
            // 3. IMPLÉMENTATION DE LA LIMITE À 11 CARACTÈRES
            // On tronque la chaîne pour s'assurer qu'elle ne dépasse pas 11 caractères
            $phone_limite = substr($phone, 0, 11);
            
            $mail = $this->request->getData('mail');

            // Mettre à jour l'objet $startup avec les nouvelles données
            $startup->name = $name;
            $startup->phone = $phone_limite; // Utiliser la chaîne limitée
            $startup->mail = $mail; 
            
            $allowedFileTypes = [
                'image/jpeg',
                'image/png',
                'image/jpg'
            ];
            
            $file = $this->request->getUploadedFiles();
        
            if (isset($file['logo']) && $file['logo']->getSize() > 0) { // Ajout de la vérification de la taille
                $uploadedFile = $file['logo'];
                $fileType = $uploadedFile->getClientMediaType();
                
                // Ajouter ici une vérification du type de fichier
                if (in_array($fileType, $allowedFileTypes)) {
                    $filename = $uploadedFile->getClientFilename();
                    // Utiliser une meilleure gestion des noms de fichiers (ex: uniqid()) est recommandé !
                   // Correction ici : ajoute le nom du fichier à la destination
                   $destination = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $filename;
    
                    
                    if (!is_dir(dirname($destination))) {
                        mkdir(dirname($destination), 0755, true);
                    }
                    
                    $uploadedFile->moveTo($destination);
                    $startup->logo = $filename;
                    // Le message de succès est mal placé ici, il doit être après la sauvegarde.
                } else {
                    $this->Flash->error(__('Type de fichier non autorisé.')); // Changé en error pour plus de clarté
                }
            }
            
            // debug($startup);die();
            if ($this->Startups->save($startup)) {
                $this->Flash->success(__('The startup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('The startup could not be saved. Please, try again.'));
        }
        $this->set(compact('startup'));
    }
    
    
    

    /**
     * Delete method
     *
     * @param string|null $id Startup id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $startup = $this->Startups->get($id);
        if ($this->Startups->delete($startup)) {
            $this->Flash->success(__('The startup has been deleted.'));
        } else {
            $this->Flash->error(__('The startup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
