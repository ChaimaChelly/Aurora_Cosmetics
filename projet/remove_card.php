<?php
session_start();
if(isset($_SESSION["nom"])) 
{
    if(isset($_GET['id'])) 
    {
        $id_produit_a_supprimer = $_GET['id'];
        if(in_array($id_produit_a_supprimer, $_SESSION['panier'])) 
        {
            $index_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']);
            array_splice($_SESSION['panier'], $index_produit, 1);
            array_splice($_SESSION['qty'], $index_produit, 1);
            header("Location: panier.php");
            exit();
        } 
        else 
        {
            echo "Le produit à supprimer n'existe pas dans le panier.";
        }
    } 
    else 
    {
        echo "L'identifiant du produit à supprimer n'est pas spécifié.";
    }
} 
else 
{
    echo "Vous n'êtes pas connecté.";
}
?>