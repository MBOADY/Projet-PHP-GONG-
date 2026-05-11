<?php
include 'includes/header.php';
?>

<div class="columns is-centered">
    <div class="column is-10">
        
        <div class="has-text-centered mb-6 mt-4">
            <span class="icon has-text-danger is-large"><i class="fas fa-graduation-cap fa-2x"></i></span>
            <h1 class="title is-2 mt-2">Tutos & FAQ</h1>
            <p class="subtitle is-5 has-text-grey">Apprenez les bases et trouvez les réponses à vos questions.</p>
        </div>

        <h2 class="title is-4 mt-6 mb-4"><i class="fas fa-video has-text-danger mr-2"></i> Tutoriels Vidéos</h2>
        <div class="columns is-multiline">
            
            <div class="column is-4">
                <div class="box has-background-dark h-100">
                    <h3 class="title is-5"><i class="fas fa-hand-fist has-text-danger mr-2"></i>Bases de la Boxe</h3>
                    <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                        <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                                src="https://www.youtube.com/embed/HnzzrA_Fh7s" 
                                title="Les bases de la boxe anglaise" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    <p class="mt-3 is-size-7 has-text-grey">Les mouvements essentiels garde, directs et crochets.</p>
                </div>
            </div>

            <div class="column is-4">
                <div class="box has-background-dark h-100">
                    <h3 class="title is-5"><i class="fas fa-bolt has-text-danger mr-2"></i>Initiation au MMA</h3>
                    <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                        <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                                src="https://www.youtube.com/embed/hGbLsUxIM1A" 
                                title="YouTube video player" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    <p class="mt-3 is-size-7 has-text-grey">Travail au sol, transitions et techniques de ground and pound.</p>
                </div>
            </div>

            <div class="column is-4">
                <div class="box has-background-dark h-100" style="border: 1px solid #ff3860;">
                    <h3 class="title is-5"><i class="fas fa-shield-halved has-text-danger mr-2"></i>Règles du Sparring</h3>
                    <div class="content is-small">
                        <p><strong>Règle n°1 : Le respect.</strong> Le but n'est pas le KO, mais l'apprentissage mutuel.</p>
                        <ul>
                            <li>Portez <strong>toujours</strong> protège-dents et coquille.</li>
                            <li>Ajustez la puissance selon l'accord (Touche, Light, Hard).</li>
                            <li>Laissez l'ego au vestiaire.</li>
                            <li>Communiquez : si vous êtes fatigué, dites "Stop" ou tapez.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr style="background-color: #333; margin: 3rem 0;">

        <h2 class="title is-4 mb-5"><i class="fas fa-question-circle has-text-danger mr-2"></i> Foire Aux Questions (FAQ)</h2>
        
        <style>
            details { margin-bottom: 1rem; border: 1px solid #333; border-radius: 6px; overflow: hidden; }
            summary { padding: 1rem; background-color: #2c2c2c; cursor: pointer; font-weight: bold; outline: none; }
            summary:hover { background-color: #3a3a3a; }
            details[open] summary { background-color: #ff3860; color: white; }
            .faq-content { padding: 1rem; background-color: #1a1a1a; }
        </style>

        <div class="columns">
            <div class="column is-8 is-offset-2">
                
                <details>
                    <summary><i class="fas fa-chevron-right mr-2 is-size-7"></i> Comment proposer un sparring à un membre ?</summary>
                    <div class="faq-content">
                        <p>Sur la page d'accueil, utilisez la barre de recherche pour trouver des membres selon leur sport ou leur ville. Cliquez ensuite sur le bouton rouge <strong>"Proposer Sparring"</strong>. L'utilisateur recevra une notification et pourra accepter ou refuser votre demande.</p>
                    </div>
                </details>

                <details>
                    <summary><i class="fas fa-chevron-right mr-2 is-size-7"></i> Je suis grand débutant, puis-je utiliser l'application ?</summary>
                    <div class="faq-content">
                        <p>Absolument ! L'application est conçue pour tous les niveaux. Lors de la création de votre profil, indiquez votre niveau "Débutant". Pensez toujours à préciser "Light sparring" (à la touche) dans la messagerie avant de rencontrer votre partenaire.</p>
                    </div>
                </details>

                <details>
                    <summary><i class="fas fa-chevron-right mr-2 is-size-7"></i> L'application est-elle gratuite ?</summary>
                    <div class="faq-content">
                        <p>Oui, <strong>GONG</strong> est une plateforme 100% gratuite. Notre but est de faciliter la mise en relation entre passionnés de sports de combat, sans aucune barrière financière.</p>
                    </div>
                </details>

                <details>
                    <summary><i class="fas fa-chevron-right mr-2 is-size-7"></i> Que faire si un partenaire a un comportement dangereux ?</summary>
                    <div class="faq-content">
                        <p>La sécurité est notre priorité absolue. Si un membre ne respecte pas les règles établies lors de votre discussion (appuie trop ses coups, comportement agressif), arrêtez immédiatement le sparring.</p>
                    </div>
                </details>

                <details>
                    <summary><i class="fas fa-chevron-right mr-2 is-size-7"></i> Comment trouver mon club sur la carte ?</summary>
                    <div class="faq-content">
                        <p>Allez sur l'onglet <strong>Carte des Clubs</strong>. La carte est interactive : vous pouvez zoomer sur votre ville. Si votre club n'y figure pas encore, parlez-en à votre coach pour qu'il nous contacte et demande son référencement !</p>
                    </div>
                </details>

                <div class="notification is-dark has-text-centered mt-5" style="border: 1px solid #333;">
                <i class="fas fa-robot has-text-danger mr-2"></i> Pour plus de questions, n'hésitez pas à interroger notre <a href="ia.php" class="has-text-danger"><strong>Coach IA</strong></a>, il essaiera de vous répondre !
                </div>

            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>