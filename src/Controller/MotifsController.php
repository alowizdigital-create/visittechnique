<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Motifs Controller
 *
 * @property \App\Model\Table\MotifsTable $Motifs
 */
class MotifsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Motifs->find()
            ->contain(['Startups']);
        $motifs = $this->paginate($query);

        $this->set(compact('motifs'));
    }

    /**
     * View method
     *
     * @param string|null $id Motif id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $motif = $this->Motifs->get($id, contain: ['Startups', 'CashMovements']);
        $this->set(compact('motif'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $motif = $this->Motifs->newEmptyEntity();
        if ($this->request->is('post')) {
            $motif = $this->Motifs->patchEntity($motif, $this->request->getData());
            if ($this->Motifs->save($motif)) {
                $this->Flash->success(__('The motif has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The motif could not be saved. Please, try again.'));
        }
        $startups = $this->Motifs->Startups->find('list', limit: 200)->all();
        $this->set(compact('motif', 'startups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Motif id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $motif = $this->Motifs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $motif = $this->Motifs->patchEntity($motif, $this->request->getData());
            if ($this->Motifs->save($motif)) {
                $this->Flash->success(__('The motif has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The motif could not be saved. Please, try again.'));
        }
        $startups = $this->Motifs->Startups->find('list', limit: 200)->all();
        $this->set(compact('motif', 'startups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Motif id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $motif = $this->Motifs->get($id);
        if ($this->Motifs->delete($motif)) {
            $this->Flash->success(__('The motif has been deleted.'));
        } else {
            $this->Flash->error(__('The motif could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
