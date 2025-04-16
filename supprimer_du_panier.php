<?php
session_start();

if (isset($_POST['produit_id'])) {
    foreach ($_SESSION['panier'] as $index => $item) {
        if ($item['id'] == $_POST['produit_id']) {
            unset($_SESSION['panier'][$index]);
            $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer
            break;
        }
    }
}

header("Location: panier.php");
exit();
?>
