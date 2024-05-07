<?php
    session_start();
    if(isset($_SESSION["nom"]))
    {
        if(isset($_GET['username']))
        {
            require_once('pdo.php');
            $cnx = new connexion();
            $pdo = $cnx->CNXbase();
            $username = $_GET['username'];
            $requete = $pdo->prepare("DELETE FROM  utilisateur WHERE username = :username");
            $requete->bindParam(':username', $username);
            $requete->execute();
            header("Location: accueiladmin.php");
            exit();
        }
        else
        {
            echo "Le client n'est pas spécifié.";
        }
    }
    else 
    {
        echo "Vous n'êtes pas connecté.";
    }
?>
