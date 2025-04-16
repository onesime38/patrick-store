<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');

// Traitement : suppression d'une commande
if (isset($_POST['action']) && $_POST['action'] === 'supprimer' && isset($_POST['id'])) {
    // Supprimer les détails de la commande
    $stmt = $pdo->prepare("DELETE FROM details_commande WHERE commande_id = ?");
    $stmt->execute([$_POST['id']]);

    // Supprimer la commande elle-même
    $stmt = $pdo->prepare("DELETE FROM commandes WHERE id = ?");
    $stmt->execute([$_POST['id']]);
}

// Traitement : changement de statut
if (isset($_POST['action']) && $_POST['action'] === 'changer_statut' && isset($_POST['id'], $_POST['statut'])) {
    $stmt = $pdo->prepare("UPDATE commandes SET statut = ? WHERE id = ?");
    $stmt->execute([$_POST['statut'], $_POST['id']]);
}

// Récupération des commandes
$query = "SELECT * FROM commandes ORDER BY id DESC";
$stmt = $pdo->query($query);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si les commandes ont été récupérées correctement
if (empty($commandes)) {
    echo "Aucune commande trouvée.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Commandes</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }
        .table-container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        .btn-status {
            background-color: #27ae60;
        }
        .btn:hover {
            opacity: 0.9;
        }
        select {
            padding: 5px;
        }
    </style>
</head>
<body>

<h2>Tableau de bord - Commandes <a href="index.html">accueil</a></h2>
<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom Client</th>
            <th>Adresse</th>
            <th>Telephone</th>
            <th>Date</th>
            <th>Produits</th>
            <th>Prix Unitaire</th>
            <th>Total</th> <!-- Nouvelle colonne pour le total -->
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?= $commande['id'] ?></td>
                <td><?= htmlspecialchars($commande['nom']) ?></td>
                <td><?= htmlspecialchars($commande['adresse']) ?></td>
                <td><?= htmlspecialchars($commande['telephone']) ?></td>
                <td><?= htmlspecialchars($commande['date_commande']) ?></td>
                <td>
                    <?php
                    // Récupérer les produits de la commande avec prix et quantités
                    $query_products = "SELECT nom_produit, quantite, prix_unitaire FROM details_commande WHERE commande_id = ?";
                    $stmt_products = $pdo->prepare($query_products);
                    $stmt_products->execute([$commande['id']]);
                    $produits = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

                    // Affichage des produits
                    foreach ($produits as $produit) {
                        echo $produit['nom_produit'] . " (" . $produit['quantite'] . " achat)<br>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    // Afficher les prix unitaires des produits
                    foreach ($produits as $produit) {
                        echo number_format($produit['prix_unitaire'], 2) . " FBU<br>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    // Calculer le total de la commande
                    $total = 0;
                    foreach ($produits as $produit) {
                        $total += $produit['prix_unitaire'] * $produit['quantite']; // Total = prix_unitaire * quantite
                    }
                    echo number_format($total, 2) . " FBU";
                    ?>
                </td>
                <td>
                    <?php
                    // Vérifier si le statut est défini, sinon afficher un message par défaut
                    if (isset($commande['statut'])) {
                        echo htmlspecialchars($commande['statut']);
                    } else {
                        echo "Non défini";
                    }
                    ?>
                </td>
                <td>
                    <!-- Formulaire pour changer le statut -->
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $commande['id'] ?>">
                        <input type="hidden" name="action" value="changer_statut">
                        <select name="statut">
                            <option value="en attente" <?= $commande['statut'] == 'en attente' ? 'selected' : '' ?>>🕒 En attente</option>
                            <option value="en cours" <?= $commande['statut'] == 'en cours' ? 'selected' : '' ?>>🚚 En cours</option>
                            <option value="livrée" <?= $commande['statut'] == 'livrée' ? 'selected' : '' ?>>✅ Livrée</option>
                        </select>
                        <button type="submit" class="btn btn-status">Changer</button>
                    </form>

                    <!-- Formulaire pour supprimer la commande -->
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $commande['id'] ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <button type="submit" class="btn btn-delete">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
