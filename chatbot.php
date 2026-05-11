<?php
// api/chatbot.php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Veuillez vous connecter pour utiliser le coach IA.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['error' => 'Le message est vide.']);
    exit();
}

// ==========================================
// 1. TA CLÉ API GEMINI
// ==========================================
$apiKey = 'AIzaSyASErL0JBzDdMzZXbLO8eX5NP2Nxtyxb3o';

// 2. L'URL avec le bon modèle trouvé par ton test
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . trim($apiKey);

// 3. Le "System Prompt"
$systemInstruction = "Tu es Coach GONG, l'assistant virtuel de l'application de sparring GONG. 
Tu donnes des conseils francs, précis et sécuritaires sur les sports de combat (MMA, Boxe, JJB, Judo, etc.). 
Si l'utilisateur pose une question qui n'a rien à voir avec le sport, l'entraînement ou la nutrition sportive, refuse poliment de répondre. 
Rappelle toujours que tu es une IA et qu'en cas de blessure ou de douleur, il faut consulter un médecin. Sois motivant et direct.";

// 4. Préparation des données
$postData = [
    "systemInstruction" => [
        "parts" => [ ["text" => $systemInstruction] ]
    ],
    "contents" => [
        [ "parts" => [ ["text" => $userMessage] ] ]
    ],
    "generationConfig" => [
        "temperature" => 0.7
    ]
];

// 5. Envoi de la requête
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

// Empêche le blocage SSL en local
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 6. Traitement de la réponse
if ($httpCode == 200) {
    $responseData = json_decode($response, true);
    $aiReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "Désolé, je n'ai pas pu répondre.";
    
    $aiReplyHtml = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', htmlspecialchars($aiReply));
    $aiReplyHtml = nl2br($aiReplyHtml);
    
    echo json_encode(['reply' => $aiReplyHtml]);
} else {
    $erreurGoogle = json_decode($response, true);
    $messageDetaille = $erreurGoogle['error']['message'] ?? 'Erreur inconnue';
    echo json_encode(['error' => "Erreur API ($httpCode) : " . $messageDetaille]);
}
?>