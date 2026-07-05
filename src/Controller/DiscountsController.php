<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Discounts Controller
 *
 * @property \App\Model\Table\DiscountsTable $Discounts
 */
class DiscountsController extends AppController
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
        $adminLogin = $adminTable->findById($user->id)->first();
        $today = new \DateTime();
        $todayDate = $today->format('Y-m-d');
        if ($adminLogin) {
            $startup_id = $adminLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $startup_id = $accountLogin->startup_id;
        }
        $query = $this->Discounts->find()->where(['Discounts.startup_id'=>$startup_id])->contain(['Genders']);
        $discounts = $this->paginate($query);
        $this->set(compact('discounts','todayDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discount = $this->Discounts->get($id, contain: ['Genders']);
        $this->set(compact('discount'));
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
            $startup_id = $adminLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $startup_id = $accountLogin->startup_id;
        }
        $discount = $this->Discounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            // debug();die();
            $discount->create_uid = $this->currentUser->id;
            $discount->write_uid = $this->currentUser->id;
            $discount->startup_id = $startup_id;
            $discount->end_date = $this->request->getData('date');
            $discount->uuid = Text::uuid();
            $discount->gender_id = $this->request->getData('gender_id');
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        $genders = $this->Discounts->Genders->find('list', limit: 200)->all();
        $this->set(compact('discount', 'genders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
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
        $discount = $this->Discounts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            $discount->end_date = $this->request->getData('date');
            // debug($discount);
            // die();
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        $genders = $this->Discounts->Genders->find('list', limit: 200)->where(['startup_id'=>$startup_id])->all();
        $this->set(compact('discount', 'genders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discount = $this->Discounts->get($id);
        if ($this->Discounts->delete($discount)) {
            $this->Flash->success(__('The discount has been deleted.'));
        } else {
            $this->Flash->error(__('The discount could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
