<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/ClubManager.php';
include 'includes/header.php';

$clubManager = new ClubManager();
$clubs = $clubManager->getAllClubs();
?>

<h1 class="title">Clubs de Combat en France</h1>
<p class="subtitle">Trouve une salle près de chez toi.</p>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div id="map" style="height: 500px; border-radius: 15px; border: 2px solid #ff3860;"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([46.603354, 1.888334], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    <?php foreach($clubs as $club): ?>
        L.marker([<?= $club['latitude'] ?>, <?= $club['longitude'] ?>])
            .addTo(map)
            .bindPopup("<b><?= htmlspecialchars($club['nom']) ?></b><br><?= htmlspecialchars($club['sports_proposes']) ?>");
    <?php endforeach; ?>
</script>

<?php include 'includes/footer.php'; ?>