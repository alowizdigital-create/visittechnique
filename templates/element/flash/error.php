<?php if (!empty($message)): ?>
<style>
/* ===== STYLE DU MESSAGE FLASH ===== */
.flash-alert {
    position: fixed;
    top: -120px; /* point de départ hors écran */
    left: 50%;
    transform: translateX(-50%);
    z-index: 1050;
    width: 90%;
    max-width: 500px;
    padding: 18px 22px 18px 55px;
    border-radius: 10px;
    background-color: #fdecea;
    color: #a94442;
    border: 1px solid #f5c6cb;
    font-family: "Inter", sans-serif;
    font-size: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    overflow: hidden;
    animation: slideDownCenter 0.6s ease forwards;
}

/* Icône d’alerte */
.flash-alert i {
    margin-right: 12px;
    font-size: 22px;
    color: #dc3545;
    flex-shrink: 0;
    animation: pulseIcon 1.5s infinite;
}

/* Bouton de fermeture */
.flash-alert .close-btn {
    background: none;
    border: none;
    font-size: 20px;
    color: #842029;
    cursor: pointer;
    opacity: 0.7;
    margin-left: auto;
    transition: opacity 0.2s;
}

.flash-alert .close-btn:hover {
    opacity: 1;
}

/* Animation d’apparition (du haut vers le centre) */
@keyframes slideDownCenter {
    from {
        opacity: 0;
        transform: translate(-50%, -100%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, 0);
        top: 40px;
    }
}

/* Animation de disparition (vers le haut) */
@keyframes slideUpCenter {
    from {
        opacity: 1;
        transform: translate(-50%, 0);
    }
    to {
        opacity: 0;
        transform: translate(-50%, -100%);
    }
}

/* Icône légèrement animée */
@keyframes pulseIcon {
    0% { transform: scale(1); }
    50% { transform: scale(1.15); }
    100% { transform: scale(1); }
}
</style>

<div class="flash-alert" id="flash-message">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <?= h($message) ?>
    <button class="close-btn" onclick="closeFlash()">×</button>
</div>

<script>
function closeFlash() {
    const msg = document.getElementById('flash-message');
    msg.style.animation = 'slideUpCenter 0.5s forwards';
    setTimeout(() => msg.remove(), 500);
}

// Fermeture automatique après 4 secondes
setTimeout(() => {
    if (document.getElementById('flash-message')) closeFlash();
}, 4000);
</script>
<?php endif; ?>
