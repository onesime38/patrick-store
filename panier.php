<?php
session_start();
$panier = $_SESSION['panier'] ?? [];
$total = 0;
?>

<h2>🛒 Votre Panier <a href="afficher_produits.php"> choisisser un autre produit</a></h2>

<?php if (count($panier) === 0): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nom</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Sous-total</th>
            <th>Action</th>
        </tr>

        <?php foreach ($panier as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nom']) ?></td>
                <td><?= number_format($item['prix'], 2) ?> €</td>
                <td><?= $item['quantite'] ?></td>
                <td><?= number_format($item['prix'] * $item['quantite'], 2) ?> fbu</td>
                <td>
                    <form method="post" action="supprimer_du_panier.php">
                        <input type="hidden" name="produit_id" value="<?= $item['id'] ?>">
                        <button type="submit">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php $total += $item['prix'] * $item['quantite']; ?>
        <?php endforeach; ?>

        <tr>
            <td colspan="3" align="right"><strong>Total</strong></td>
            <td colspan="2"><strong><?= number_format($total, 2) ?> fbu</strong></td>
        </tr>
    </table>

    <br>
    <a href="valider_commande.php">✅ Valider la commande</a>
<?php endif; ?>
