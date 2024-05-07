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
    $commande->insertOrderItem();
    $_SESSION['panier'] = array();
    $_SESSION['qty'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
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
        header select {
            color: #ff3e6c;
            padding: 8px 16px;
            font-size: 18px;
            background-color: #ffebf2;
            border: 1px solid #ff3e6c;
            border-radius: 20px;
            font-family: Ariel ;
        }
        header select:hover {
            cursor: pointer;
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
        h1 {
            font-family: Ariel ; 
            font-size: 35px;
            font-weight: bold;
        }
        h4 {
            font-family: Ariel ; 
            font-weight: bold;
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
            font-family: Ariel ;
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
    <a href="accueilclient.php">Accueil</a>
    <select name="produit" id="produit" onchange="window.location.href = this.value;">
        <option value="#pd">Produits</option>
        <option value="make-up.php">Make-up</option>
        <option value="corps.php">Corps</option>
        <option value="visage.php">Visage</option>
        <option value="homme.php">Homme</option>
    </select>
    <a href="profile.php">Profile</a>
    <a href="panier.php">Panier</a>
    <a href="deconnexion.php">Deconnexion</a>
</header>
<div class="container">
    <h4 class="text-center text-capitalize text-uppercase">Panier</h4>
    <hr>
    <div>
        <table class="table table-striped table-hover text-center text-capitalize">
        <?php
        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) 
        {
            $cnx = new connexion();
            $pdo = $cnx->CNXbase();
            $prix_total_global = 0;
            echo '<table class="table table-striped table-hover text-center text-capitalize">';
            echo '<tr class="border border-danger">';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Price</th>';
            echo '<th>Quantities</th>';
            echo '<th>Category</th>';
            echo '<th>Photo</th>';
            echo '<th>Prix</th>';
            echo '<th>Operations</th>';
            echo '</tr>';
            foreach ($_SESSION['panier'] as $key => $id_produit) 
            {
                $requete = $pdo->prepare("SELECT id, nom_p, photo , qte , prix, categorie FROM produit WHERE id = :id");
                $requete->bindParam(':id', $id_produit);
                $requete->execute();
                $row = $requete->fetch(PDO::FETCH_ASSOC);
                $prix_total_produit = $row['prix'] * $_SESSION['qty'][$key];
                $prix_total_global += $prix_total_produit;
                echo '<tr class="border border-danger">';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nom_p'] . '</td>';
                echo '<td>' . $row['prix'] . '</td>';
                echo '<td>' . $_SESSION['qty'][$key] . '</td>';
                echo '<td>' . $row['categorie'] . '</td>';
                echo '<td><img class="rounded border border-danger-subtle" src="images/' . $row['photo'] . '" width="50" height="50"></td>';
                echo '<td>' . $prix_total_produit . '</td>'; 
                echo '<td>'; 
                echo '<form method="post">';
                echo '<input type="hidden" name="id_produit" value="' . $row['id'] . '">';
                echo '<input type="submit" name="supprimer_panier" value="Supprimer" class="btn" style="background-color: #ffcccc;">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '<tr class="border border-danger">';
            echo '<td colspan="7" class="text-end"><strong>Prix total global:</strong></td>';
            echo '<td colspan="2" class="border border-danger">' . $prix_total_global . '</td>';
            echo '</tr>';
            echo '</table>';
        } 
        else 
        {
            echo '<p>Votre panier est vide.</p>';
        }
        ?>
        </table>
    </div>
    <form class="d-grid gap-2 d-md-flex justify-content-md-end" onsubmit="return validateForm()">
        <input class="btn btn-secondary btn-sm" type="submit" value="Valider">
    </form>
    <script>
    function validateForm() 
    {
        alert("Commande validée avec succès!");
        return false;
    }
    </script>
</div>
<footer class="footer mt-auto py-3 text-center">
    <div class="container">
        <p>&copy; 2024 AURORA COSMETICS. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
