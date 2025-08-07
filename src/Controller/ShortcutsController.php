<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

/**
 * Shortcuts Controller
 *
 * @property \App\Model\Table\ShortcutsTable $Shortcuts
 */
class ShortcutsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('profile');
        $thisUser = $this->Authentication->getResult()->getData();
        $query = $this->Shortcuts->find()
                ->where(['create_uid'=>$thisUser->id]);
        $shortcuts = $this->paginate($query);
        $this->set(compact('shortcuts'));
    }

 
    public function view($id = null)
    {
        $shortcut = $this->Shortcuts->get($id, contain: []);
        $this->set(compact('shortcut'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($link = null)
    {
        //vérifier s'il y a un parametre dans la barre de recherche 
        if (isset($_GET['link'])) {
            // Récupérer et décoder le paramètre 'link'
            $link = $_GET['link'];
            if ($link == 0) {
                return $this->redirect(['controller' => 'Shortcuts','action'=>'dashboard']);
            }
           
            //Sauvegarde de l'url
            $thisUser = $this->Authentication->getResult()->getData();
            $shortcut = $this->Shortcuts->newEmptyEntity();
                $url = $link;
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    $this->Flash->error(__('URL invalide.'));
                    return;
                }
                $shortcut->create_uid =  $thisUser->id;
                $shortcut->write_uid = 5;
                $shortcut->url = $url;
                $shortcut->uuid = Text::uuid();
               // code unique pour l'url
                $urlkey = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                $shortcut->urlkey =  $urlkey ;
                $shortcut->url = $url;
                $shortcut->shorturl = 'sosmall.local/'.''.$urlkey;
                if ($this->Shortcuts->save($shortcut)) {
                    $this->Flash->success(__('The shortcut has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
        }
        if ($this->request->is('post')) {
            $url = $this->request->getData('url');
        $thisUser = $this->Authentication->getResult()->getData();
        $shortcut = $this->Shortcuts->newEmptyEntity();
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->Flash->error(__('URL invalide.'));
                return;
            }
            $shortcut->create_uid =  $thisUser->id;
            $shortcut->write_uid = 5;
            $shortcut->url = $url;
            $shortcut->uuid = Text::uuid();
           // code unique pour l'url
            $urlkey = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
            $shortcut->urlkey =  $urlkey ;
            $shortcut->url = $url;
            $shortcut->shorturl = 'sosmall.local/'.''.$urlkey;
            if ($this->Shortcuts->save($shortcut)) {
                $this->Flash->success(__('The shortcut has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortcut could not be saved. Please, try again.'));
            $this->set(compact('shortcut'));
        }
    }
    public function dashboard() {
        $Shortcuts = TableRegistry::getTableLocator()->get('Shortcuts'); // Chargement manuel
        $this->viewBuilder()->setLayout('profile');
        $thisUser = $this->Authentication->getResult()->getData();
        $allShortcut = $this->Shortcuts->find('list', limit: 200)
                                         ->where(['create_uid'=> $thisUser->id]);
        $allNumberLink = $this->Shortcuts->find()
                                           ->where(['create_uid'=> $thisUser->id])->count();

        $totalClics = $Shortcuts->find()
                            ->select(['total' => $Shortcuts->find()->func()->sum('Shortcuts.number_of_clic')])
                            ->where(['create_uid'=>$thisUser->id])
                            ->first();
                        
        $nomberOfClic = $totalClics ? $totalClics->total : 0;
        $query = $this->Shortcuts->find('all')
                ->where(['create_uid' => $thisUser->id])
                ->order(['created' => 'DESC'])
                ->limit(10); // ✅ Ajout de la limite correctement
    
        $shortcuts = $this->paginate($query);
                        //    debug($shortcuts);
                        //    exit();
         $this->set(compact('allNumberLink','allShortcut','nomberOfClic','shortcuts'));
    }

    public function addShortcut(){
        // $url = $this->request->getData();
        if ($this->request->is('post','ajax')) {
            $url = $this->request->getData('url');
            
        $thisUser = $this->Authentication->getResult()->getData();
        $shortcut = $this->Shortcuts->newEmptyEntity();
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $result = ['code'=>'200','msg'=>'URL invalide.'];   
                return $this->Json($result);
            }
            $shortcut->create_uid =  $thisUser->id;
            $shortcut->write_uid = $thisUser->id;
            $shortcut->url = $url;
            $shortcut->uuid = Text::uuid();
           // code unique pour l'url
            $urlkey = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
            $shortcut->urlkey =  $urlkey ;
            $shortcut->url = $url;
            $shortcut->shorturl = 'sosmall.local/'.''.$urlkey;
            // debug($shortcut);
            // exit();
            if ($this->Shortcuts->save($shortcut)) {
                $result = ['code'=>'300','msg'=>'URL raccourcit avec succès !'];
                return $this->Json($result);
            }
            $result = ['code'=>'200','msg'=>'Impossible de raccourcir votre URL !'];
            return $this->Json($result);
            $this->set(compact('shortcut'));
        }
       
    }

    public function redirection() {
        $urlKey = $this->request->getParam('urlKey');
        $url = $this->Shortcuts->find()
        ->where(['urlkey'=>$urlKey])
        ->first();
        if ($url) {
            $url->number_of_clic =  $url->number_of_clic + 1;
            // $shortcut->number_of_clic = 4 ;
            if ($this->Shortcuts->save($url)) {
                return $this->redirect($url->url); 
            }
            $this->Flash->error(__('The shortcut could not be saved. Please, try again.'));
           
            // return $this->redirect($url->url); 
        }else {
            $this->Flash->error('l URL n existe pas ou a été supprimé');
            return $this->redirect(['action' => 'index']);
        }
    }
  
    /**
     * Edit method
     *
     * @param string|null $id Shortcut id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shortcut = $this->Shortcuts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shortcut = $this->Shortcuts->patchEntity($shortcut, $this->request->getData());
            if ($this->Shortcuts->save($shortcut)) {
                $this->Flash->success(__('The shortcut has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortcut could not be saved. Please, try again.'));
        }
        $this->set(compact('shortcut'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shortcut id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shortcut = $this->Shortcuts->get($id);
        if ($this->Shortcuts->delete($shortcut)) {
            $this->Flash->success(__('The shortcut has been deleted.'));
        } else {
            $this->Flash->error(__('The shortcut could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
