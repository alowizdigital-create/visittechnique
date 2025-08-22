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
        $query = $this->CashBoxes->find();
        $cashBoxes = $this->paginate($query);

        $this->set(compact('cashBoxes'));
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
        if ($this->request->is('post')) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            if ($this->CashBoxes->save($cashBox)) {
                $this->Flash->success(__('The cash box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('cashBox'));
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
        // }
     
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
    public function edit($id = null)
    {
          $this->CashBoxes = $this->fetchTable('CashBoxes');
        $cashBox = $this->CashBoxes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            if ($this->CashBoxes->save($cashBox)) {
                $this->Flash->success(__('The cash box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('cashBox'));
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
