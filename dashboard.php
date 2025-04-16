<?php
session_start();

if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
    <style>
        /* Styles spécifiques au tableau de bord */
.dashboard-container {
    width: 80%;
    margin: 0 auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #333;
    margin-bottom: 20px;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    margin: 10px 0;
    display: inline-block;
}

ul li a {
    display: inline-block;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 16px;
    transition: background-color 0.3s;
}

ul li a:hover {
    background-color:rgb(220, 117, 21);
}

.logout-btn {
    background-color: #f44336;
    width: 100%;
    text-align: center;
    padding: 10px ;
    font-size: 16px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.logout-btn:hover {
    background-color:rgb(236, 166, 17);
}

    </style>
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="dashboard-container">
    <h2>Bienvenue, <?= $_SESSION['username'] ?> !</h2>
    <h3>Fonctionnalités <a ref href="index.html"> Accueil</a></h3> 
    <ul>
        <li><a href="admin_commandes.php">Gérer les commandes</a></li>
        <li><a href="ajouter_produit.php">Ajouter un produit</a></li>
        <li><a href="statistiques.php">Voir les statistiques</a></li>
    </ul>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Se déconnecter</button>
</div>

</body>
</html>
