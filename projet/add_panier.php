<?php
session_start();
if (!isset($_SESSION['panier'])) 
{
    $_SESSION['panier'] = array();
}
if (!isset($_SESSION['qty'])) 
{
    $_SESSION['qty'] = array();
}
require_once('pdo.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (in_array($_POST["id_produit"], $_SESSION['panier'])) 
    {
        $key = array_search($_POST["id_produit"], $_SESSION['panier']);
        $_SESSION['qty'][$key] += 1;
    } 
    else 
    {
        array_push($_SESSION['panier'], $_POST["id_produit"]);
        array_push($_SESSION['qty'], 1);
    }
}
header("Location: panier.php");
exit(); 
?>
