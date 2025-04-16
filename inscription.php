<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'patrick_boutique';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Traitement du formulaire d'inscription
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Sécuriser le mot de passe

        // Vérifier si le nom d'utilisateur est déjà pris
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Le nom d'utilisateur est déjà pris.";
        } else {
            // Insérer le nouvel admin dans la base de données
            $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            echo "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        }
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Admin</title>
</head>
<body>

<h2>Créer un compte Admin</h2>
<form method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br><br>
    <button type="submit">Créer le compte</button>
    <button type="submit"> <a href="admin_login.php">se connecter</a></button>
    
</form>

</body>
</html>
