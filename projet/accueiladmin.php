<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil client</title>
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
        header a:hover, footer a:hover {
            background-color: #ff3e6c; 
            color: #fff;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px;
            padding: 20px;
        }
        .product {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        .product img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            margin-bottom: 10px;
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
        .product-carousel {
            width: 100%; 
            height: 500px; 
            overflow: hidden; 
        }
        .product-carousel img {
            width: 100%; 
            height: 100%;
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
    
    <h1 id="pd"> Voila nos produits </h1>   
    <div class="product-container">
        <?php 
        require_once('produit.class.php');
        require_once('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $requete_categories = $pdo->query("SELECT DISTINCT categorie FROM produit");
        if ($requete_categories->rowCount() > 0)
        {
            while ($row_cat = $requete_categories->fetch(PDO::FETCH_ASSOC))
            {
                $categorie = $row_cat['categorie'];
                $requete_produit = $pdo->prepare("SELECT nom_p, photo FROM produit WHERE categorie = :categorie LIMIT 1");
                $requete_produit->bindParam(':categorie', $categorie);
                $requete_produit->execute();
                if ($requete_produit->rowCount() > 0)
                {
                    $row_prod = $requete_produit->fetch(PDO::FETCH_ASSOC);
                    echo "<div class='product'>";
                    echo "<img src='../projet/images/" . $row_prod['photo'] . "'>";
                    echo "<p>" . $row_prod['nom_p'] . "</p>";
                    echo "</div>";
                }
                else
                {
                    echo "<div class='product'>";
                    echo "<p>Aucun produit trouvé dans la catégorie '$categorie'.</p>";
                    echo "</div>";
                }
            }
        }
        $pdo = null;
        ?>
    </div>
    <script>
    setInterval(checkInactivity, 600000); 
    function checkInactivity() 
    {
        var currentTime = Math.floor(Date.now() / 1000);
        var lastActivity = <?php echo isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : 0; ?>;
        var inactiveTime = (currentTime - lastActivity) / 60;
        if (inactiveTime > 30) 
        {
            document.body.innerHTML = "<h1>Votre session est terminée.</h1><button onclick='window.location.href = \"index.html\";'>Se connecter</button><button onclick='window.location.href = \"deconnexion.php\";'>Se déconnecter</button>";
        }
    }
    </script>
    <footer class="footer mt-auto py-3 text-center">
        <div class="container">
            <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cookies</title>
    <style>
        .modal 
        {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content 
        {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            text-align: center;
        }
        .modal-content button 
        {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            background-color: #4caf50;
            color: white;
        }
        .cookie-img 
        {
            width: 50px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <img src="../projet/images/cookies.gif" alt="Cookie" class="cookie-img">
            <p>Ce site utilise des cookies et vous donne le contrôle sur ceux que vous souhaitez activer</p>
            <button id="accepter">Accepter</button>
            <button id="refuser">Refuser</button>
        </div>
    </div>
    <script>
        function setCookie(name, value, days)
        {
            var expiration = "";
            if (days) 
            {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expiration = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expiration + "; path=/";
        }
        function getCookie(name) 
        {
            var cookieName = name + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var cookieArray = decodedCookie.split(';');
            for (var i = 0; i < cookieArray.length; i++) 
            {
                var cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') 
                {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(cookieName) === 0) 
                {
                    return cookie.substring(cookieName.length, cookie.length);
                }
            }
            return "";
        }
        function demarrerCookies() 
        {
            var gestionCookies = getCookie("gestion_cookies");
            if (gestionCookies === "accepter") 
            {
                setCookie("gestion_cookies", "accepter", 30);
                window.location.href = 'demarrer_session.php';
            }
        }
        window.onload = function() 
        {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; 
        };
        document.getElementById("accepter").addEventListener("click", function() 
        {
            demarrerCookies(); 
            closeModal();
        });
        document.getElementById("refuser").addEventListener("click", function() 
        {
            setCookie("gestion_cookies", "refuser", 30); 
            closeModal();
        });
        function closeModal() 
        {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
</body>
</html>
