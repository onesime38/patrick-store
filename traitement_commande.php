<?php
// Connexion à la base de données (MariaDB)
$host = 'localhost';
$dbname = 'patrick_boutique'; // le nom de ta base de données
$username = 'root';
$password = ''; // mets ton mot de passe si nécessaire

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer les données du formulaire
$nom       = $_POST['nom'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$adresse   = $_POST['adresse'] ?? '';
$produit   = $_POST['produit'] ?? '';
$quantite  = $_POST['quantite'] ?? 1;
$date_commande = date('Y-m-d H:i:s');
$statut = "en attente";

// Vérifier si les champs obligatoires sont remplis
if ($nom && $telephone && $adresse && $produit && $quantite > 0) {
    // Préparer la requête d'insertion
    $sql = "INSERT INTO commandes (nom_client, adresse, telephone, date_commande, statut, produit, quantite)
            VALUES (:nom, :adresse, :telephone, :date_commande, :statut, :produit, :quantite)";
    
    $stmt = $pdo->prepare($sql);
    
    // Lier les valeurs
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':date_commande', $date_commande);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':produit', $produit);
    $stmt->bindParam(':quantite', $quantite);

    // Exécuter
    if ($stmt->execute()) {
        echo "<h2>Merci $nom !</h2><p>Votre commande a bien été enregistrée. Nous vous contacterons bientôt.</p>";
    } else {
        echo "Erreur lors de l'enregistrement de la commande.";
    }

} else {
    echo "Veuillez remplir tous les champs du formulaire.";
}
?>
