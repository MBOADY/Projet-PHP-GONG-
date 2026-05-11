<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 

// Sécurité : obliger la connexion
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="columns is-centered">
    <div class="column is-8">
        <div class="box mt-4" style="height: 600px; display: flex; flex-direction: column; border-top: 4px solid #3298dc;">
            <div class="is-flex is-align-items-center mb-4">
                <span class="icon is-large has-text-info mr-2"><i class="fas fa-robot fa-2x"></i></span>
                <div>
                    <h1 class="title is-4 mb-0">Coach GONG (IA)</h1>
                    <p class="is-size-7 has-text-grey">Pose tes questions techniques ou de préparation physique.</p>
                </div>
            </div>
            
            <div id="chat-box" class="p-4 mb-4" style="flex-grow: 1; overflow-y: auto; background-color: #141414; border-radius: 10px; border: 1px solid #2b2b2b;">
                <div class="notification is-info is-light p-3" style="max-width: 80%;">
                    Salut <?= htmlspecialchars($_SESSION['prenom']) ?> ! Je suis ton assistant virtuel alimenté par Google Gemini. Comment puis-je t'aider pour ton prochain entraînement ?
                </div>
            </div>

            <div class="field has-addons">
                <div class="control is-expanded">
                    <input id="chat-input" class="input is-medium" type="text" placeholder="Ex: Comment sortir d'un étranglement en croix ?">
                </div>
                <div class="control">
                    <button onclick="askAI()" id="btn-send" class="button is-info is-medium">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function askAI() {
    const input = document.getElementById('chat-input');
    const box = document.getElementById('chat-box');
    const btn = document.getElementById('btn-send');
    const message = input.value.trim();
    
    if(!message) return;

    // Afficher le message de l'utilisateur
    box.innerHTML += `
        <div class="is-flex is-justify-content-flex-end mb-3">
            <div class="notification is-danger p-3" style="max-width: 80%;">${message}</div>
        </div>`;
    
    input.value = "";
    btn.classList.add('is-loading'); // Petit effet de chargement
    box.scrollTop = box.scrollHeight;

    try {
        // C'est ici qu'on appelle ton fichier caché dans le dossier api !
        const response = await fetch('api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: message })
        });
        
        const data = await response.json();
        
        // Afficher la réponse de l'IA
        if(data.reply) {
            box.innerHTML += `
            <div class="is-flex is-justify-content-flex-start mb-3">
                <div class="notification is-dark p-3" style="max-width: 80%; border-left: 4px solid #3298dc;">${data.reply}</div>
            </div>`;
        } else {
            box.innerHTML += `<p class="has-text-danger">Erreur: ${data.error}</p>`;
        }
    } catch (e) {
        box.innerHTML += `<p class="has-text-danger">Erreur de connexion au serveur.</p>`;
    }

    btn.classList.remove('is-loading');
    box.scrollTop = box.scrollHeight;
}

// Permettre d'envoyer avec la touche "Entrée"
document.getElementById('chat-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') askAI();
});
</script>

<?php include 'includes/footer.php'; ?>