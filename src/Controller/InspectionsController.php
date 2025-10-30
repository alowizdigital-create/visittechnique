<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Inspections Controller
 *
 * @property \App\Model\Table\InspectionsTable $Inspections
 */
class InspectionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Inspections->find()
            ->contain(['Customers', 'Genders']);
        $inspections = $this->paginate($query);
        $this->set(compact('inspections'));
    }

    /**
     * View method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inspection = $this->Inspections->get($id, contain: ['Customers', 'Genders', 'Messages', 'Payments']);
        $this->set(compact('inspection'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inspection = $this->Inspections->newEmptyEntity();
        if ($this->request->is('post')) {
            $inspection = $this->Inspections->patchEntity($inspection, $this->request->getData());
            $vehicleId = $inspection->vehicle_id;
            $customer = $this->fetchTable('Vehicles')->find()
                                ->select(['customer_id'])
                                ->where(['id' => $vehicleId])
                                ->enableHydration(false)
                                ->first();
            $gender = $this->fetchTable('Vehicles')->find()
                                ->select(['gender_id'])
                                ->where(['id' => $vehicleId])
                                ->enableHydration(false)
                                ->first();
            $inspection->customer_id = $customer['customer_id'] ?? null;
            $inspection->gender_id = $gender['gender_id'] ?? null;
            $inspection->status = 'pending';
            $inspection->create_uid = $this->currentUser->id;
            $inspection->write_uid = $this->currentUser->id;
            $inspection->uuid = Text::uuid();
            // debug($inspection);
            // exit();
            if ($this->Inspections->save($inspection)) {
                $this->Flash->success(__('The inspection has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection could not be saved. Please, try again.'));
        }
        $customers = $this->Inspections->Customers->find('list', limit: 200)->all();
        $genders = $this->Inspections->Genders->find('list', limit: 200)->all();
        $vehicles = $this->Inspections->Vehicles->find('list', limit: 200)->all();
        $this->set(compact('inspection', 'customers', 'genders','vehicles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inspection = $this->Inspections->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inspection = $this->Inspections->patchEntity($inspection, $this->request->getData());
            if ($this->Inspections->save($inspection)) {
                $this->Flash->success(__('The inspection has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection could not be saved. Please, try again.'));
        }
        $customers = $this->Inspections->Customers->find('list', limit: 200)->all();
        $genders = $this->Inspections->Genders->find('list', limit: 200)->all();
        $this->set(compact('inspection', 'customers', 'genders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inspection = $this->Inspections->get($id);
        if ($this->Inspections->delete($inspection)) {
            $this->Flash->success(__('The inspection has been deleted.'));
        } else {
            $this->Flash->error(__('The inspection could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
