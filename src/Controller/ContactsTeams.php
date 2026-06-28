<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContactsTeams Controller
 *
 * @property \App\Model\Table\ContactsTeamsTable $ContactsTeams
 */
class ContactsTeamsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContactsTeams->find()
            ->contain(['Contacts', 'Teams']);
        $contactsTeams = $this->paginate($query);

        $this->set(compact('contactsTeams'));
    }

    /**
     * View method
     *
     * @param string|null $id Contacts Team id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contactsTeam = $this->ContactsTeams->get($id, contain: ['Contacts', 'Teams']);
        $this->set(compact('contactsTeam'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contactsTeam = $this->ContactsTeams->newEmptyEntity();
        if ($this->request->is('post')) {
            $contactsTeam = $this->ContactsTeams->patchEntity($contactsTeam, $this->request->getData());
            if ($this->ContactsTeams->save($contactsTeam)) {
                $this->Flash->success(__('The contacts team has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contacts team could not be saved. Please, try again.'));
        }
        $contacts = $this->ContactsTeams->Contacts->find('list', limit: 200)->all();
        $teams = $this->ContactsTeams->Teams->find('list', limit: 200)->all();
        $this->set(compact('contactsTeam', 'contacts', 'teams'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contacts Team id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contactsTeam = $this->ContactsTeams->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contactsTeam = $this->ContactsTeams->patchEntity($contactsTeam, $this->request->getData());
            if ($this->ContactsTeams->save($contactsTeam)) {
                $this->Flash->success(__('The contacts team has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contacts team could not be saved. Please, try again.'));
        }
        $contacts = $this->ContactsTeams->Contacts->find('list', limit: 200)->all();
        $teams = $this->ContactsTeams->Teams->find('list', limit: 200)->all();
        $this->set(compact('contactsTeam', 'contacts', 'teams'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contacts Team id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactsTeam = $this->ContactsTeams->get($id);
        if ($this->ContactsTeams->delete($contactsTeam)) {
            $this->Flash->success(__('The contacts team has been deleted.'));
        } else {
            $this->Flash->error(__('The contacts team could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
