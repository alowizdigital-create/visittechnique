<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use DateTime;

use function PHPUnit\Framework\isNull;

/**
 * Vehicles Controller
 *
 * @property \App\Model\Table\VehiclesTable $Vehicles
 */
class VehiclesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Vehicles->find()
            ->contain(['Customers']);
        $vehicles = $this->paginate($query);
        $this->set(compact('vehicles'));
    }

    /**
     * View method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vehicle = $this->Vehicles->get($id, contain: ['Customers']);
        $this->set(compact('vehicle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vehicle = $this->Vehicles->newEmptyEntity();
    //     debug($vehicle);
    //    exit();
        if ($this->request->is('post')) {
            $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());
            $customer_id = $this->request->getData('customer_id');
            $customer_phone = $this->request->getData('phone');
            $customerId = $customer_id[0];
            //  debug($customer_id);die();
            $convert = (int)$customer_id[0];
            // debug($convert);die();
            if ($convert == 0) {
                $Customers = $this->fetchTable('Customers');
                $customer = $Customers->newEmptyEntity();
                $customer->name = $customer_id[0];
                $customer->phone = $customer_phone;
                $customer->create_uid = $this->currentUser->id;
                $customer->write_uid = $this->currentUser->id;
                $customer->startup_id = 1;
                $customer->uuid = Text::uuid();
                if ($Customers->save($customer)) {
                   $customerId = $customer->id;
                }
            }
            $vehicle->customer_id = $customerId;
            $vehicle->create_uid = $this->currentUser->id;
            $vehicle->write_uid = $this->currentUser->id;
            $vehicle->uuid = Text::uuid();
            // debug($vehicle);die();
            if ($this->Vehicles->save($vehicle)) {
               
                $vehicle_id = $vehicle->id;
                $gender_id = $vehicle->gender_id;
                $Inspections = $this->fetchTable('Inspections');
                $inspection = $Inspections->newEmptyEntity();
                $inspection->vehicle_id = $vehicle_id;
                $inspection->gender_id = $gender_id;
                $inspection->status = 'confirm';
                $inspection->customer_id = $vehicle->customer_id;
                $inspection->end_date = (new DateTime())->modify('+90 days');
                $inspection->create_uid = $this->currentUser->id;
                $inspection->write_uid = $this->currentUser->id;
                $inspection->uuid = Text::uuid();
                // debug($inspection);
                // exit();
                if ($Inspections->save($inspection)) {
                    $customer = $this->fetchTable('Customers')->find()
                                 ->where(['id'=> $inspection->customer_id ])->first();
                                //  debug($customer);
                                //  exit();
                    $Messages = $this->fetchTable('Messages');
                    $Templates = $this->fetchTable('Templates');
                    $Reminders = $this->fetchTable('Reminders');
                    $reminder = $Reminders->find()->where(['gender_id'=> $gender_id])->first();
                    $template_id = $reminder['template_id'];
                    $template = $Templates->find()->where(['id'=> $template_id])->first();
                    $content = $template['content'];
                    $replacements = [
                       '[name]' => $customer['name'] ?? '',
                       '[date]' =>  $inspection->end_date->format('d/m/Y') ?? '',
                     ];
                    $finalContent = str_replace(array_keys($replacements), array_values($replacements), $content);
                    $message = $Messages->newEmptyEntity();
                    $message->content = $finalContent;
                    $message->status = 'pending';
                    $message->receiver =  $customer['phone'];
                    $message->inspection_id = $inspection->id;
                    $message->customer_id = $inspection->customer_id;
                    $message->sent_date = $inspection->end_date;
                    $message->create_uid = $this->currentUser->id;
                    $message->write_uid = $this->currentUser->id;
                    $message->uuid = Text::uuid();
                    if ($Messages->save($message)) {
                           return $this->redirect(['action' => 'index']);
                        }
                    }
                $result = ['code'=>'200','msg'=>'Véhicule enregisté']; 
                return $this->Json($result);
            }
            $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
        }
        $Reminders = $this->fetchTable('Reminders');

      
        $gendersQuery = $this->Vehicles->Genders->find('all')->all();

        $genders = [];
        foreach ($gendersQuery as $gender) {
            // Vérifie s’il existe un rappel pour ce gender
            $isOk =  $Reminders->exists(['gender_id' => $gender->id]);
            if ($isOk) {
                $genders[$gender->id] = $gender->name;
            }
        }
       $customers = $this->Vehicles->Customers->find()
            ->select(['id', 'name', 'phone'])
            ->limit(200)
            ->all();
        $customerOptions = [];
            foreach ($customers as $customer) {
                $customerOptions[$customer->id] = $customer->name . ' (' . $customer->phone . ')';
            }
      $this->set(compact('vehicle', 'customers', 'customerOptions', 'genders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vehicle = $this->Vehicles->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('The vehicle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
        }
        $customers = $this->Vehicles->Customers->find('list', limit: 200)->all();
        $this->set(compact('vehicle', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vehicle id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vehicle = $this->Vehicles->get($id);
        if ($this->Vehicles->delete($vehicle)) {
            $this->Flash->success(__('The vehicle has been deleted.'));
        } else {
            $this->Flash->error(__('The vehicle could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
