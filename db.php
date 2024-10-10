<?php
    
    try {

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbName = 'nouvtechno';
    
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host  . ';charset=utf8';
        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Connexion réussie! <br>';
    } catch (PDOException $e) {
        echo 'Connexion échouée: ' . $e->getMessage();
    }

/*
CREATE TABLE `nouvtechno`.`users` (`id` INT NOT NULL AUTO_INCREMENT ,
     `username` VARCHAR(25) NOT NULL ,
      `password` VARCHAR(255) NOT NULL ,
       `email` VARCHAR(50) NOT NULL ,
        PRIMARY KEY (`id`),
         UNIQUE `email` (`email`)) ENGINE = InnoDB;
*/

?>