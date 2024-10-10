<?php
    session_start();
    require_once 'db.php';
    require_once 'utilitaires.php';

    $class = $msg = "";
    $email = $password = $password_hash = "";

    // ce test devrait se faire à l'ouverture du login
    // mais alors on doit avoir un seul fichier login.php
    // et pas de login.html
    // or dans l'énoncé du projet on demande 
    if($_COOKIE['remember']){
        $user_id = $_COOKIE['remember'];

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // accès page d'accueil
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        header("Location: accueil.php"); 
        exit();
        
    }

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
            //$password_hash = password_hash($password, PASSWORD_DEFAULT);
        }    
    }

    if($msg == ""){
        // existence du email
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){
            // comparaison pwd introduit avec pwd en base de données
            if(password_verify($password, $result['password'])){
                // le password est correcte
                // gestion se souvenir de moi
                if($_POST['remember']){
                    // ajout dans les cookies
                    setcookie('remember', $result['id'], time() + 3600);
                }

                // accès page d'accueil
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                header("Location: accueil.php"); 
                exit();
            }else{
                // le password ne correspond pas
                $class = "erreur";
                $msg = "Email ou mot de passe incorrectes !";
            }
        }else{
            // mail non trouvé
            $class = "erreur";
            $msg = "Email ou mot de passe incorrectes !";
        }
    }
        
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Validation connexion</title>
</head>
<body>
    <div class="message-container">
        <p class="<?= $class ?>"><?= $msg ?></p>
        <a href="login.html">Retour au formulaire de connexion</a>
    </div>

</body>
</html>