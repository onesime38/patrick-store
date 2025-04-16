<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');

$nom = $_POST['nom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    die("Le panier est vide.");
}

// Insérer la commande
$stmt = $pdo->prepare("INSERT INTO commandes (nom, adresse, telephone, date_commande) VALUES (?, ?, ?, NOW())");
$stmt->execute([$nom, $adresse, $telephone]);
$commande_id = $pdo->lastInsertId();

// Insérer chaque produit du panier
foreach ($panier as $item) {
    $stmt = $pdo->prepare("INSERT INTO details_commande (commande_id, produit_id, nom_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$commande_id, $item['id'], $item['nom'], $item['quantite'], $item['prix']]);
}

// Vider le panier
unset($_SESSION['panier']);

echo "<p style='text-align:center;'>✅ Commande enregistrée avec succès !</p>";
echo "<p style='text-align:center;'><a href='index.html'>Retour à l'accueil</a></p>";
?>
