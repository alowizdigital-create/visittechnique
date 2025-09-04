<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Utility\Text;

/**
 * CashBoxes Controller
 *
 * @property \App\Model\Table\CashBoxesTable $CashBoxes
 */
class CashBoxesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    { 
        $this->CashBoxes = $this->fetchTable('CashBoxes');
        $UsersTable = $this->fetchTable('Users');
        $userData = $UsersTable->find()->where(['id'=> $this->currentUser->id])->first();
        if ($userData->role == 'admin') {
            $query = $this->CashBoxes->find()->where(['create_uid'=>$this->currentUser->id]);
        }
        else{
            $query = $this->CashBoxes->find()->where(['responsable_id'=> $this->currentUser->id]);
        }
        $cashBoxes = $this->paginate($query);
        $mystartup =  $userData->startup_id;
        // debug($mystartup);die();
        $myCollabots = $UsersTable->find('list', keyField: 'id', valueField: 'firstname')
                                    ->where(['startup_id'=> $mystartup])
                                    ->toArray();
          
        // Requete de recherche                             
    $CashMovements = $this->fetchTable('CashMovements');
    $this->fetchTable('CashBoxes');
    $this->fetchTable('Users');

    // Utilisateur courant
    $user = $this->currentUser->id;

    // Base query
    $query = $CashMovements->find()
        ->contain(['CashBoxes', 'Users'])
        ->order(['CashMovements.created' => 'DESC']);

    // --- Filtres GET ---
     $search = $this->request->getQuery('search');
    // $search = 1;
    // debug($search);die();s
    $from   = $this->request->getQuery('from');
    $to     = $this->request->getQuery('to');

    if (!empty($search)) {
        $query
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Users')
            ->andWhere([
                'OR' => [
                    'CashMovements.type LIKE'   => "%$search%",
                    'CashMovements.motif LIKE'  => "%$search%",
                    'CashBoxes.name LIKE'       => "%$search%",
                    'Users.firstname LIKE'      => "%$search%",
                    'Users.lastname LIKE'       => "%$search%",
                ]
            ]);
    }

    if (!empty($from)) {
        $query->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
    }

    if (!empty($to)) {
        $query->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
    }

    // --- Options de pagination ---
    $paginateOptions = ['order' => ['CashMovements.created' => 'DESC']];

    // Si pas de filtre, limiter aux 2 dernières opérations
    if (empty($search) && empty($from) && empty($to)) {
        $paginateOptions['limit'] = 2;
    }

    // Pagination
    $cashMovements = $this->paginate($query, $paginateOptions);

    $amount = $this->CashBoxes->find()->where(['responsable_id'=> $userData->id])->first();
    $amountInit = $amount->solde_initial ?? 0;
    $amountActuel = $amount->solde_actuel ?? 0;
    $amountInput = $amount->cashinput ?? 0;
    $amountInout = $amount->cashinout ?? 0;
 
    $this->set(compact('cashBoxes','amountInout','myCollabots','userData','cashMovements', 'search', 'from', 'amountInit','amountInput','amountActuel','to'));
    }

    /**
     * View method
     *
     * @param string|null $id Cash Box id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
          $this->CashBoxes = $this->fetchTable('CashBoxes');
            $cashBox = $this->CashBoxes->get($id, contain: ['CashMovements']);
            $this->set(compact('cashBox'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->CashBoxes = $this->fetchTable('CashBoxes');
        $cashBox = $this->CashBoxes->newEmptyEntity();
        $UsersTable = $this->fetchTable('Users');
        $userData = $UsersTable->find()->where(['id'=> $this->currentUser->id])->first();
        $mystartup =  $userData->startup_id;
        $responsables = $UsersTable->find('list', keyField: 'id', valueField: 'firstname')
                                    ->where(['startup_id'=> $mystartup])
                                    ->toArray();
        
        if ($this->request->is('post')) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            $cashBox->create_uid = $this->currentUser->id;
            $cashBox->uuid = Text::uuid();
            $cashBox->statut = 'open';
            // debug($cashBox);die();
            if ($this->CashBoxes->save($cashBox)) {
                $this->Flash->success(__('The cash box has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('cashBox','responsables'));
    }


      public function newCashBoxAndCashMouvement()
    {
        $cashBoxesTable = $this->fetchTable('CashBoxes');
        $cashBox = $cashBoxesTable->newEmptyEntity();
                $cashBox->name = 'name';
                $cashBox->statut = 'ouverte';
                $cashBox->responsable_id = 2;
                $cashBox->create_uid = 2;
                $cashBox->uuid = text::uuid();
                if ($cashBoxesTable->save($cashBox)) {
                    $idCashBox = $cashBox->id;
                return $this->redirect(['controller'=>'CashMovements','action'=>'add',$idCashBox]);
        }
        $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        $this->set(compact('cashBox'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cash Box id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($uuid)
    {
        $this->CashBoxes = $this->fetchTable('CashBoxes');
        $cashBox = $this->CashBoxes->findByUuid($uuid)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            if ($this->CashBoxes->save($cashBox)) {
                $this->Flash->success(__('The cash box has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $users = $this->CashBoxes->Users->find('list',  keyField: 'id', limit: 200)->all();
        //   debug($users);
        //   exit();
        $this->set(compact('cashBox','users'));
    }


    public function transactions($uuid)
    {
        $this->CashBoxes = $this->fetchTable('CashBoxes');
        $CashMovements = $this->fetchTable('CashMovements');
        $motifTable = $this->fetchTable('Motifs');
        $startupId = 1;

        $motifs = $motifTable->find('list', keyField: 'id', valueField: 'content')
                                    ->where(['startup_id'=> $startupId])
                                    ->toArray();
    
        // recuperer le dernier mouvement
        $query = $CashMovements->find()
                ->contain(['CashBoxes', 'Users']);
        $cashMovs = $this->paginate($query, [
                        'limit' => 1
                         ]);
        $cashBox = $this->CashBoxes->findByUuid($uuid)->first();
        // recuperer les montants 
        $amountCash =  $cashBox->solde_actuel;
        $amountInit =  $cashBox->solde_initial;
        $amountInput =  $cashBox->cashinput;
        $amountInout =  $cashBox->cashinout;
        if (!$cashBox) {
            $this->Flash->error(__('Action impossible.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            $typeIndex =  $this->request->getData('type');
            $amount = $this->request->getData('montant');
            $cashMov = $CashMovements->newEmptyEntity();
            $cashMov->montant = $this->request->getData('montant');
            $type = $this->request->getData('type');
            $cashMov->cash_box_id =  $cashBox->id;
            if ($typeIndex == 0) {
                $cashMov->type =  'entrée';
            }else{
                $cashMov->type =  'sortie';
            }
            $cashMov->motif_id = $this->request->getData('motif');
            $cashMov->user_id = 1;
            $cashMov->justificatif =  $this->request->getData('justificatif');
            $cashMov->create_uid =  2;
            $cashMov->uuid = Text::uuid();
            // debug($cashMov);die(); 
            if($CashMovements->save($cashMov)){
                // SOUSTRAIRE SI LE TYPE EST UNE SORTIE
                if($type == 1 ){
                    if( $cashBox->solde_actuel  < $amount){
                        // debug('test'); die();
                        return $this->redirect(['controller' => 'CashBoxes', 'action' => 'transactions', $uuid]);
                    }else{
                        $cashBox->solde_actuel -= $amount;
                        $cashBox->cashinout += $amount;
                    }
                }else{
                // AJOUTER SI LE TYPE EST UNE entrée
                    $cashBox->solde_actuel += $amount;
                    $cashBox->cashinput += $amount;
                }
                if ($this->CashBoxes->save($cashBox)) {
                    $this->Flash->success(__('The cash box has been saved.'));
                    // return $this->redirect(['action' => 'index']);
                    return $this->redirect(['controller' => 'CashBoxes', 'action' => 'transactions', $uuid]);
                }
                $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('motifs','cashBox','cashMovs','amountInit','amountInput','amountInout','amountCash'));
    }

    // Methode de transfert d'une caisse vers une autre
    public function shareCashBox(){
        $data = $this->request->getData();
        $receiver = $data['receiver'];
        $uuid = $data['cashbox_uuid'];
        // debug($receiver);
        // exit();
        $usersId = $this->currentUser->id;
        $receivercashBox = $this->fetchTable('Cashboxes')->find()->where(['responsable_id'=> $receiver])->first();
        $mycashBox = $this->fetchTable('Cashboxes')->find()->where(['uuid'=>  $uuid])->first();
        if ($mycashBox->solde_actuel < $data['amount']) {
            $result = ['status'=>0, 'error'=>4,'message'=>'Le solde de votre caisse est inssufisant','code'=>'200'];
            return $this->Json($result);
        }
        // Creer le mouvement de transfert
        $CashMovTable = $this->fetchTable('CashMovements');
        $cashMov = $CashMovTable->newEmptyEntity();
        $cashMov->cash_box_id =  $receivercashBox->id;
        $cashMov->motif_id = 1;
        $cashMov->type =  1;
        $cashMov->user_id = $usersId;
        $cashMov->justificatif = 'transfert';
        $cashMov->create_uid =  2;
        $cashMov->montant =  $data['amount'];
        $cashMov->uuid = Text::uuid();
        // debug($cashMov);die();
        if ($CashMovTable->save($cashMov)) {
             $mycashBox->solde_actuel  -= $data['amount'];
             $receivercashBox->solde_actuel += $data['amount'];
            //  debug($receivercashBox);die();
             if ($this->fetchTable('Cashboxes')->save($receivercashBox) && $this->fetchTable('Cashboxes')->save($mycashBox)) {
                // debug($mycashBox);exit();
                $result = ['status'=>1, 'error'=>0,'message'=>'Montant transferé avec succès !'];
                return $this->Json($result);
             }
        }
    }

    public function close($uuid) {
        $cashBox = $this->fetchTable('Cashboxes')->findByUuid($uuid)->first();
        // debug($cashBox);die();
        if (empty($cashBox)) {
          return $this->redirect(['action' => 'index']);
        }
        $cashBox->statut = 'close';
        if($this->fetchTable('Cashboxes')->save($cashBox)){
          return $this->redirect(['action' => 'index']);
        }
         return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cash Box id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
          $this->CashBoxes = $this->fetchTable('CashBoxes');
        $this->request->allowMethod(['post', 'delete']);
        $cashBox = $this->CashBoxes->get($id);
        if ($this->CashBoxes->delete($cashBox)) {
            $this->Flash->success(__('The cash box has been deleted.'));
        } else {
            $this->Flash->error(__('The cash box could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
