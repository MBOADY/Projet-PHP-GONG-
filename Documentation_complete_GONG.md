# Documentation complète du projet GONG

Projet de fin d'études - BTS SIO SLAM  
Plateforme web de matchmaking pour sports de combat  

---

## Sommaire

1. [Analyse](#1-analyse)
   - [1.1 Expression de besoin contextualisée](#11-expression-de-besoin-contextualisée)
   - [1.2 User stories et backlog produit](#12-user-stories-et-backlog-produit)
   - [1.3 Calendrier de réalisation selon la méthode Agile](#13-calendrier-de-réalisation-selon-la-méthode-agile)
   - [1.4 Diagramme UML des cas d'utilisation](#14-diagramme-uml-des-cas-dutilisation)
2. [Conception](#2-conception)
   - [2.1 Schéma d'architecture logicielle et technique](#21-schéma-darchitecture-logicielle-et-technique)
   - [2.2 Diagramme UML de classes](#22-diagramme-uml-de-classes)
   - [2.3 Modèle conceptuel de données](#23-modèle-conceptuel-de-données)
   - [2.4 Description des IHM, écrans et navigation](#24-description-des-ihm-écrans-et-navigation)
3. [Réalisation](#3-réalisation)
   - [3.1 Présentation du code source](#31-présentation-du-code-source)
   - [3.2 Tests unitaires et vérifications techniques](#32-tests-unitaires-et-vérifications-techniques)
   - [3.3 Fichier d'exportation de la base de données](#33-fichier-dexportation-de-la-base-de-données)
4. [Documentation logicielle](#4-documentation-logicielle)
   - [4.1 Cahier de tests fonctionnels](#41-cahier-de-tests-fonctionnels)
   - [4.2 Manuel administrateur](#42-manuel-administrateur)
   - [4.3 Manuel utilisateur](#43-manuel-utilisateur)
5. [Éléments à compléter avant le rendu](#5-éléments-à-compléter-avant-le-rendu)

---

## Introduction générale

Le projet **GONG** est une application web communautaire pensée et développée en partenariat avec le *Boxing Club Niortais*. Elle permet à des pratiquants de sports de combat (boxe, MMA, lutte, etc.) de se créer un profil, de trouver des partenaires d'entraînement (sparring) compatibles et de communiquer via une messagerie intégrée.

L'application répond au besoin récurrent dans le milieu des arts martiaux : la difficulté de trouver des partenaires de poids, de niveau et de discipline équivalents en dehors des créneaux officiels des clubs, tout en garantissant la sécurité des rencontres.

Le projet a été réalisé en **PHP 8.4 orienté objet (POO)** pour la logique métier, **MySQL** pour la persistance des données, et le framework **Bulma CSS** pour l'interface graphique (Responsive Design & Dark Mode). Il constitue la situation professionnelle développement Web de l'option **BTS SIO SLAM**.

---

# 1. Analyse

## 1.1 Expression de besoin contextualisée

### Contexte du projet
Dans les clubs de sports de combat locaux, les pratiquants s'entraînent souvent avec les mêmes personnes. Lorsqu'ils souhaitent faire des "sparrings" supplémentaires le week-end, il est complexe de trouver un adversaire inconnu pour s'évaluer. Les différences de poids ou d'expérience rendent la mise en relation risquée. L'application **GONG** propose une plateforme centralisée pour mettre en relation ces passionnés grâce à un algorithme de matchmaking basé sur des critères morphologiques et géographiques.

### Utilisateurs concernés
- **Visiteur** : Utilisateur non connecté découvrant l'accueil.
- **Membre (Boxeur)** : Pratiquant inscrit cherchant un partenaire via le matchmaking.
- **Administrateur** : Modérateur gérant la sécurité (bannissements) et la carte des clubs.

## 1.2 User stories et backlog produit

| ID | User story | Priorité | Statut |
|---|---|---:|---|
| US01 | En tant que visiteur, je veux m'inscrire et me connecter. | Haute | Réalisé |
| US02 | En tant que membre, je veux une suggestion de profils (+/- 5kg, même ville). | Haute | Réalisé |
| US03 | En tant que membre, je veux rechercher un partenaire par filtres. | Haute | Réalisé |
| US04 | En tant que membre, je veux envoyer une proposition de sparring. | Haute | Réalisé |
| US05 | En tant que système, je veux limiter à 2 les demandes envers la même personne. | Haute | Réalisé |
| US06 | En tant que membre, je veux discuter via une messagerie interne. | Moyenne | Réalisé |
| US07 | En tant qu'admin, je veux bannir un membre dangereux. | Haute | Réalisé |
| US08 | En tant qu'admin, je veux ajouter un club sur la carte interactive. | Haute | Réalisé |

## 1.3 Calendrier de réalisation selon la méthode Agile
- **Sprint 1 :** Modélisation des données (MCD/MLD) et configuration de la BDD.
- **Sprint 2 :** Authentification POO et création des profils sécurisés.
- **Sprint 3 :** Algorithme de matchmaking et logique de proposition de sparring.
- **Sprint 4 :** Messagerie, intégration de la carte interactive et panel Admin.

## 1.4 Diagramme UML des cas d'utilisation
*(Insérer ici l'image de votre diagramme de cas d'utilisation UML)*

---

# 2. Conception

## 2.1 Schéma d'architecture logicielle et technique
Architecture **Client-Serveur** :
- **Serveur :** Apache (Laragon)
- **Langage Backend :** PHP 8.4 (Programmation Orientée Objet)
- **Base de Données :** MySQL / MariaDB (accès via PDO)
- **Frontend :** HTML5, CSS3, Bulma CSS, FontAwesome 6

## 2.2 Diagramme UML de classes
*(Insérer ici l'image de votre diagramme de classes UML)*

## 2.3 Modèle conceptuel de données
**MLD proposé :**
- **UTILISATEUR** (<u>id_utilisateur</u>, nom, prenom, email, mot_de_passe, ville, poids, taille, sport_principal, role, date_inscription)
- **CLUB** (<u>id_club</u>, nom, ville, latitude, longitude, sports_proposes)
- **SESSION_SPARRING** (<u>id_session</u>, #id_demandeur, #id_partenaire, statut, date_creation)
- **MESSAGE** (<u>id_message</u>, #id_expediteur, #id_destinataire, contenu, date_envoi)

*(Insérer ici l'image de votre MCD Merise)*

## 2.4 Description des IHM, écrans et navigation
- **Accueil :** Dashboard central avec barre de recherche et grille des profils suggérés.
- **Espace Admin :** Formulaire d'ajout de clubs et tableau de gestion des membres.
- **Navigation :** Mobile-first, orientée autour d'une barre de menu persistante.

---

# 3. Réalisation

## 3.1 Présentation du code source
```text
/Gong/
├── classes/          # Logique POO (Database.php, UserManager.php...)
├── includes/         # Templates (header.php, footer.php)
├── sql/              # Script d'export de la base (gong.sql)
├── index.php         # Page principale et Matchmaking
└── admin.php         # Back-office sécurisé
```

## 3.2 Tests unitaires et vérifications techniques
- **Anti-Spam :** Test de l'envoi d'une 3ème demande à un même membre (action bloquée par le système).
- **Matchmaking :** Validation de l'algorithme de tolérance (+/- 5 kg) sur le tri des profils.
- **Stabilité PHP 8.1+ :** Utilisation de l'opérateur de fusion null (`??`) pour éviter les erreurs `htmlspecialchars()`.

## 3.3 Fichier d'exportation de la base de données
Le script `sql/gong.sql` génère l'ensemble de la base de données, contraintes de clés étrangères incluses, ainsi qu'un jeu d'essai de 30 utilisateurs (dont le compte admin).

---

# 4. Documentation logicielle

## 4.1 Cahier de tests fonctionnels
| ID | Fonction testée | Préconditions | Résultat attendu | État |
|---|---|---|---|---|
| TF01 | Connexion Admin | Compte avec rôle 'admin' | Accès au panel autorisé | ✅ OK |
| TF02 | Accès Admin refusé | Compte avec rôle 'membre' | Redirection vers l'accueil | ✅ OK |
| TF03 | Limite de sparring | 2 requêtes déjà en attente | Message "Action refusée" | ✅ OK |
| TF04 | Ajout de club | Connecté en Admin | Le club apparaît en base | ✅ OK |

## 4.2 Manuel administrateur
1. **Installation :** Lancer le serveur local (Laragon/XAMPP), placer le projet dans le dossier `www` ou `htdocs`.
2. **Base de données :** Créer une base `gong` et importer le fichier `sql/gong.sql`.
3. **Gestion :** Depuis l'interface web (bouton Admin), modérez les utilisateurs (corbeille rouge) ou ajoutez les coordonnées GPS des nouveaux clubs partenaires.

## 4.3 Manuel utilisateur
1. **Inscription :** Remplissez précisément vos caractéristiques (poids, sport).
2. **Matchmaking :** Dès votre connexion, le système vous suggère les partenaires les plus pertinents.
3. **Sparring :** Cliquez sur "Proposer un sparring" sous un profil.
4. **Discussion :** Utilisez la messagerie intégrée pour fixer les détails logistiques de la rencontre.

---

# 5. Éléments à compléter avant le rendu

*Vérifications finales pour la commission :*
- Intégrer les images réelles des diagrammes (Cas d'utilisation, Classes) dans le dossier `docs/` de GitHub.
- Intégrer l'image du modèle conceptuel de données (MCD) exporté depuis Looping.
- Ajouter des captures d'écran de l'application en fonctionnement (Accueil, Panel Admin, Notification d'erreur anti-spam).
- S'assurer que le service Laragon/WAMP est bien démarré pour la démonstration lors de l'oral.

---

**Conclusion** Le projet GONG répond aux attentes d'une situation professionnelle SLAM (développement web). Il met en œuvre une architecture POO, des règles métier spécifiques (matchmaking, sécurité anti-spam) et une interface "responsive" moderne.
