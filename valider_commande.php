<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Valider la commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }
        .form-container {
            background-color: white;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Finaliser votre commande</h2>
    <form action="enregistrer_commande.php" method="post">
        <label>Nom et prénom :</label>
        <input type="text" name="nom" required>

        <label>Adresse :</label>
        <input type="text" name="adresse" required>

        <label>Téléphone :</label>
        <input type="tel" name="telephone" required>

        <button type="submit">Envoyer</button>
    </form>
</div>

</body>
</html>
