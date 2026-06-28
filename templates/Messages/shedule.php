<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Type SMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ==================== Styles Généraux ==================== */
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding-top: 50px;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Bouton "Select type" */
        .type-selector-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: #3c7d9e;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .type-selector-btn i {
            margin-right: 8px;
        }

        .separator {
            margin: 20px 0 30px 0;
            border: none;
            border-top: 3px dashed #dee2e6;
        }

        /* ==================== Cartes d’option ==================== */
        .option-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .option-info {
            display: flex;
            align-items: center;
        }

        .option-icon {
            font-size: 24px;
            color: #3c7d9e;
            margin-right: 15px;
            min-width: 30px;
            text-align: center;
        }

        .option-title {
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 2px;
        }

        .option-description {
            font-size: 14px;
            color: #6c757d;
        }

        .send-btn {
            padding: 8px 15px;
            background-color: #235467;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .send-btn:hover {
            background-color: #0056b3;
        }

        /* ==================== Modale ==================== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 500;
            color: #3c7d9e;
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #333;
        }

        /* ==================== Formulaire ==================== */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .recipient-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: center;
        }

        .send-modal-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            background-image: linear-gradient(to right, #4a7aa5 0%, #76a0c5 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .send-modal-btn i {
            margin-right: 10px;
        }

        /* Focus visible pour accessibilité */
        button:focus, .form-control:focus {
            outline: 2px solid #3c7d9e;
            outline-offset: 2px;
        }

        /* ==================== Footer ==================== */
        footer.main-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background: #f8f9fa;
            padding: 10px 20px;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }
    </style>
</head>

<body>
<div class="container">
    <button class="type-selector-btn">
        <i class="fas fa-users"></i> Sélectionner le type
    </button>

    <hr class="separator">

    <div class="option-card">
        <div class="option-info">
            <div class="option-icon"><i class="fas fa-comment-dots"></i></div>
            <div>
                <div class="option-title">SMS Direct</div>
                <div class="option-description">Envoyer un SMS direct à des numéros individuels sur n'importe quel réseau mobile</div>
            </div>
        </div>
        <button class="send-btn" data-modal-target="directSmsModal">Envoyer</button>
    </div>

    <div class="option-card">
        <div class="option-info">
            <div class="option-icon"><i class="fas fa-user-friends"></i></div>
            <div>
                <div class="option-title">Campagnes</div>
                <div class="option-description">Envoyer des messages à plusieurs numéros déjà enregistrés</div>
            </div>
        </div>
        <button class="send-btn" data-modal-target="campaignSmsModal">Envoyer</button>
    </div>
</div>


<div id="directSmsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">Envoyer un SMS Direct</span>
            <span class="close-btn" data-close-modal>&times;</span>
        </div>

        <?= $this->Form->create(NULL, ['id' => 'outcashTransaction']) ?>
            <div class="form-group">
                <?= $this->Form->control('numero', [
                    'label' => 'Numéro de téléphone',
                    'class' => 'form-control',
                    'placeholder' => '656262480,678890945,653321288...',
                    'type' => 'textarea',
                    'id' => 'numero',
                    'required' => true
                ]) ?>
                <div class="recipient-info">
                    <span>Séparer les numéros avec des virgules | <span id="numero-count-direct">0</span> numero(s) </span>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->control('message', [
                    'label' => 'Message',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'id' => 'message',
                    'required' => true
                ]) ?>
                <div class="recipient-info">
                    <span id="caracteres-restants-direct">160</span> caractères restants | <span id="message-count-direct">1</span> message
                </div>
            </div>

            <div class="modal-footer">
                <?= $this->Form->button(__('Transférer'), ['class' => 'send-modal-btn']) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>


<div id="campaignSmsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">Envoyer une Campagne SMS</span>
            <span class="close-btn" data-close-modal>&times;</span>
        </div>
        <form id="campaignForm">
            <div class="form-group">
                <!-- <label for="groupe">Sélectionner un groupe :</label> -->
                 <?= $this->Form->control('message', [
                    'label' => 'Groupes',
                    'class' => 'form-control',
                    'options'=> $groupes,
                    'id' => 'groupe-select',
                    'required' => true
                ]) ?>
              
            </div>
            <div class="form-group">
                <label for="messageCampagne">Message</label>
                <textarea id="messageCampagne" class="form-control" required></textarea>
                <div class="recipient-info">
                    <span id="caracteres-restants-campagne">160</span> caractères restants | <span id="message-count-campagne">1</span> message
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="send-modal-btn"><i class="fas fa-paper-plane"></i> Envoyer la Campagne</button>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Cibler le formulaire généré par $this->Form->create($vehicle)
        // Comme il n'a pas d'ID, on utilise le sélecteur 'form' (en supposant qu'il est le seul)
        $('form').on('submit', function() {
            // Cibler le bouton de soumission par sa classe ou son type
            const submitButton = $(this).find('.btn-primary'); // Cibler spécifiquement le bouton bleu

            // Vérification pour éviter les erreurs
            if (submitButton.length) {
                // 1. Désactiver le bouton pour empêcher les clics multiples
                submitButton.prop('disabled', true);
                
                // 2. Changer le texte et ajouter une icône de chargement (spinner)
                submitButton.html('<i class="fas fa-spinner fa-spin"></i> Sauvegarde en cours...');
                
                // Le formulaire va continuer sa soumission vers le contrôleur.
            }
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modals = document.querySelectorAll('.modal');
    const openButtons = document.querySelectorAll('.send-btn');
    const closeButtons = document.querySelectorAll('[data-close-modal]');

    // Ouvrir modale
    openButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const targetId = e.currentTarget.getAttribute('data-modal-target');
            document.getElementById(targetId).style.display = 'flex';
        });
    });

    // Fermer modale
    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            modals.forEach(modal => modal.style.display = 'none');
        });
    });

    // Clic extérieur
    window.addEventListener('click', (event) => {
        modals.forEach(modal => {
            if (event.target === modal) modal.style.display = 'none';
        });
    });

    // ESC pour fermer
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            modals.forEach(modal => modal.style.display = 'none');
        }
    });

    // --- Script de Compteurs Ajouté ---

    // 1. Compteur de Numéros (SMS Direct)
    const numeroInput = document.getElementById('numero');
    const numeroCountSpan = document.getElementById('numero-count-direct');

    function getValidNumbers(value) {
        // Sépare par les virgules et filtre les chaînes vides ou contenant uniquement des espaces
        return value.split(',')
                    .map(n => n.trim())
                    .filter(n => n.length > 0);
    }

    function updateNumeroCount() {
        const value = numeroInput.value.trim();
        const numbers = getValidNumbers(value);
        numeroCountSpan.textContent = numbers.length;
    }

    if (numeroInput && numeroCountSpan) {
        numeroInput.addEventListener('input', updateNumeroCount);
        updateNumeroCount(); // Initialiser le compteur au chargement
    }

    // 2. Compteurs de Messages et Caractères (SMS Direct et Campagne)
    const directMessageInput = document.getElementById('message');
    const directCharCountSpan = document.getElementById('caracteres-restants-direct');
    const directMsgCountSpan = document.getElementById('message-count-direct');

    const campaignMessageInput = document.getElementById('messageCampagne');
    const campaignCharCountSpan = document.getElementById('caracteres-restants-campagne');
    const campaignMsgCountSpan = document.getElementById('message-count-campagne');
    
    // Longueur maximale pour 1 SMS (standard GSM 7-bit)
    const MAX_SMS_LENGTH = 160; 
    // Longueur pour les SMS concaténés (multiples parties)
    const CONCATENATED_LENGTH = 153; 

    function updateMessageCounters(input, charSpan, msgSpan) {
        const charCount = input.value.length;
        let smsCount;
        let charsLeft;

        if (charCount <= MAX_SMS_LENGTH) {
            smsCount = 1;
            charsLeft = MAX_SMS_LENGTH - charCount;
        } else {
            // Calcul pour les SMS concaténés
            // 153 est la taille effective par partie (160 - 7 octets d'en-tête UDH)
            smsCount = Math.ceil(charCount / CONCATENATED_LENGTH); 
            // Caractères restants dans le dernier message partiel
            const remaining = charCount % CONCATENATED_LENGTH;
            charsLeft = remaining === 0 ? CONCATENATED_LENGTH : CONCATENATED_LENGTH - remaining;
        }

        charSpan.textContent = charsLeft;
        msgSpan.textContent = smsCount;
    }

    if (directMessageInput && directCharCountSpan && directMsgCountSpan) {
        directMessageInput.addEventListener('input', () => {
            updateMessageCounters(directMessageInput, directCharCountSpan, directMsgCountSpan);
        });
        updateMessageCounters(directMessageInput, directCharCountSpan, directMsgCountSpan); // Initialiser
    }

    if (campaignMessageInput && campaignCharCountSpan && campaignMsgCountSpan) {
        campaignMessageInput.addEventListener('input', () => {
            updateMessageCounters(campaignMessageInput, campaignCharCountSpan, campaignMsgCountSpan);
        });
        updateMessageCounters(campaignMessageInput, campaignCharCountSpan, campaignMsgCountSpan); // Initialiser
    }
});

// ==================== Soumission AJAX ====================
$('#outcashTransaction').submit(function(e) {
    e.preventDefault();

    // Récupérer et nettoyer la liste des numéros
    const rawNumbers = $('#numero').val();
    const numbersArray = rawNumbers.split(',')
                                    .map(n => n.trim())
                                    .filter(n => n.length > 0);
    
    // Créer une chaîne de numéros propre séparée par des virgules pour l'envoi
    const cleanNumbersString = numbersArray.join(',');
    // alert(directMsgCountSpan);

    const data = {
        // Envoi de la chaîne de numéros nettoyée
        numero: cleanNumbersString, 
        message: $('#message').val(),
        // countMessage: directMsgCountSpan,
        _csrfToken: $('input[name="_csrfToken"]').val()
    };
    
    // Vérification rapide pour s'assurer qu'il y a des numéros
    if (numbersArray.length === 0) {
        toastr.error('Veuillez entrer au moins un numéro de téléphone valide.');
        return; 
    }

    $.ajax({
        url: '/send-sms',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(result) {
            if (result.code == 200) {
                toastr.success(result.msg || ' Message envoyé avec succès');
                setTimeout(() => window.location = '/messages', 3000);
            } else {
               toastr.error(result.msg || ' Échec de l’envoi du message');
            }
        },
        error: function() {
            toastr.error(' Erreur serveur — veuillez réessayer.');
        }
    });
});

// ... (Code existant du DOMContentLoaded et du submit #outcashTransaction)

// ==================== Soumission AJAX CAMPAGNE ====================
$('#campaignForm').submit(function(e) {
    e.preventDefault();

    // Récupérer la valeur du groupe sélectionné
    // Note: L'ID 'message' semble incorrect pour le champ groupe, 
    // mais nous utilisons l'ID de contrôle CakePHP si disponible, sinon on se base sur le nom.
    // Dans votre HTML, le champ groupe généré par CakePHP aura probablement l'ID `message` (selon votre code)
    // ou un ID basé sur son nom de champ réel (ex: `groupe_id` si c'est ce que vous passez).
    // Je vais supposer l'ID du contrôle généré :
    const groupeId = $('#groupe-select').val(); 
    
    // Récupérer le message de la campagne
    const campaignMessage = $('#messageCampagne').val();

    const data = {
        groupe_id: groupeId, // L'ID du groupe sélectionné
        message: campaignMessage,
        _csrfToken: $('input[name="_csrfToken"]').val()
    };

    console.log(data);
    
    // Vérification rapide
    if (!groupeId || !campaignMessage.trim()) {
        toastr.error('Veuillez sélectionner un groupe et entrer un message.');
        return; 
    }

    $.ajax({
        url: '/send-campaign-sms', // Nouvelle route dédiée aux campagnes
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(result) {
            if (result.code == 200) {
                toastr.success(result.msg || ' Campagne SMS lancée avec succès');
                // Fermer la modale après l'envoi
                $('#campaignSmsModal').css('display', 'none'); 
            } else {
               toastr.error(result.msg || ' Échec du lancement de la campagne');
            }
        },
        error: function() {
            toastr.error(' Erreur serveur — veuillez réessayer.');
        }
    });
});
</script>

<footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
  <div class="float-right d-none d-sm-inline">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2025 <a href="#" style="color:var(--aa-primary);border-radius:8px;">AdvanceApp</a></strong> Tous droits réservés.

  <a href="https://wa.me/237656262480" style="color:var(--aa-primary);border-radius:8px;" target="_bank" style="margin-left: 20px;"> Contactez-nous sur Whatsapp</a>
</footer>

</body>
</html>

