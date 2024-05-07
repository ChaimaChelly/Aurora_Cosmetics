<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits pour homme</title>
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
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
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
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2); 
    }
    footer p {
        margin: 0;
    }
    footer a {
        color: #ff3e6c;
        font-size: 16px;
        text-decoration: none;
        margin-left: 10px;
        border: 1px solid #ff3e6c; 
        background-color: #ffebf2; 
        padding: 8px 16px; 
        border-radius: 20px; 
    }
    footer a:hover {
        background-color: #ff3e6c;
        color: #fff; 
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
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
    }
    
</style>
</head>
<body>
<?php
session_start();
?>
<h1>BIENVENUE <?php echo isset($_SESSION["nom"]) ? strtoupper($_SESSION["nom"]) : ""; ?> </h1>    
    <div class="contact-info"> 
        <header> 
            <p> 
                <img src="../projet/images/cs.png" height="20" width="20" class="contact-icons">  Service Client : 50412596  
                <img src="../projet/images/whatsapp.png" height="20" width="20" class="contact-icons">   Whatsapp : 589556923
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
    <h4 class="text-center text-capitalize text-uppercase">Liste des produits de la catégorie Visage</h4>
    <hr>
    <div>
    <?php
            if(isset($_SESSION['nom'])) 
            {
    ?>
        <table class="table table-striped table-hover text-center text-capitalize">
            <tr class="border border-danger">
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantités</th>
                <th>Catégorie</th>
                <th>Photo</th>
                <th>Opérations</th>
            </tr>
            <?php
        require_once('produit.class.php');
        require_once('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $categorie = "visage";
        $requete = $pdo->prepare("SELECT id ,nom_p, photo , qte , prix , categorie FROM produit WHERE categorie = :categorie");
        $requete->bindParam(':categorie', $categorie);
        $requete->execute();
         foreach ($requete as $row){?>

<tr class="border border-danger">
                    <td class="border border-danger"><?php echo $row['id'] ?></td>
                    <td class="border border-danger"><?php echo $row['nom_p'] ?></td>
                    <td class="border border-danger"><?php echo $row['prix'] ?></td>
                    <td class="border border-danger"><?php echo $row['qte'] ?></td>
                    <td class="border border-danger"><?php echo $row['categorie'] ?></td>
                    <td class="border border-danger">  <img class="rounded border border-danger-subtle" src="images/<?php echo $row['photo'] ?>" width="50" height="50"> </td>
                    <td class="border border-danger">
                        <a style="background-color: #ffcccc;" class="btn " type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample" href="delete.php?id=<?= $row['id']; ?>">Supprimer</a>
                        <a style="background-color: #ffcccc;" class="btn " type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample" href="modifForm.php?id=<?php echo $row['id']; ?>">Modifier</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <form class="d-grid gap-2 d-md-flex justify-content-md-end" action="ajouterproduit.php" method="get">
        <input class="btn btn-secondary btn-sm " type="submit" value="Ajouter un produit">
    </form>
</div>
<?php    
            }
            else 
            {
                echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
            }
?>

<footer class="footer mt-auto py-3 text-center">
    <div class="container">
        <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>
