<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Client;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{

    public function testSend()
    {
        $this->request->allowMethod(['post']); 
        $data = $this->request->getData();
        debug($data);
        exit();
        $to = $data['to'] ?? '';
        $message = $data['message'] ?? '';
        $from = 'vehicontrols'; 

        $http = new Client();

        $response = $http->post('https://BASE_URL/api/sms/send', [
            'to' => $to,
            'from' => $from,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'dnd',
            'api_key' => 'TA_CLE_API_TERMII_ICI'
        ], [
            'type' => 'json'
        ]);

        $json = $response->isOk() ? $response->getJson() : ['error' => 'Échec de l\'envoi'];

        $this->set([
            'success' => $response->isOk(),
            'response' => $json,
            '_serialize' => ['success', 'response']
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Messages->find()
            ->contain(['Inspections', 'Customers']);
        $messages = $this->paginate($query);

        $this->set(compact('messages'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, contain: ['Inspections', 'Customers']);
        $this->set(compact('message'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEmptyEntity();
        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $inspections = $this->Messages->Inspections->find('list', limit: 200)->all();
        $customers = $this->Messages->Customers->find('list', limit: 200)->all();
        $this->set(compact('message', 'inspections', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $inspections = $this->Messages->Inspections->find('list', limit: 200)->all();
        $customers = $this->Messages->Customers->find('list', limit: 200)->all();
        $this->set(compact('message', 'inspections', 'customers'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
