<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Genders Controller
 *
 * @property \App\Model\Table\GendersTable $Genders
 */
class GendersController extends AppController
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
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }
        $query = $this->Genders->find();
        $genders = $this->paginate($query);
        $this->set(compact('genders'));
    }

    /**
     * View method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gender = $this->Genders->get($id, contain: ['Discounts', 'Inspections']);
        $this->set(compact('gender'));
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
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $startup_id = $accountLogin->startup_id;
        }
        $gender = $this->Genders->newEmptyEntity();
        if ($this->request->is('post')) {
            $gender = $this->Genders->patchEntity($gender, $this->request->getData());
            $gender->price = $this->request->getData('price');
            $gender->create_uid = $this->currentUser->id;
            $gender->write_uid = $this->currentUser->id;
            $gender->startup_id = $startup_id; 
            $gender->numbermonthvisit = $this->request->getData('duration');
            $gender->uuid = Text::uuid();
            if ($this->Genders->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gender could not be saved. Please, try again.'));
        }
        $this->set(compact('gender'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $gender = $this->Genders->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gender = $this->Genders->patchEntity($gender, $this->request->getData());
            $gender->numbermonthvisit = $this->request->getData('duration');
            $gender->price = $this->request->getData('price');
            if ($this->Genders->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gender could not be saved. Please, try again.'));
        }
        $this->set(compact('gender'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gender = $this->Genders->get($id);
        if ($this->Genders->delete($gender)) {
            $this->Flash->success(__('The gender has been deleted.'));
        } else {
            $this->Flash->error(__('The gender could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
