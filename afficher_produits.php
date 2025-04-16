<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');

// Récupérer les produits depuis la base de données
$query = "SELECT * FROM produits";
$stmt = $pdo->query($query);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style de la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .product-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .product-description {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
        }

        .product-price {
            font-size: 18px;
            color: #4CAF50;
            margin: 10px 0;
        }

        .add-to-cart {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .product-container {
                width: 90%;
            }

            h2 {
                font-size: 24px;
            }

            .product-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>

<div class="product-container">
    <h2>Nos Produits</h2>
    <div class="product-grid">
        <?php foreach ($produits as $produit): ?>
            <div class="product-card">
                <img src="<?php echo $produit['image']; ?>" alt="Image du produit" class="product-image">
                <h3 class="product-name"><?php echo htmlspecialchars($produit['nom']); ?></h3>
                <p class="product-description"><?php echo htmlspecialchars($produit['description']); ?></p>
                <p class="product-price"><?php echo number_format($produit['prix'], 2, ',', ' ') . ' fbu'; ?></p>

                <!-- Formulaire pour ajouter au panier -->
                <form action="ajouter_au_panier.php" method="post">
                    <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                    <input type="hidden" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>">
                    <input type="hidden" name="prix" value="<?= $produit['prix'] ?>">
                    <button type="submit" class="add-to-cart">🛒 Ajouter au panier</button>
                </form>

                <!-- Lien pour voir le panier -->
                <a href="panier.php" style="display:block; margin-top: 10px; text-decoration: none;">🔍 Voir mon panier</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
