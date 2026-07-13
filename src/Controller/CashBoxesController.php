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
    $user = $this->currentUser;

    // 🔹 Tables
    $Accounts       = $this->fetchTable('Accounts');
    $Admins         = $this->fetchTable('Admins');
    $CashBoxes      = $this->fetchTable('CashBoxes');
    $CashMovements  = $this->fetchTable('CashMovements');

    // 🔹 Récupération utilisateur
    $userData = $Admins->findById($user->id)->first()
        ?? $Accounts->findById($user->id)->first();

    if (!$userData) {
        throw new \Cake\Http\Exception\NotFoundException('Utilisateur introuvable');
    }

    $startupId = $userData->startup_id ?? null;

    // 🔹 Récupération des caisses
    if (in_array($userData->role, ['admin', 'directeur'])) {
        $queryCashBoxes = $CashBoxes->find()
            ->where([
                'CashBoxes.startup_id' => $startupId
            ]);
    } else {
        $queryCashBoxes = $CashBoxes->find()
            ->where([
                'CashBoxes.responsable_id' => $user->id
            ]);
    }

    $cashBoxes = $this->paginate($queryCashBoxes);

    // 🔹 Responsables
    $responsables = $Accounts->find('list', [
        'keyField' => 'id',
        'valueField' => 'username'
    ])
    ->where(['startup_id' => $startupId])
    ->toArray();

    $myCollabots = $responsables;

    // 🔹 Récupération de la caisse de l'utilisateur
    $mycashbox = $CashBoxes->find()
        ->where(['responsable_id' => $userData->id])
        ->first();

    $mycashboxId = 0;

    if ($mycashbox) {
        $mycashboxId = $mycashbox->id;
        $mycashbox->notification = 0;
        $CashBoxes->save($mycashbox);
    }

    // 🔹 REQUÊTE MOUVEMENTS (LOGIQUE PRINCIPALE 🔥)
    if (in_array($userData->role, ['admin', 'directeur'])) {

        // ✅ TOUS les mouvements de l’entreprise
        $query = $CashMovements->find()
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->where([
                'CashBoxes.startup_id' => $startupId
            ])
            ->order(['CashMovements.created' => 'DESC']);

    } else {

        // 🔒 Accès limité
        $query = $CashMovements->find()
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->where([
                'OR' => [
                    ['CashMovements.create_uid' => $userData->id],
                    ['CashMovements.cash_box_id' => $mycashboxId],
                    ['CashMovements.sender' => $mycashboxId],
                ]
            ])
            ->order(['CashMovements.created' => 'DESC']);
    }

    // 🔍 Filtres
    $search  = $this->request->getQuery('search');
    $search2 = $this->request->getQuery('search2');
    $from    = $this->request->getQuery('from');
    $to      = $this->request->getQuery('to');

    if (!empty($search)) {
        $query
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Accounts')
            ->andWhere([
                'OR' => [
                    'CashMovements.type LIKE' => "%$search%",
                    'CashBoxes.name LIKE' => "%$search%",
                    'Accounts.username LIKE' => "%$search%",
                ]
            ]);
    }

    if (!empty($search2)) {
        $query->andWhere([
            'OR' => [
                'Vehicles.registration_number LIKE' => "%$search2%",
                'Customers.name LIKE' => "%$search2%",
            ]
        ]);
    }

    if (!empty($from)) {
        $query->andWhere([
            'CashMovements.created >=' => $from . ' 00:00:00'
        ]);
    }

    if (!empty($to)) {
        $query->andWhere([
            'CashMovements.created <=' => $to . ' 23:59:59'
        ]);
    }

    // 🔹 Pagination
    $paginateOptions = [
        'order' => ['CashMovements.created' => 'DESC']
    ];

    if (empty($search) && empty($from) && empty($to)) {
        $paginateOptions['limit'] = 5;
    }

    $cashMovements = $this->paginate($query, $paginateOptions);

    // 🔹 Montants
    $amount = $CashBoxes->find()
        ->where(['responsable_id' => $userData->id])
        ->first();

    $amountInit   = $amount->solde_initial ?? 0;
    $amountActuel = $amount->solde_actuel ?? 0;
    $amountInput  = $amount->cashinput ?? 0;
    $amountInout  = $amount->cashinout ?? 0;

    // 🔹 Envoi vers la vue
    $this->set(compact(
        'responsables',
        'cashBoxes',
        'amountInout',
        'myCollabots',
        'userData',
        'cashMovements',
        'search',
        'from',
        'amountInit',
        'amountInput',
        'amountActuel',
        'to'
    ));
}



   public function report()
{
    $user = $this->currentUser;

    // 🔹 Tables
    $Accounts       = $this->fetchTable('Accounts');
    $Admins         = $this->fetchTable('Admins');
    $CashBoxes      = $this->fetchTable('CashBoxes');
    $CashMovements  = $this->fetchTable('CashMovements');

    // 🔹 Récupération utilisateur
    $userData = $Admins->findById($user->id)->first()
        ?? $Accounts->findById($user->id)->first();

    if (!$userData) {
        throw new \Cake\Http\Exception\NotFoundException('Utilisateur introuvable');
    }

    $startupId = $userData->startup_id ?? 12;

    // 🔹 Récupération des caisses
    if (in_array($userData->role, ['admin', 'directeur'])) {
        $queryCashBoxes = $CashBoxes->find()
            ->where([
                'CashBoxes.startup_id' => $startupId
            ]);
    } else {
        $queryCashBoxes = $CashBoxes->find()
            ->where([
                'CashBoxes.responsable_id' => $user->id
            ]);
    }

    $cashBoxes = $this->paginate($queryCashBoxes);

    // 🔹 Responsables
    $responsables = $Accounts->find('list', [
        'keyField' => 'id',
        'valueField' => 'username'
    ])
    ->where(['startup_id' => $startupId])
    ->toArray();

    $myCollabots = $responsables;

    // 🔹 Récupération de la caisse de l'utilisateur
    $mycashbox = $CashBoxes->find()
        ->where(['responsable_id' => $userData->id])
        ->first();

    $mycashboxId = 0;

    if ($mycashbox) {
        $mycashboxId = $mycashbox->id;
        $mycashbox->notification = 0;
        $CashBoxes->save($mycashbox);
    }

    // 🔹 REQUÊTE MOUVEMENTS (LOGIQUE PRINCIPALE 🔥)
    if (in_array($userData->role, ['admin', 'directeur'])) {

        // ✅ TOUS les mouvements de l’entreprise
        $query = $CashMovements->find()
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->where([
                'CashBoxes.startup_id' => $startupId,
                'CashMovements.type' => 'Transfert'
                
            ])
            ->order(['CashMovements.created' => 'DESC']);

    } else {

        // 🔒 Accès limité
        $query = $CashMovements->find()
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->where([
                'OR' => [
                    ['CashMovements.create_uid' => $userData->id],
                    ['CashMovements.cash_box_id' => $mycashboxId],
                    ['CashMovements.sender' => $mycashboxId],
                ]
            ])
            ->order(['CashMovements.created' => 'DESC']);
    }

    // 🔍 Filtres
    $search  = $this->request->getQuery('search');
    $search2 = $this->request->getQuery('search2');
    $from    = $this->request->getQuery('from');
    $to      = $this->request->getQuery('to');

    if (!empty($search)) {
        $query
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Accounts')
            ->andWhere([
                'OR' => [
                    'CashMovements.type LIKE' => "%$search%",
                    'CashBoxes.name LIKE' => "%$search%",
                    'Accounts.username LIKE' => "%$search%",
                ]
            ]);
    }

    if (!empty($search2)) {
        $query->andWhere([
            'OR' => [
                'Vehicles.registration_number LIKE' => "%$search2%",
                'Customers.name LIKE' => "%$search2%",
            ]
        ]);
    }

    if (!empty($from)) {
        $query->andWhere([
            'CashMovements.created >=' => $from . ' 00:00:00'
        ]);
    }

    if (!empty($to)) {
        $query->andWhere([
            'CashMovements.created <=' => $to . ' 23:59:59'
        ]);
    }

    // 🔹 Pagination
    $paginateOptions = [
        'order' => ['CashMovements.created' => 'DESC']
    ];

    if (empty($search) && empty($from) && empty($to)) {
        $paginateOptions['limit'] = 5;
    }

    $cashMovements = $this->paginate($query, $paginateOptions);

    // 🔹 Montants
    $amount = $CashBoxes->find()
        ->where(['responsable_id' => $userData->id])
        ->first();

    $amountInit   = $amount->solde_initial ?? 0;
    $amountActuel = $amount->solde_actuel ?? 0;
    $amountInput  = $amount->cashinput ?? 0;
    $amountInout  = $amount->cashinout ?? 0;

    // 🔹 Envoi vers la vue
    $this->set(compact(
        'responsables',
       
        'userData',
        'cashMovements',
        'search',
        'from',
        'amountInit',
        'amountInput',
        'amountActuel',
        'to'
    ));
}


     
    public function indexALA()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
        }
       
        // recuperer les caisses que j ai creer et qui appartiennent a mon entreprise
        if ($userData->role == 'admin'|| $userData->role == 'directeur') {
            $query = $this->CashBoxes->find()->where(['create_uid'=>$this->currentUser->id,'startup_id'=> $userData->startup_id]);
        }
        else{ 
            $query = $this->CashBoxes->find()->where(['responsable_id'=> $this->currentUser->id]);
        }
        $cashBoxes = $this->paginate($query);
        $mystartup =  $userData->startup_id;

        $responsables = $accountTable->find('list', keyField: 'id', valueField: 'username')
                                    ->where(['startup_id'=> $mystartup])
                                    // ->contain(['Cashboxes'])
                                    ->toArray();

        $myCollabots = $accountTable->find('list', keyField: 'id', valueField: 'username')
                                    ->where(['startup_id'=> $mystartup])
                                    ->toArray();
        // Requete de recherche                             
        $CashMovements = $this->fetchTable('CashMovements');
        $this->fetchTable('CashBoxes');
        $this->fetchTable('Accounts');

        // Utilisateur courant
        $user = $this->currentUser->id;

        // recover my cashBox 
        $mycashbox = $this->CashBoxes->find()->where(['responsable_id'=> $userData->id])->first();
        if ($mycashbox) {
            $mycashboxId  = $mycashbox->id;
            $mycashbox->notification = 0;
            $this->CashBoxes->save($mycashbox);
        } else{
          $mycashboxId  = 0;
        }
        
        
        if($userData->role == 'directeur' || $userData->role == 'comptable' ){
             // Recuperation des données pour le directeur etla camptable
        
            $query = $CashMovements->find()
            // 1. UTILISER CONTAIN() POUR CHARGER LES DONNÉES DANS LES ENTITÉS 
            // C'est cette partie qui rendra $movement->inspection->vehicle disponible
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            
            // 2. UTILISER leftJoinWith() POUR FORCER LA JOINTURE EXTERNE (LEFT JOIN)
            // Cela garantit que les CashMovements sans Inspection ne sont PAS filtrés
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
        
            // 3. VOTRE FILTRAGE PAR OR
            ->where([
                'OR' => [
                    ['CashMovements.startup_id' => $mystartup],
                    // ['CashMovements.cash_box_id' => $mycashboxId],
                    // ['CashMovements.sender' => $mycashboxId],
                ]
            ])
            // 4. VOTRE TRI
            ->order(['CashMovements.created' => 'DESC']);
            
        }else{
        // Recuperation des données pour les simples utilisateurs
            $query = $CashMovements->find()
            // 1. UTILISER CONTAIN() POUR CHARGER LES DONNÉES DANS LES ENTITÉS 
            // C'est cette partie qui rendra $movement->inspection->vehicle disponible
            ->contain([
                'CashBoxes',
                'Accounts',
                'Inspections' => ['Vehicles' => ['Customers']]
            ])
            
            // 2. UTILISER leftJoinWith() POUR FORCER LA JOINTURE EXTERNE (LEFT JOIN)
            // Cela garantit que les CashMovements sans Inspection ne sont PAS filtrés
            ->leftJoinWith('Inspections')
            ->leftJoinWith('Inspections.Vehicles')
            ->leftJoinWith('Inspections.Vehicles.Customers')
        
            // 3. VOTRE FILTRAGE PAR OR
            ->where([
                'OR' => [
                    ['CashMovements.create_uid' => $userData->id],
                    ['CashMovements.cash_box_id' => $mycashboxId],
                    ['CashMovements.sender' => $mycashboxId],
                ]
            ])
            // 4. VOTRE TRI
            ->order(['CashMovements.created' => 'DESC']);
        }


        // La recherche
        // La recherche
        $search = $this->request->getQuery('search');
        $search2 = $this->request->getQuery('search2');
        $from = $this->request->getQuery('from');
        $to = $this->request->getQuery('to');

        if (!empty($search)) {
            $query
                ->leftJoinWith('CashBoxes')
                ->leftJoinWith('Accounts')
                ->andWhere([
                    'OR' => [
                        'CashMovements.type LIKE' => "%$search%",
                        'CashBoxes.name LIKE' => "%$search%",
                        'Accounts.username LIKE' => "%$search%",
                    ]
                ]);
        }

        if (!empty($search2)) {
            $query
                ->leftJoinWith('Inspections.Vehicles.Customers')
                ->andWhere([
                    'OR' => [
                        'Vehicles.registration_number LIKE' => "%$search2%",
                        'Customers.name LIKE'               => "%$search2%",
                    ]
            ]);
        }
        
        if (!empty($from)) {
            $query->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
        }

        if (!empty($to)) {
            $query->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
        }
        
        // --- Options de pagination ---
        $paginateOptions = ['order' => ['created' => 'DESC']];

        // Si pas de filtre, limiter aux 2 dernières opérations
        if (empty($search) && empty($from) && empty($to)) {
            $paginateOptions['limit'] = 7;
        }
        
         $cashMovements = $this->paginate($query, $paginateOptions);
     
        $today = new \DateTime();
        $todayDate = $today->format('Y-m-d');

        // Pagination
        $cashMovements = $this->paginate($query, $paginateOptions);

        $amount = $this->CashBoxes->find()->where(['responsable_id'=> $userData->id])->first();
        $amountInit = $amount->solde_initial ?? 0;
        $amountActuel = $amount->solde_actuel ?? 0;
        $amountInput = $amount->cashinput ?? 0;
        $amountInout = $amount->cashinout ?? 0;
    $this->set(compact('responsables','cashBoxes','amountInout','myCollabots','userData','cashMovements', 'search', 'from', 'amountInit','amountInput','amountActuel','to'));
    }
    
    
    // public function report(){
        
    // }
    

      public function index2()
{
     $user = $this->currentUser;
    $accountTable = $this->fetchTable('Accounts');
    $adminTable = $this->fetchTable('Admins');

    $adminLogin = $adminTable->findById($user->id)->first();

    if ($adminLogin) {
        $accountLogin = $adminTable->findById($user->id)->first();
        $adminLoginId = $accountLogin->id;
        $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
    } else {
        $accountLogin = $accountTable->findById($user->id)->first();
        $acountLoginId = $accountLogin->id;
        $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
    }

    $CashBoxes = $this->fetchTable('CashBoxes');

    if ($userData->role == 'admin'|| $userData->role == 'directeur') {
        $query = $CashBoxes->find()
        ->where([
            'create_uid'=>$this->currentUser->id,
            'Cashboxes.startup_id'=> $userData->startup_id
        ]);
    } else { 
        $query = $CashBoxes->find()
        ->where(['responsable_id'=> $this->currentUser->id]);
    }

    $cashBoxes = $this->paginate($query);
    $mystartup =  $userData->startup_id;

    $responsables = $accountTable->find('list', keyField: 'id', valueField: 'username')
        ->where(['startup_id'=> $mystartup])
        ->toArray();

    $myCollabots = $accountTable->find('list', keyField: 'id', valueField: 'username')
        ->where(['startup_id'=> $mystartup])
        ->toArray();

    $CashMovements = $this->fetchTable('CashMovements');
    $this->fetchTable('Accounts');

    $mycashbox = $this->CashBoxes->find()
        ->where(['responsable_id'=> $userData->id])
        ->first();

    if ($mycashbox) {
        $mycashboxId  = $mycashbox->id;
        $mycashbox->notification = 0;
        $this->CashBoxes->save($mycashbox);
    } else{
        $mycashboxId  = 0;
    }

    $query = $CashMovements->find()
        ->contain([
            'CashBoxes',
            'Accounts',
            'Inspections' => ['Vehicles' => ['Customers']]
        ])
        ->leftJoinWith('Inspections')
        ->leftJoinWith('Inspections.Vehicles')
        ->leftJoinWith('Inspections.Vehicles.Customers')

        ->where([
            'OR' => [
                ['CashMovements.create_uid' => $userData->id],
                ['CashMovements.cash_box_id' => $mycashboxId],
                ['CashMovements.sender' => $mycashboxId],
            ]
        ])
        ->order(['CashMovements.created' => 'DESC']);

    $search = $this->request->getQuery('search');
    $search2 = $this->request->getQuery('search2');
    $from = $this->request->getQuery('from');
    $to = $this->request->getQuery('to');

  
    if (!empty($search)) {
        $query
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Accounts')
            ->andWhere([
                'OR' => [
                    'CashMovements.type LIKE' => "%$search%",
                    'CashBoxes.name LIKE' => "%$search%",
                    'Accounts.username LIKE' => "%$search%",
                ]
            ]);
    }

    if (!empty($search2)) {
        $query
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->andWhere([
                'OR' => [
                    'Vehicles.registration_number LIKE' => "%$search2%",
                    'Customers.name LIKE'               => "%$search2%",
                ]
        ]);
    }

    if (!empty($from)) {
        $query->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
    }

    if (!empty($to)) {
        $query->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
    }
 
/* =========================
   CALCUL DU TOTAL DES MOUVEMENTS FILTRÉS
   ========================= */

$totalQuery = $CashMovements->find();

$totalQuery->where([
    'OR' => [
        ['CashMovements.create_uid' => $userData->id],
        ['CashMovements.cash_box_id' => $mycashboxId],
        ['CashMovements.sender' => $mycashboxId],
    ]
]);

// appliquer les mêmes filtres
if (!empty($search)) {
    $totalQuery
        ->leftJoinWith('CashBoxes')
        ->leftJoinWith('Accounts')
        ->andWhere([
            'OR' => [
                'CashMovements.type LIKE' => "%$search%",
                'CashBoxes.name LIKE' => "%$search%",
                'Accounts.username LIKE' => "%$search%",
            ]
        ]);
}

if (!empty($search2)) {
    $totalQuery
        ->leftJoinWith('Inspections.Vehicles.Customers')
        ->andWhere([
            'OR' => [
                'Vehicles.registration_number LIKE' => "%$search2%",
                'Customers.name LIKE' => "%$search2%",
            ]
        ]);
}

if (!empty($from)) {
    $totalQuery->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
}

if (!empty($to)) {
    $totalQuery->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
}
    
    /* =========================
       PAGINATION
       ========================= */

    $paginateOptions = ['order' => ['CashMovements.created' => 'DESC']];

    if (empty($search) && empty($from) && empty($to)) {
        $paginateOptions['limit'] = 5;
    }
    $cashMovements = $this->paginate($query, $paginateOptions);

    // Etat de caisse 

    if (!empty($search) || !empty($search2) || !empty($to) || !empty($from)) {
        $totalAmount = $totalQuery
        ->select([
            'total' => $totalQuery->func()->sum('CashMovements.montant')
        ])
        ->enableHydration(false)
        ->first()['total'] ?? 0;
    } else{
        $CashMovements = $this->fetchTable('CashMovements');

        $subquery = $CashMovements->find()
            ->select([
                'montant' => 'CashMovements.montant'
            ])
            ->where(['user_id' => $userData->id])
            ->order(['created' => 'DESC'])
            ->limit(5);

        $query = $CashMovements->find();
        $totalAmount = $query
            ->select([
                'total' => $query->func()->sum('montant')
            ])
            ->from(['t' => $subquery])
            ->enableHydration(false)
            ->first()['total'] ?? 0;
    }
    /* =========================
       SOLDE CAISSE
       ========================= */

    $today = new \DateTime();
    $todayDate = $today->format('Y-m-d');

    $amount = $this->CashBoxes->find()
        ->where(['responsable_id'=> $userData->id])
        ->first();

    $amountInit = $amount->solde_initial ?? 0;
    $amountActuel = $amount->solde_actuel ?? 0;
    $amountInput = $this->fetchTable('CashMovements')->find()
    ->where(['type'=>'entrée','created'>= $todayDate,'user_id'=>$userData->id])
    ->select(['tot'=>  $totalQuery->func()->sum('CashMovements.montant') ])
     ->enableHydration(false)
    ->first()['tot'] ?? 0;
                                        // debug($amountInput);
                                        // die();
     $amountInout = $this->fetchTable('CashMovements')->find()
    ->where(['type'=>'sortie','created'>= $todayDate,'user_id'=>$userData->id])
    ->select(['tot'=>  $totalQuery->func()->sum('CashMovements.montant') ])
     ->enableHydration(false)
    ->first()['tot'] ?? 0;

    // $amountInput = 9;

    $this->set(compact(
        'responsables',
        'cashBoxes',
        'amountInout',
        'myCollabots',
        'userData',
        'cashMovements',
        'search',
        'from',
        'amountInit',
        'amountInput',
        'amountActuel',
        'to',
        'totalAmount'
    ));
}


    public function index4()
    {
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
        }
        $CashBoxes = $this->fetchTable('CashBoxes');
        // recuperer les caisses que j ai creer et qui appartiennent a mon entreprise
        if ($userData->role == 'admin'|| $userData->role == 'directeur') {
            $query = $CashBoxes->find()->where(['create_uid'=>$this->currentUser->id,'Cashboxes.startup_id'=> $userData->startup_id]);
        }
        else{ 
            $query = $CashBoxes->find()->where(['responsable_id'=> $this->currentUser->id]);
        }
        $CashBoxes = $this->paginate($query);
        $mystartup =  $userData->startup_id;

        $responsables = $accountTable->find('list', keyField: 'id', valueField: 'username')
                                    ->where(['startup_id'=> $mystartup])
                                    // ->contain(['Cashboxes'])
                                    ->toArray();

        $myCollabots = $accountTable->find('list', keyField: 'id', valueField: 'username')
                                    ->where(['startup_id'=> $mystartup])
                                    ->toArray();
        // Requete de recherche                             
        $CashMovements = $this->fetchTable('CashMovements');
        $this->fetchTable('CashBoxes');
        $this->fetchTable('Accounts');

        $mycashbox = $CashBoxes->find()->where(['responsable_id'=> $userData->id])->first();
        if ($mycashbox) {
            $mycashboxId  = $mycashbox->id;
            $mycashbox->notification = 0;
            $this->CashBoxes->save($mycashbox);
        } else{
          $mycashboxId  = 0;
        }
        

    $query = $CashMovements->find()
    // 1. UTILISER CONTAIN() POUR CHARGER LES DONNÉES DANS LES ENTITÉS PHP
    // C'est cette partie qui rendra $movement->inspection->vehicle disponible
    ->contain([
        'CashBoxes',
        'Accounts',
        'Inspections' => ['Vehicles' => ['Customers']]
    ])
    
    // 2. UTILISER leftJoinWith() POUR FORCER LA JOINTURE EXTERNE (LEFT JOIN)
    // Cela garantit que les CashMovements sans Inspection ne sont PAS filtrés
    ->leftJoinWith('Inspections')
    ->leftJoinWith('Inspections.Vehicles')
    ->leftJoinWith('Inspections.Vehicles.Customers')

    // 3. VOTRE FILTRAGE PAR OR
    ->where([
        'OR' => [
            ['CashMovements.create_uid' => $userData->id],
            ['CashMovements.cash_box_id' => $mycashboxId],
            ['CashMovements.sender' => $mycashboxId],
        ]
    ])
    // 4. VOTRE TRI
    ->order(['CashMovements.created' => 'DESC']);

    // debug($query->all()); die();

            $search = $this->request->getQuery('search');
            $search2 = $this->request->getQuery('search2');
            $from = $this->request->getQuery('from');
            $to = $this->request->getQuery('to');

        if (!empty($search)) {
            $query
                ->leftJoinWith('CashBoxes')
                ->leftJoinWith('Accounts')
                ->andWhere([
                    'OR' => [
                        'CashMovements.type LIKE' => "%$search%",
                        'CashBoxes.name LIKE' => "%$search%",
                        'Accounts.username LIKE' => "%$search%",
                    ]
                ]);
        }

        if (!empty($search2)) {
            $query
                ->leftJoinWith('Inspections.Vehicles.Customers')
                ->andWhere([
                    'OR' => [
                        'Vehicles.registration_number LIKE' => "%$search2%",
                        'Customers.name LIKE'               => "%$search2%",
                    ]
            ]);
        }

        if (!empty($from)) {
            $query->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
        }

        if (!empty($to)) {
            $query->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
        }

        $today = new \DateTime();
        $todayDate = $today->format('Y-m-d');
        // --- Options de pagination ---
        $paginateOptions = ['order' => ['CashMovements.created' => 'DESC']];

        // Si pas de filtre, limiter aux 2 dernières opérations
       if (empty($search) && empty($from) && empty($to)) {
            // Apply the limit
            $paginateOptions['limit'] = 5;
            
        }

        // Pagination
        $cashMovements = $this->paginate($query, $paginateOptions);

        $amount = $this->CashBoxes->find()->where(['responsable_id'=> $userData->id])->first();
        $amountInit = $amount->solde_initial ?? 0;
        $amountActuel = $amount->solde_actuel ?? 0;
        $amountInput = $amount->cashinput ?? 0;
        $amountInout = $amount->cashinout ?? 0;
 
    $this->set(compact('responsables','cashBoxes','amountInout','myCollabots','userData','cashMovements', 'search', 'from', 'amountInit','amountInput','amountActuel','to'));
    }



   public function index3()
{
    $user = $this->currentUser;
    $accountTable = $this->fetchTable('Accounts');
    $adminTable = $this->fetchTable('Admins');

    $adminLogin = $adminTable->findById($user->id)->first();

    if ($adminLogin) {
        $accountLogin = $adminTable->findById($user->id)->first();
        $adminLoginId = $accountLogin->id;
        $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
    } else {
        $accountLogin = $accountTable->findById($user->id)->first();
        $acountLoginId = $accountLogin->id;
        $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
    }

    $CashBoxes = $this->fetchTable('CashBoxes');

    if ($userData->role == 'admin'|| $userData->role == 'directeur') {
        $query = $CashBoxes->find()
        ->where([
            'create_uid'=>$this->currentUser->id,
            'Cashboxes.startup_id'=> $userData->startup_id
        ]);
    } else { 
        $query = $CashBoxes->find()
        ->where(['responsable_id'=> $this->currentUser->id]);
    }

    $cashBoxes = $this->paginate($query);
    $mystartup =  $userData->startup_id;

    $responsables = $accountTable->find('list', keyField: 'id', valueField: 'username')
        ->where(['startup_id'=> $mystartup])
        ->toArray();

    $myCollabots = $accountTable->find('list', keyField: 'id', valueField: 'username')
        ->where(['startup_id'=> $mystartup])
        ->toArray();

    $CashMovements = $this->fetchTable('CashMovements');
    $this->fetchTable('Accounts');

    $mycashbox = $this->CashBoxes->find()
        ->where(['responsable_id'=> $userData->id])
        ->first();

    if ($mycashbox) {
        $mycashboxId  = $mycashbox->id;
        $mycashbox->notification = 0;
        $this->CashBoxes->save($mycashbox);
    } else{
        $mycashboxId  = 0;
    }

    $query = $CashMovements->find()
        ->contain([
            'CashBoxes',
            'Accounts',
            'Inspections' => ['Vehicles' => ['Customers']]
        ])
        ->leftJoinWith('Inspections')
        ->leftJoinWith('Inspections.Vehicles')
        ->leftJoinWith('Inspections.Vehicles.Customers')

        ->where([
            'OR' => [
                ['CashMovements.create_uid' => $userData->id],
                ['CashMovements.cash_box_id' => $mycashboxId],
                ['CashMovements.sender' => $mycashboxId],
            ]
        ])
        ->order(['CashMovements.created' => 'DESC']);

    $search = $this->request->getQuery('search');
    $search2 = $this->request->getQuery('search2');
    $from = $this->request->getQuery('from');
    $to = $this->request->getQuery('to');

  
    if (!empty($search)) {
        $query
            ->leftJoinWith('CashBoxes')
            ->leftJoinWith('Accounts')
            ->andWhere([
                'OR' => [
                    'CashMovements.type LIKE' => "%$search%",
                    'CashBoxes.name LIKE' => "%$search%",
                    'Accounts.username LIKE' => "%$search%",
                ]
            ]);
    }

    if (!empty($search2)) {
        $query
            ->leftJoinWith('Inspections.Vehicles.Customers')
            ->andWhere([
                'OR' => [
                    'Vehicles.registration_number LIKE' => "%$search2%",
                    'Customers.name LIKE'               => "%$search2%",
                ]
        ]);
    }

    if (!empty($from)) {
        $query->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
    }

    if (!empty($to)) {
        $query->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
    }
 
/* =========================
   CALCUL DU TOTAL DES MOUVEMENTS FILTRÉS
   ========================= */

$totalQuery = $CashMovements->find();

$totalQuery->where([
    'OR' => [
        ['CashMovements.create_uid' => $userData->id],
        ['CashMovements.cash_box_id' => $mycashboxId],
        ['CashMovements.sender' => $mycashboxId],
    ]
]);

// appliquer les mêmes filtres
if (!empty($search)) {
    $totalQuery
        ->leftJoinWith('CashBoxes')
        ->leftJoinWith('Accounts')
        ->andWhere([
            'OR' => [
                'CashMovements.type LIKE' => "%$search%",
                'CashBoxes.name LIKE' => "%$search%",
                'Accounts.username LIKE' => "%$search%",
            ]
        ]);
}

if (!empty($search2)) {
    $totalQuery
        ->leftJoinWith('Inspections.Vehicles.Customers')
        ->andWhere([
            'OR' => [
                'Vehicles.registration_number LIKE' => "%$search2%",
                'Customers.name LIKE' => "%$search2%",
            ]
        ]);
}

if (!empty($from)) {
    $totalQuery->andWhere(['CashMovements.created >=' => $from . ' 00:00:00']);
}

if (!empty($to)) {
    $totalQuery->andWhere(['CashMovements.created <=' => $to . ' 23:59:59']);
}
    
    /* =========================
       PAGINATION
       ========================= */

    $paginateOptions = ['order' => ['CashMovements.created' => 'DESC']];

    if (empty($search) && empty($from) && empty($to)) {
        $paginateOptions['limit'] = 5;
    }
    $cashMovements = $this->paginate($query, $paginateOptions);

    /* =========================
    ETAT DE CAISSE
    ========================= */

    if (!empty($search) || !empty($search2) || !empty($to) || !empty($from)) {
        $totalAmount = $totalQuery
        ->select([
            'total' => $totalQuery->func()->sum('CashMovements.montant')
        ])
        ->enableHydration(false)
        ->first()['total'] ?? 0;
    } else{
        $CashMovements = $this->fetchTable('CashMovements');

        $subquery = $CashMovements->find()
            ->select([
                'montant' => 'CashMovements.montant'
            ])
            ->where(['user_id' => $userData->id])
            ->order(['created' => 'DESC'])
            ->limit(5);

        $query = $CashMovements->find();
        $totalAmount = $query
            ->select([
                'total' => $query->func()->sum('montant')
            ])
            ->from(['t' => $subquery])
            ->enableHydration(false)
            ->first()['total'] ?? 0;
    }

    
    /* =========================
       SOLDE CAISSE
       ========================= */

    $today = new \DateTime();
    $todayDate = $today->format('Y-m-d');

    $amount = $this->CashBoxes->find()
        ->where(['responsable_id'=> $userData->id])
        ->first();

    $amountInit = $amount->solde_initial ?? 0;
    $amountActuel = $amount->solde_actuel ?? 0;
    $amountInput = $this->fetchTable('CashMovements')->find()
    ->where(['type'=>'entrée','created'>= $todayDate,'user_id'=>$userData->id])
    ->select(['tot'=>  $totalQuery->func()->sum('CashMovements.montant') ])
     ->enableHydration(false)
    ->first()['tot'] ?? 0;
                                        // debug($amountInput);
                                        // die();
     $amountInout = $this->fetchTable('CashMovements')->find()
    ->where(['type'=>'sortie','created'>= $todayDate,'user_id'=>$userData->id])
    ->select(['tot'=>  $totalQuery->func()->sum('CashMovements.montant') ])
     ->enableHydration(false)
    ->first()['tot'] ?? 0;

    // $amountInput = 9;

    $this->set(compact(
        'responsables',
        'cashBoxes',
        'amountInout',
        'myCollabots',
        'userData',
        'cashMovements',
        'search',
        'from',
        'amountInit',
        'amountInput',
        'amountActuel',
        'to',
        'totalAmount'
    ));
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
        $cashBox = $this->CashBoxes->newEmptyEntity();
        $AccountTable = $this->fetchTable('Accounts');
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
        }
        $mystartup =  $userData->startup_id;
        $responsables = $AccountTable->find('list', keyField: 'id', valueField: 'username')
                                    ->where(['startup_id'=> $mystartup])
                                    ->toArray();
    
        if ($this->request->is('post')) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            // debug($this->request->getData());die();
            $cashBox->create_uid = $this->currentUser->id;
            $cashBox->uuid = Text::uuid();
            $cashBox->name = $this->request->getData('name');
            $cashBox->statut = 'ouverte';
            $cashBox->startup_id = $mystartup;
            $cashBox->responsable_id = (int)$this->request->getData('responsable');
              $responsableId = (int)$this->request->getData('responsable');
            $isExistCashbox = $this->CashBoxes->findByResponsableId($responsableId)->first();
            if ($isExistCashbox) {
                  $result = ['status'=>1,  'code'=>'205', 'error'=>0,'msg'=>'Cet utilisateur a déja une caisse '];
                return $this->Json($result);
            }
            // debug($cashBox);die();

           if ($this->CashBoxes->save($cashBox)) {
                $result = ['status'=>1,  'code'=>'200', 'error'=>0,'msg'=>'Caisse créée avec succès !'];
                return $this->Json($result);
            }

            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('cashBox','responsables'));
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
        $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        $this->set(compact('cashBox'));
    }
    
    
    public function outtransact(){
          // Recuperer les données
        $data = $this->request->getData();
        $amount = $data['name'];
        if ($amount == 0) {
            $result = ['status'=>0, 'error'=>4,'msg'=>'Action impossible','code'=>'204'];
            return $this->Json($result);
        }
        
        //       debug($amount);
        // die();
        
        $commit = $data['responsable'];
      
        $user = $this->currentUser;
        $accountTable = $this->fetchTable('Accounts');
        $adminTable = $this->fetchTable('Admins');
        $adminLogin = $adminTable->findById($user->id)->first();
        
        if ($adminLogin) {
            $accountLogin = $adminTable->findById($user->id)->first();
            $adminLoginId = $accountLogin->id;
            $userData = $adminTable->find()->where(['id'=> $adminLoginId])->first();
            
        }else {
            $accountLogin = $accountTable->findById($user->id)->first();
            $acountLoginId = $accountLogin->id;
            $userData = $accountTable->find()->where(['id'=> $acountLoginId])->first();
           
        }
        //   debug($userData);die();
        $mycashBox = $this->fetchTable('CashBoxes')->find()->where(['responsable_id'=> $userData->id])->first();
        //  debug($user);die();
        //  debug($mycashBox);die();
        // if ($mycashBox->solde_actuel < $amount) {
        if ($mycashBox->solde_actuel < $amount) {
            $result = ['status'=>0, 'error'=>4,'message'=>'Le solde de votre caisse est inssufisant','code'=>'205'];
            return $this->Json($result);
        }
        // Creer le mouvement de transfert
        $CashMovTable = $this->fetchTable('CashMovements');
        $cashMov = $CashMovTable->newEmptyEntity();
        $cashMov->cash_box_id =  $mycashBox->id;
        $cashMov->sender =  $mycashBox->id;
        $cashMov->motif_id = 1;
        $cashMov->type =  'Decaissement';
        $cashMov->user_id = $userData->id;
        $cashMov->justificatif = $commit;
        $cashMov->create_uid =  $this->currentUser->id;
        $cashMov->montant =  $amount;
        $cashMov->uuid = Text::uuid();
        if ($CashMovTable->save($cashMov))
             {
             $mycashBox->solde_actuel  -= $amount;
             $mycashBox->cashinout += $amount;
             if ($this->fetchTable('Cashboxes')->save($mycashBox))
            {
                $result = ['status'=>1, 'code'=>200, 'error'=>0,'msg'=>'Montant décaissé avec succès !'];
                return $this->Json($result);
            }
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id Cash Box id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     
     
    public function edit($uuid)
    {
        $this->CashBoxes = $this->fetchTable('CashBoxes');
        $cashBox = $this->CashBoxes->findByUuid($uuid)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            if ($this->CashBoxes->save($cashBox)) {
                $this->Flash->success(__('The cash box has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $users = $this->CashBoxes->Users->find('list',  keyField: 'id', limit: 200)->all();
        //   debug($users);
        //   exit();
        $this->set(compact('cashBox','users'));
    }


    public function transactions($uuid)
    {
        // $this->CashBoxes = $this->fetchTable('CashBoxes');
        $CashMovements = $this->fetchTable('CashMovements');
        $motifTable = $this->fetchTable('Motifs');
        $startupId = 1;
        $amount = $this->request->getData('montant');

        $motifs = $motifTable->find('list', keyField: 'id', valueField: 'content')
                                    ->where(['startup_id'=> $startupId])
                                    ->toArray();
                                    
        // recuperer le dernier mouvement
        $query = $CashMovements->find()
                ->contain(['CashBoxes', 'Users']);
        $cashMovs = $this->paginate($query, [
                        'limit' => 1
                         ]);
        $cashBox = $this->CashBoxes->findByUuid($uuid)->first();
        // recuperer les montants 
        $amountCash =  $cashBox->solde_actuel;
        $amountInit =  $cashBox->solde_initial;
        $amountInput =  $cashBox->cashinput;
        $amountInout =  $cashBox->cashinout;
        if (!$cashBox) {
            $this->Flash->error(__('Action impossible.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashBox = $this->CashBoxes->patchEntity($cashBox, $this->request->getData());
            $typeIndex =  $this->request->getData('type');
            $amount = $this->request->getData('montant');
            $cashMov = $CashMovements->newEmptyEntity();
            $cashMov->montant = $this->request->getData('montant');
            $type = $this->request->getData('type');
            $cashMov->cash_box_id =  $cashBox->id;
            if ($typeIndex == 0) {
                $cashMov->type =  'entrée';
            }else{
                $cashMov->type =  'sortie';
            }
            $cashMov->motif_id = $this->request->getData('motif');
            $cashMov->user_id = 1;
            $cashMov->justificatif =  $this->request->getData('justificatif');
            $cashMov->create_uid =  2;
            $cashMov->uuid = Text::uuid();
            // debug($cashMov);die(); 
            if($CashMovements->save($cashMov)){
                // SOUSTRAIRE SI LE TYPE EST UNE SORTIE
                if($type == 1 ){
                    if( $cashBox->solde_actuel  < $amount){
                        // debug('test'); die();
                        return $this->redirect(['controller' => 'CashBoxes', 'action' => 'transactions', $uuid]);
                    }else{
                        $cashBox->solde_actuel -= $amount;
                        $cashBox->cashinout += $amount;
                    }
                }else{
                // AJOUTER SI LE TYPE EST UNE entrée
                    $cashBox->solde_actuel += $amount;
                    $cashBox->cashinput += $amount;
                }
                if ($this->CashBoxes->save($cashBox)) {
                    $this->Flash->success(__('The cash box has been saved.'));
                    // return $this->redirect(['action' => 'index']);
                    return $this->redirect(['controller' => 'CashBoxes', 'action' => 'transactions', $uuid]);
                }
                $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('The cash box could not be saved. Please, try again.'));
        }
        $this->set(compact('motifs','cashBox','cashMovs','amountInit','amountInput','amountInout','amountCash'));
    }
    
    

    // Methode de transfert d'une caisse vers une autre
    public function shareCashBox(){
        // Recuperer les données
        $data = $this->request->getData();
        $receiver = $data['receiver'];
        $uuid = $data['cashbox_uuid'];
        $commit = $data['commit'];
        $usersId = $this->currentUser->id;
        $receivercashBox = $this->CashBoxes->find()->where(['responsable_id'=> $receiver])->first();
        // debug($receivercashBox);exit();
        if (is_null($receivercashBox)) {
              $result = ['status'=>0, 'error'=>4,'message'=>'Votre collabot n\'a pas de caisse','code'=>'200'];
            return $this->Json($result);
        }
        // debug($receivercashBox);exit();
        $mycashBox = $this->fetchTable('Cashboxes')->find()->where(['uuid'=>  $uuid])->first();
        
        
        
        // Valeur de caisse volatile temporaire
        
        // $CashMovements = $this->fetchTable('CashMovements');
        
        
        // $query = $CashMovements->find();
    
        // $amountInput = $query
        // ->where([
        //     'type' => 'entrée',
        //     'created >=' => $todayDate,
        //     'user_id' => $userData->id
        // ])
        // ->select([
        //     'tot' => $query->func()->sum('CashMovements.montant')
        // ])
        // ->enableHydration(false)
        // ->first()['tot'] ?? 0;
        
        // $query = $CashMovements->find();
        // $amountShare = $query
        // ->where([
        //     'type' => 'Transfert',
        //     'created >=' => $todayDate,
        //     'user_id' => $userData->id
        // ])
        // ->select([
        //     'tot' => $query->func()->sum('CashMovements.montant')
        // ])
        // ->enableHydration(false)
        // ->first()['tot'] ?? 0;
        
        // $query = $CashMovements->find();
        // $amountInout = $query
        // ->where([
        //     'type' => 'Decaissement',
        //     'created >=' => $todayDate,
        //     'user_id' => $userData->id
        // ])
        // ->select([
        //     'tot' => $query->func()->sum('CashMovements.montant')
        // ])
        // ->enableHydration(false)
        // ->first()['tot'] ?? 0;
        
        // $amountInoutSum = $amountInout + $amountShare ?? 0;
        
        // $amountActuel = $amountInput - $amountInoutSum;
        
        
        if ($mycashBox->solde_actuel < $data['amount']) {
        // if ($amountActuel < $data['amount']) {
            $result = ['status'=>0, 'error'=>4,'message'=>'Le solde de votre caisse est inssufisant','code'=>'200'];
            return $this->Json($result);
        }
        // Creer le mouvement de transfert
        $CashMovTable = $this->fetchTable('CashMovements');
        $cashMov = $CashMovTable->newEmptyEntity();
        $cashMov->cash_box_id =  $receivercashBox->id;
        $cashMov->sender =  $mycashBox->id;
        $cashMov->motif_id = 1;
        $cashMov->type =  'Transfert';
        $cashMov->user_id = $usersId;
        $cashMov->justificatif = $commit;
        $cashMov->create_uid =  $this->currentUser->id;
        $cashMov->montant =  $data['amount'];
        $cashMov->uuid = Text::uuid();
        // debug($cashMov);die();
        if ($CashMovTable->save($cashMov)) {
             $mycashBox->solde_actuel  -= $data['amount'];
             $mycashBox->cashinout += $data['amount'];
             
            //  Incrementation dfe la notification pourdes raisons d erreur la valeur de notification est stockée dans create_uid
            
             $receivercashBox->notification += 1;
             $receivercashBox->solde_actuel += $data['amount'];
             $receivercashBox->cashinput += $data['amount'];
            // debug($receivercashBox);die();
             if ($this->fetchTable('Cashboxes')->save($receivercashBox) && $this->fetchTable('Cashboxes')->save($mycashBox)) {
                // debug($mycashBox);exit();
                $result = ['status'=>1, 'error'=>0,'message'=>'Montant transferé avec succès !'];
                return $this->Json($result);
             }
        }
    }
    

    public function close($uuid) {
        $cashBox = $this->fetchTable('Cashboxes')->findByUuid($uuid)->first();
        // debug($cashBox);die();
        if (empty($cashBox)) {
          return $this->redirect(['action' => 'index']);
        }
        $cashBox->statut = 'close';
        if($this->fetchTable('Cashboxes')->save($cashBox)){
          return $this->redirect(['action' => 'index']);
        }
         return $this->redirect(['action' => 'index']);
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
