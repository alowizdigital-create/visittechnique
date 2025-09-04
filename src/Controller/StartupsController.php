<?php
declare(strict_types=1);

namespace App\Controller;

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
        $startup = $this->Startups->get($id, contain: ['Customers', 'Genders', 'Motifs']);
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
            $startup = $this->Startups->patchEntity($startup, $this->request->getData());
            if ($this->Startups->save($startup)) {
                $this->Flash->success(__('The startup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The startup could not be saved. Please, try again.'));
        }
        $this->set(compact('startup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Startup id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $startup = $this->Startups->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $startup = $this->Startups->patchEntity($startup, $this->request->getData());
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
