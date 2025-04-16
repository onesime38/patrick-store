<?php
session_start();

if (isset($_POST['produit_id'])) {
    $produit = [
        'id' => $_POST['produit_id'],
        'nom' => $_POST['nom'],
        'prix' => $_POST['prix'],
        'quantite' => 1
    ];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $existe = false;
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['id'] == $produit['id']) {
            $item['quantite']++;
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $_SESSION['panier'][] = $produit;
    }

    header("Location: panier.php");
    exit();
}
?>
