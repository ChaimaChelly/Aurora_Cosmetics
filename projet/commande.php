<?php 
require_once('produit.class.php');
require_once('commande.class.php');
require_once('pdo.php');
session_start();
function ajouterProduitAuPanier($id_produit, $qte) {
    if (!isset($_SESSION['panier'])) 
    {
        $_SESSION['panier'] = array();
        $_SESSION['qty'] = array();
    }
    $index = array_search($id_produit, $_SESSION['panier']);
    if ($index !== false) 
    {
        $_SESSION['qty'][$index] += $qte;
    } 
    else 
    {
        array_push($_SESSION['panier'], $id_produit);
        array_push($_SESSION['qty'], $qte);
    }
}
function supprimerProduitDuPanier($id_produit) {
    if (isset($_SESSION['panier'])) 
    {
        $index = array_search($id_produit, $_SESSION['panier']);
        if ($index !== false) 
        {
            array_splice($_SESSION['panier'], $index, 1);
            array_splice($_SESSION['qty'], $index, 1);
        }
    }
}
if (isset($_POST['ajouter_panier'])) 
{
    $id_produit = $_POST['id_produit'];
    $qte = $_POST['quantite'];
    ajouterProduitAuPanier($id_produit, $qte);
}
if (isset($_POST['supprimer_panier'])) 
{
    $id_produit = $_POST['id_produit'];
    supprimerProduitDuPanier($id_produit);
}
if (isset($_POST['valider_commande'])) 
{
    $commande = new commande();
    $product_id = $_SESSION['panier'][0];
    $user_id = $_SESSION['user_id']; 
    $quantity = $_SESSION['qty'][0]; 
    $price = 0; 
    $commande->product_id = $product_id;
    $commande->user_id = $user_id;
    $commande->quantity = $quantity;
    $commande->price = $price;
    $commande->status = "En attente"; 
    $inserted = $commande->insertOrderItem();
    if ($inserted) 
    {
        $_SESSION['panier'] = array();
        $_SESSION['qty'] = array();
    } 
    else 
    {
        echo "Erreur lors de l'insertion de la commande.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes </title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contact-icons img {
            border-radius: 50%;
        }
        .contact-icons img:hover {
            cursor: pointer;
        }
        header, footer {
            background-color: whitesmoke; 
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; 
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }
        header p, footer p {
            margin: 0;
        }
        .contact-info {
            margin-bottom: 10px; 
        }
        h1 {
            font-family: Ariel ; 
            font-size: 35px;
            font-weight: bold;
        }
        header select {
            color: #ff3e6c;
            padding: 8px 16px;
            font-size: 18px;
            background-color: #ffebf2;
            border: 1px solid #ff3e6c;
            border-radius: 20px;
            font-family: Ariel ;
        }
        header a, footer a {
            color: #ff3e6c;
            font-size: 18px;
            text-decoration: none;
            margin-left: 10px;
            border: 1px solid #ff3e6c; 
            background-color: #ffebf2; 
            padding: 8px 16px; 
            border-radius: 20px;
            font-family: Ariel ;
        }
        header select:hover {
            cursor: pointer;
        }
        header a:hover, footer a:hover {
            background-color: #ff3e6c; 
            color: #fff; 
        }
        footer {
            background-color: whitesmoke;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2); 
        }
        footer p {
            margin: 0;
        }
        .footer {
            color: #ff3e6c;
        }
        .footer p {
            text-align: center;
            color: black;
        }
        .container {
            width: 100%;
            padding: 20px;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }
        .border-danger-subtle {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
<h1>BIENVENUE <?php echo isset($_SESSION["nom"]) ? strtoupper($_SESSION["nom"]) : ""; ?> </h1>    
<div class="contact-info"> 
    <header>
        <p>
            <img src="../projet/images/cs.png" height="20" width="20" class="contact-icons"> Customer Service: 50412596
            <img src="../projet/images/whatsapp.png" height="20" width="20" class="contact-icons"> Whatsapp: 589556923
        </p>
    </header>
</div>
<header> 
<a href="accueiladmin.php">Accueil</a> 
    <select name="produit" id="produit" onchange="window.location.href = this.value;">
        <option value="#pd">Produits</option>
        <option value="make-upadmin.php">Make-up</option>
        <option value="corpsadmin.php">Corps</option>
        <option value="visageadmin.php">Visage</option>
        <option value="hommeadmin.php">Homme</option>
    </select>
    <a href="profileadmin.php">Profile</a>
    <a href="commande.php">Commandes</a>
    <a href="listeClient.php">Clients</a>
    <a href="deconnexion.php">Deconnexion</a>
</header>
<div class="container">
    <h4 class="text-center text-capitalize text-uppercase">Commandes</h4>
    <hr>
    <div>
        <table class="table table-striped table-hover text-center text-capitalize">
        <?php
                $commande = new commande();
                $res = $commande->listOrderItems();
                foreach ($res as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['product_id'] . '</td>';
                    echo '<td>' . $row['user_id'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '</tr>';
                }
        ?>
        </table>
    </div>
</div>
<footer class="footer mt-auto py-3 text-center">
    <div class="container">
        <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>

