<?php
session_start(); 
require_once('pdo.php');
if (!isset($_SESSION['nom'])) 
{
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $tel = $_POST["tel"];
    $pwd = $_POST["pwd"];
    $username = $_SESSION['nom']; 
    $cnx = new connexion();
    $pdo = $cnx->CNXbase();
    $requete = $pdo->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, tel = :tel, pwd = :pwd WHERE nom = :nom_session");
    $requete->bindParam(':nom_session', $username);
    $requete->bindParam(':nom', $nom);
    $requete->bindParam(':prenom', $prenom);
    $requete->bindParam(':tel', $tel);
    $requete->bindParam(':pwd', $pwd);
    $requete->execute();
    $_SESSION["nom"] = $nom;
    $_SESSION["prenom"] = $prenom;
}
header("Location: profile.php");
exit();
?>
