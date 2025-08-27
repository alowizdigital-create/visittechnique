<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Utility\Text;

/**
 * CashMovements Controller
 *
 * @property \App\Model\Table\CashMovementsTable $CashMovements
 */
class CashMovementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
         $this->CashMovements = $this->fetchTable('CashMovements');
        $query = $this->CashMovements->find()
                ->contain(['CashBoxes', 'Users']);
        $cashMovements = $this->paginate($query);

        $this->set(compact('cashMovements'));
    }

    /**
     * View method
     *
     * @param string|null $id Cash Movement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
         $this->CashMovements = $this->fetchTable('CashMovements');
        $cashMovement = $this->CashMovements->get($id, contain: ['CashBoxes', 'Users']);
        $this->set(compact('cashMovement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //      $this->CashMovements = $this->fetchTable('CashMovements');
    //     $cashMovement = $this->CashMovements->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $cashMovement = $this->CashMovements->patchEntity($cashMovement, $this->request->getData());
    //         if ($this->CashMovements->save($cashMovement)) {
    //             $this->Flash->success(__('The cash movement has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The cash movement could not be saved. Please, try again.'));
    //     }
    //     $cashBoxes = $this->CashMovements->CashBoxes->find('list', limit: 200)->all();
    //     $users = $this->CashMovements->Users->find('list', limit: 200)->all();
    //     $this->set(compact('cashMovement', 'cashBoxes', 'users'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Cash Movement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
         $this->CashMovements = $this->fetchTable('CashMovements');
        $cashMovement = $this->CashMovements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashMovement = $this->CashMovements->patchEntity($cashMovement, $this->request->getData());
            if ($this->CashMovements->save($cashMovement)) {
                $this->Flash->success(__('The cash movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash movement could not be saved. Please, try again.'));
        }
        $cashBoxes = $this->CashMovements->CashBoxes->find('list', limit: 200)->all();
        $users = $this->CashMovements->Users->find('list', limit: 200)->all();
        $this->set(compact('cashMovement', 'cashBoxes', 'users'));
    }


        
    public function add($id)
    {
        $cashBoxesTable = $this->fetchTable('CashBoxes');
        $cashMovementsTable = $this->fetchTable('CashMovements');
        $cashBox = $cashBoxesTable->get($id);
        $amountCash = $cashBox->solde_actuel;
        $amountInit = $cashBox->solde_initial;
        $amountInput = $cashBox->cashinput;
        $amountInout = $cashBox->cashinout;
        // Paginer toutes les cashboxes 
        $query = $cashMovementsTable->find()
                ->contain(['CashBoxes', 'Users']);
        $cashMovs = $this->paginate($query);

        if ($cashBox->statut === 'cloturee') {
            $this->Flash->error('Cette caisse est clôturée. Aucune entrée n’est possible.');
            return $this->redirect(['controller' => 'CashBoxes', 'action' => 'view', $id]);
        }
        $cashMovement = $cashMovementsTable->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // $data['type'] = 'entrée';
            $data['cash_box_id'] = $id;
            $data['user_id'] = 1;
            $cashMovement = $cashMovementsTable->patchEntity($cashMovement, $data);
            $type = $cashMovement->type;
            // SOUSTRAIRE SI LE TYPE EST UNE SORTIE
            if($type == 1 ){
                if( $cashBox->solde_actuel  < $cashMovement->montant){
                    // debug('test'); die();
                    return $this->redirect(['controller' => 'CashMovements', 'action' => 'add', $id]);
                }else{
                    $cashBox->solde_actuel -= $cashMovement->montant;
                    $cashBox->cashinout += $cashMovement->montant;
                }
            }else{
              // AJOUTER SI LE TYPE EST UNE entrée
                 $cashBox->solde_actuel += $cashMovement->montant;
                 $cashBox->cashinput += $cashMovement->montant;
              
            }
            $cashMovement->create_uid = 2; 
            $cashMovement->uuid = 'djfhjedf';
            $cashMovement->user_id = 1;
             $cashMovement->motif = 1;
                //    debug($cashMovement);
                //  exit();
            try {
                $cashBoxesTable->getConnection()->transactional(function () use ($cashBoxesTable, $cashMovementsTable, $cashBox, $cashMovement) {
                    // debug($cashMovement);
                    // exit();
                    $cashBoxesTable->saveOrFail($cashBox);
                    $cashMovementsTable->saveOrFail($cashMovement);
                });
                $this->Flash->success('Encaissement enregistré avec succès.');
                return $this->redirect(['controller' => 'CashMovements', 'action' => 'add', $id]);
            } catch (\Exception $e) {
                $this->Flash->error('Erreur lors de l\'encaissement : ' . $e->getMessage());
            }
        }
        $this->set(compact('cashMovs','cashMovement', 'cashBox','amountCash','amountInit','amountInout','amountInput'));
    }



    /**
     * Delete method
     *
     * @param string|null $id Cash Movement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
         $this->CashMovements = $this->fetchTable('CashMovements');
        $this->request->allowMethod(['post', 'delete']);
        $cashMovement = $this->CashMovements->get($id);
        if ($this->CashMovements->delete($cashMovement)) {
            $this->Flash->success(__('The cash movement has been deleted.'));
        } else {
            $this->Flash->error(__('The cash movement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
