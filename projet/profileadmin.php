<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
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
        .profile-info {
            text-align: center;
            margin-top: 20px; 
            font-size: 20px;
        }
        .profile{
            text-align: center;
            font-size: 40px;
        }
        .btn {
            color: #ff3e6c;
            font-size: 16px;
            text-decoration: none;
            margin-left: 10px;
            border: 1px solid #ff3e6c; 
            background-color: #ffebf2; 
            padding: 8px 16px; 
            border-radius: 20px; 
        }
        .btn:hover {
            background-color: #ff3e6c;
            color: #fff;
        }
        .container-info {
            width: 80%;
            margin: 100px auto;
            background-color: #ffebf2;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ff3e6c;
        }
        h1 {
            margin-bottom: 20px;
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
    <div class="container-info">
        <h1 class="profile">Profile Admin</h1>
        <div class="profile-info">
            <?php
            if (session_status() == PHP_SESSION_NONE) 
            {
                session_start();
            }
            require_once('pdo.php');
            if(isset($_SESSION['nom'])) 
            {
                $nom_utilisateur = $_SESSION['nom'];
                $cnx = new connexion();
                $pdo = $cnx->CNXbase();
                $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE nom = :nom");
                $stmt->bindParam(':nom', $nom_utilisateur);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if($user) 
                {
                    echo "<p>Prénom: " . htmlspecialchars($user['nom']) . "</p>";
                    echo "<p>Nom: " . htmlspecialchars($user['prenom']) . "</p>";
                    echo "<p>Nom d'utilisateur: " . htmlspecialchars($user['username']) . "</p>";
                    echo "<p>Téléphone: " . htmlspecialchars($user['tel']) . "</p>";
                    
                } 
                else 
                {
                    echo "<p>Erreur: Impossible de récupérer les informations du profil.</p>";
                }
            } 
            else 
            {
                echo "<p>Vous devez être connecté pour accéder à votre profil.</p>";
            }
            ?>
        </div>
    </div>
    <footer class="footer mt-auto py-3 text-center">
        <div class="container">
            <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
        </div>
    </footer>
   
</body>
</html>
