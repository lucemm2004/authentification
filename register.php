<?php
    require_once 'db.php';
    require_once 'utilitaires.php';

    $class = $msg = "";
    $nom = $email = $password = $password_hash = "";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $class = "erreur";
        $msg = "Le formulaire doit être soumis avec la méthode POST !";
    }

    if($msg == ""){
        if(!isset($_POST["submit"])){
            $class = "erreur";
            $msg = "Le formulaire doit être soumis en cliquant sur le bouton <S'inscrire> !";
        }
    }
    
    if($msg == ""){
        if (empty($_POST["username"])) {
            $msg= "Le nom est requis";
            $class= "erreur";
        } else {
            $username = nettoyer_donnee($_POST["username"]);
        }    
    }
    
    if($msg == ""){
        if (empty($_POST["email"])) {
            $class = "erreur";
            $msg = "L'email est requis";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $class = "erreur";
            $msg = "Format d'email invalide";
        } else {
            $email = nettoyer_donnee($_POST["email"]);
        }
    }
    
    if($msg == ""){
        if (empty($_POST["password"])) {
            $msg= "Le mot de passe est requis";
            $class= "erreur";
        } else {
            $password = nettoyer_donnee($_POST["password"]);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        }    
    }

    // Ajout en base de données
    if($msg == ""){
        // existence du email
        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result){
            // un record trouvé => redirection vers login.html
            header(("location: login.html"));
        }else{
            // email non trouvé => on peut faire l'ajout dans la db
            $sql = 'INSERT INTO nouvtechno.users (username, password, email) VALUES (:username, :password, :email)';
            $stmt = $pdo->prepare($sql);
        
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hash);
            if ($stmt->execute()) {
                header("Location: login.html"); 
            } else {
                $class = "erreur";
                $msg = "L'inscription en base de données a échoué."; 
            }
        }

        /*
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        die();
        */

        if(count($result) == 0){
            $sql = 'INSERT INTO nouvtechno.users (username, password, email) VALUES (:username, :password, :email)';
            // $sql = 'INSERT INTO users (username,  email) VALUES (:username,  :email)';
            $stmt = $pdo->prepare($sql);
        
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hash);
            if ($stmt->execute()) {
                header("Location: login.html"); 
            } else {
                $class = "erreur";
                $msg = "L'inscription en base de données a échoué."; 
            }
    
        }else{
            $class = "erreur";
            $msg = "Veuillez saisir un autre email. Cet email existe déjà en base de données.";
        }



    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Validation inscription</title>
</head>
<body>
    <div class="container">
        <p class="<?= $class ?>"><?= $msg ?></p>
        <a href="register.html">Retour au formulaire d'inscription</a>
    </div>

</body>
</html>