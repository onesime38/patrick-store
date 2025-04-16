<?php
session_start();

// Si l'admin est déjà connecté, on redirige vers le tableau de bord
if (isset($_SESSION['admin_authenticated']) && $_SESSION['admin_authenticated'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si c'est une inscription ou une connexion
    if (isset($_POST['register'])) {
        // Inscription de l'admin
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');

        // Vérifier si l'admin existe déjà
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo 'Le nom d\'utilisateur est déjà pris.';
        } else {
            // Enregistrer l'admin
            $stmt = $pdo->prepare('INSERT INTO admins (username, password) VALUES (:username, :password)');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            echo 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
        }
    } elseif (isset($_POST['login'])) {
        // Connexion de l'admin
        $username = $_POST['username'];
        $password = $_POST['password'];

        $pdo = new PDO('mysql:host=localhost;dbname=patrick_boutique', 'root', '');
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_authenticated'] = true;
            $_SESSION['username'] = $username;
            header('Location: dashboard.php'); // Rediriger vers le tableau de bord
            exit;
        } else {
            echo 'Identifiants incorrects.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Connexion / Inscription</title>
    <link rel="stylesheet" href="styles_admin_login.css">
</head>
<body>

<h2>Connexion ou Inscription Admin</h2>

<!-- Formulaire d'inscription -->
<h3><a href="inscription.php">Inscription</a></h3>
<h3><a href="index.html">Accueil</a></h3>

<!-- Formulaire de connexion -->
<h3>Connexion</h3>
<form method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br><br>
    <button type="submit" name="login"> <a href="dashboard.php">se Connecter</a></button>
</form>

</body>
</html>
