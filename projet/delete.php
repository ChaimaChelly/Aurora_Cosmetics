<?php
    session_start();
    if(isset($_SESSION["nom"]))
    {
        if(isset($_GET['id']))
        {
            require_once('pdo.php');
            $cnx = new connexion();
            $pdo = $cnx->CNXbase();
            $id = $_GET['id'];
            $requete = $pdo->prepare("DELETE FROM produit WHERE id = :id");
            $requete->bindParam(':id', $id);
            $requete->execute();
            header("Location: accueiladmin.php");
            exit();
        }
        else
        {
            echo "L'identifiant du produit n'est pas spécifié.";
        }
    }
    else 
    {
        echo "Vous n'êtes pas connecté.";
    }
?>