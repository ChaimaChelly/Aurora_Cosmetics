<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make-up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .contact-icons img {
            border-radius: 50%;
        }
        .contact-icons img:hover {
            cursor: pointer;
        }
        h1 {
            font-family: Ariel ; 
            font-size: 35px;
            font-weight: bold;
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
        header select {
            color: #ff3e6c;
            padding: 5px;
            font-size: 18px;
            background-color: #ffebf2;
            border: 1px solid #ff3e6c;
            border-radius: 20px;
            font-family: Ariel ;
        }
        header select:hover {
            cursor: pointer;
        }
        header a, footer a, .btn-nav {
            color: #ff3e6c;
            font-size: 8px 16px;
            text-decoration: none;
            margin-left: 10px;
            border: 1px solid #ff3e6c; 
            background-color: #ffebf2; 
            padding: 8px 16px; 
            border-radius: 20px;
            font-family: Ariel ;
        }
        header a:hover, footer a:hover, .btn-nav:hover {
            background-color: #ff3e6c; 
            color: #fff; 
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .product {
            flex: 1 0 30%; 
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            display: flex; 
            flex-direction: column; 
            align-items: center;
            margin-bottom: 20px;
        }
        .product img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .product-info {
            text-align: center;
            margin-bottom: 10px;
        }
        .product-price {
            font-weight: bold;
        }
        .product button {
            color: #ff3e6c;
            font-size: 16px;
            text-decoration: none;
            border: 1px solid #ff3e6c; 
            background-color: #ffebf2;
            padding: 8px 16px; 
            border-radius: 20px; 
        }
        .product button:hover {
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
    <div class="product-container">
    <?php
    if(isset($_SESSION['nom'])) 
    { 
        require_once('produit.class.php');
        require_once('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $categorie = "make-up";
        $requete = $pdo->prepare("SELECT id, nom_p, photo , qte , prix FROM produit WHERE categorie = :categorie");
        $requete->bindParam(':categorie', $categorie);
        $requete->execute();
        if ($requete->rowCount() > 0)
        {
            while ($row = $requete->fetch(PDO::FETCH_ASSOC))
            {
                echo "<div class='product'>"; ?>
                <img src= "images/<?php echo $row['photo']; ?>" width="100" height="100">
                <?php
                echo "<p> " . $row['nom_p'] . "</p>";
                echo "<p> Prix: " . $row['prix'] . " TND</p>";
                echo "<form action='add_panier.php' method='post'>";
                    if (isset($row['id']))
                    {
                        echo "<input type='hidden' name='id_produit' id='id_produit' value='" . $row['id'] . "'>";
                    }
                    echo "<input type='submit' name='add_to_cart' value='Ajouter au panier' class='btn-nav'>";
                echo "</form>";
                echo "</div>";
            }
        } 
        else
        {
            echo "Aucun produit trouvé dans la catégorie 'make-up'.";
        }
        $pdo = null; 
    }
    else 
    {
        echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    }
    ?>  
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer class="footer mt-auto py-3 text-center">
        <div class="container">
            <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
