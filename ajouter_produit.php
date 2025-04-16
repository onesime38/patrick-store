<?php
session_start();

// Vérifier si l'admin est authentifié
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');

// Traitement du formulaire d'ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_produit = $_POST['nom_produit'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $categorie = $_POST['categorie'];

    // Vérifier si le fichier image est envoyé
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_path = 'images/' . basename($image['name']); // Sauvegarde dans le dossier images
        move_uploaded_file($image['tmp_name'], $image_path);
    } else {
        $image_path = null; // Si aucune image n'est envoyée
    }

    // Insertion du produit dans la base de données
    $stmt = $pdo->prepare('INSERT INTO produits (nom, description, prix, quantite, categorie, image) 
                           VALUES (:nom, :description, :prix, :quantite, :categorie, :image)');
    $stmt->bindParam(':nom', $nom_produit);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':quantite', $quantite);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':image', $image_path);
    
    if ($stmt->execute()) {
        echo "<p>Le produit a été ajouté avec succès !</p>";
    } else {
        echo "<p>Une erreur est survenue lors de l'ajout du produit.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <style>
        /* Styles généraux */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.dashboard-container {
    width: 70%;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

h3 {
    font-size: 18px;
    color: #444;
    margin-bottom: 20px;
}

/* Formulaire */
form {
    display: grid;
    gap: 15px;
    max-width: 600px;
    margin: 0 auto;
}

/* Étiquettes */
label {
    font-size: 16px;
    font-weight: bold;
    color: #555;
}

/* Champs de saisie */
input[type="text"], 
input[type="number"], 
textarea, 
select, 
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus,
select:focus,
input[type="file"]:focus {
    border-color: #4CAF50; /* Couleur de bordure au focus */
    outline: none;
}

/* Boutons */
button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Lien de retour */
a {
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    color: #4CAF50;
    font-size: 16px;
}

a:hover {
    color: #45a049;
}

/* Message de succès/erreur */
p {
    font-size: 16px;
    text-align: center;
    color: #333;
}

p.success {
    color: green;
}

p.error {
    color: red;
}

/* Styles spécifiques au champ d'image */
input[type="file"] {
    padding: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        width: 90%;
    }

    form {
        width: 100%;
    }

    h2 {
        font-size: 22px;
    }

    button[type="submit"] {
        width: 100%;
    }
}

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="dashboard-container">
    <h2>Ajouter un produit</h2>
    
    <!-- Formulaire pour ajouter un produit -->
    <form method="POST" enctype="multipart/form-data">
        <label for="nom_produit">Nom du produit :</label>
        <input type="text" name="nom_produit" required><br><br>

        <label for="description">Description :</label>
        <textarea name="description" rows="4" required></textarea><br><br>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" step="0.01" required><br><br>

        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" required><br><br>

        <label for="categorie">Catégorie :</label>
        <select name="categorie" required>
            <option value="Electronique">Electronique</option>
            <option value="Vêtements">Vêtements</option>
            <option value="Alimentation">Alimentation</option>
            <option value="Maison">Maison</option>
        </select><br><br>

        <label for="image">Image du produit :</label>
        <input type="file" name="image"><br><br>

        <button type="submit">Ajouter le produit</button>
    </form>

    <a href="dashboard.php">Retour au tableau de bord</a>
</div>

</body>
</html>
