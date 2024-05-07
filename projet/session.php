<?php
function Verifier_session()
{
    if($_SESSION["connecte"]!=="1")
    {
        header("location:index.php");      
    }
}
if(isset($_SESSION["nom"]) && isset($_SESSION["prenom"])) 
{
    echo "Bonjour, " . $_SESSION["prenom"] . " " . $_SESSION["nom"];
} 
else 
{
    echo "Bienvenue, veuillez vous connecter pour accéder à votre compte.";
}
?>