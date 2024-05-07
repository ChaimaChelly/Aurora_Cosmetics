<?php
session_start();
require_once('utilisateur.class.php');
$us=new utilisateur();
if (isset($_POST['login']))
{
    $us->username =$_POST["login"];
    $us->pwd =$_POST["pwd"];
    try
    {
        $res = $us->getUser();         
        $data = $res->fetchAll(PDO::FETCH_ASSOC);            
        if ($data)
        {
            $_SESSION["connecte"]="1";
            $_SESSION["nom"]=$data[0]["nom"];
            header("location:utilisateur.class.php");
            exit();
        }
        else
            echo "aucun utilisateur";
    }
    catch (PDOException $e)
    {
        echo "ERREUR : ".$e->getMessage(). " LIGNE : ".$e->getLine();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];    
    require_once('pdo.php');
    $cnx = new connexion();
    $pdo = $cnx->CNXbase();
    $req = "SELECT * FROM utilisateur WHERE username = :username AND pwd = :password";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) 
    {
        $_SESSION["connecte"] = "1";
        $_SESSION["nom"] = $user["nom"];
        $_SESSION["panier"] = [];
        $_SESSION["qty"] = [];
        $type = $user['type'];
        if ($type == "client") 
        {
            header("Location: accueilclient.php");
            exit();
        } 
        else 
        {
            header("Location: accueiladmin.php");
            exit();
        }
        $_SESSION['id_utilisateur'] = $id_utilisateur;
    } 
    else 
    {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>