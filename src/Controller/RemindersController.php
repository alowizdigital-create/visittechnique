<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Reminders Controller
 *
 * @property \App\Model\Table\RemindersTable $Reminders
 */
class RemindersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Reminders->find()
            ->contain(['Genders', 'Templates']);
        $reminders = $this->paginate($query);
        $this->set(compact('reminders'));
    }

    /**
     * View method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reminder = $this->Reminders->get($id, contain: ['Genders', 'Templates']);
        $this->set(compact('reminder'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $Templates = $this->fetchTable('Templates');
        $template = $Templates->newEmptyEntity();
        $reminder = $this->Reminders->newEmptyEntity();
        if ($this->request->is('post')) {
            $reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());
            $name = $this->request->getData('name');
            $content = $this->request->getData('content');
            $template->name = $name;
            $template->content = $content;
            $template->create_uid = $this->currentUser->id;
            $template->write_uid = $this->currentUser->id;
            $template->uuid = Text::uuid();
            if ($Templates->save($template)) {
                  $template_id = $template->id;
            }
            $reminder->template_id = $template_id;
            $reminder->create_uid = $this->currentUser->id;
            $reminder->write_uid = $this->currentUser->id;
            $reminder->uuid = Text::uuid();
            // debug($reminder);die();
            if ($this->Reminders->save($reminder)) {
                $this->Flash->success(__('The reminder has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reminder could not be saved. Please, try again.'));
        }
        $genders = $this->Reminders->Genders->find('list', limit: 200)->all();
        $templates = $this->Reminders->Templates->find('list', limit: 200)->all();
        $this->set(compact('reminder', 'genders', 'templates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reminder = $this->Reminders->get($id, contain: []);
        $templateId = $reminder->template_id;
        $Templates = $this->fetchTable('Templates');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());
            // Gestion de template
            $template = $Templates->find()->where(['id'=>$templateId])->first();
            $name = $this->request->getData('name');
            $content = $this->request->getData('content');
            $template->name = $name;
            $template->content = $content;
            if ($Templates->save($template)) {
            }
            if ($this->Reminders->save($reminder)) {
                $this->Flash->success(__('The reminder has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reminder could not be saved. Please, try again.'));
        }
        $genders = $this->Reminders->Genders->find('list', limit: 200)->all();
        $templates = $this->Reminders->Templates->find('list', limit: 200)->all();
        $content = $this->Reminders->Templates->find()
                                            ->select(['content'])
                                            ->where(['id' => $templateId])
                                            ->first();
        $this->set(compact('reminder', 'genders', 'templates','content'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reminder = $this->Reminders->get($id);
        if ($this->Reminders->delete($reminder)) {
            $this->Flash->success(__('The reminder has been deleted.'));
        } else {
            $this->Flash->error(__('The reminder could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
