<div class="main-container" style="padding-top: 80px;">

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Liste des relances</h3>
    </div>
    <div class="card-body">
        <!-- Conteneur scrollable -->
        <div class="table-container" style="overflow-x:auto; border-radius:10px; background:#fff;">
            <table class="data-table" style="width:100%; min-width:800px; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Numéro</th>
                        <th>Date d'envoi</th>
                        <th>Statut</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; foreach ($messages as $message): ?>
                    <?php 
                        $statusClass = $message->status == 'Envoyé' ? 'status-open' : 'status-close'; 
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= h($message->customer->name) ?></td>
                        <td><?= h($message->receiver) ?></td>
                        <td><?= h($message->sent_date->nice()) ?></td>
                        <td><span class="<?= $statusClass ?>"><?= h($message->status) ?></span></td>
                       
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- Styles complémentaires pour rester cohérent avec la table des caisses -->
<style>
    .content {
    padding-top: 80px; /* espace suffisant pour le header fixe */
}

.data-table th {
    background-color: #f9fafb;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 12px 16px;
    text-align: left;
}

.data-table td {
    font-size: 0.875rem;
    color: #1f2937;
    padding: 12px 16px;
    white-space: nowrap;
}

.data-table tbody tr:hover {
    background-color: #f3f4f6;
}

.status-open {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    background-color: #d1fae5;
    color: #059669;
}

.status-close {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    background-color: #fee2e2;
    color: #dc2626;
}

.actions-cell .btn {
    margin-right: 0.5rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.actions-cell .transfer-btn {
    border-color: #4f46e5;
    color: #4f46e5;
    background-color: #eef2ff;
}

.actions-cell .open-btn {
    border-color: #10b981;
    color: #10b981;
    background-color: #d1fae5;
}
</style>
