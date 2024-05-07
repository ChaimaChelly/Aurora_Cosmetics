<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe4e1; 
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #fff; 
            border-radius: 10px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            border-color: #ff3e6c; 
        }
        input[type="submit"] {
            background-color: #ff3e6c; 
            border-color: #ff3e6c; 
            color: #fff; 
        }
        input[type="submit"]:hover {
            background-color: #ff5d8f; 
            border-color: #ff5d8f; 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        if(isset($_SESSION["nom"])) 
        {
            if(isset($_GET['id'])) 
            {
                require_once('pdo.php');
                $cnx = new connexion();
                $pdo = $cnx->CNXbase();
                $id = $_GET['id'];
                $requete = $pdo->prepare("SELECT * FROM produit WHERE id = :id");
                $requete->bindParam(':id', $id);
                $requete->execute();
                $produit = $requete->fetch(PDO::FETCH_ASSOC);
                if($produit) 
                {
                    if($_SERVER['REQUEST_METHOD'] == 'POST') 
                    {
                        $nom_p = $_POST['nom_p'];
                        $prix = $_POST['prix'];
                        $qte = $_POST['qte'];
                        $categorie = $_POST['categorie'];
                        $photo = $_POST['photo']; 
                        $requete_update = $pdo->prepare("UPDATE produit SET nom_p = :nom_p, prix = :prix, qte = :qte, categorie = :categorie WHERE id = :id");
                        $requete_update->bindParam(':id', $id);
                        $requete_update->bindParam(':nom_p', $nom_p);
                        $requete_update->bindParam(':prix', $prix);
                        $requete_update->bindParam(':qte', $qte);
                        $requete_update->bindParam(':categorie', $categorie);
                        $requete_update->execute();
                        header("Location: accueiladmin.php");
                        exit();
                    }
        ?>
        <h1>Modifier un produit</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nom_p">Nom du produit:</label>
                <input type="text" class="form-control" id="nom_p" name="nom_p" value="<?php echo $produit['nom_p']; ?>">
            </div>
            <div class="form-group">
                <label for="prix">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?php echo $produit['prix']; ?>">
            </div>
            <div class="form-group">
                <label for="qte">Quantité:</label>
                <input type="text" class="form-control" id="qte" name="qte" value="<?php echo $produit['qte']; ?>">
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <input type="text" class="form-control" id="categorie" name="categorie" value="<?php echo $produit['categorie']; ?>">
            </div>
            <input type="submit" class="btn btn-primary" value="Modifier">
        </form>
        <?php
                } 
                else 
                {
                    echo "Aucun produit trouvé avec cet identifiant.";
                }
            } 
            else 
            {
                echo "L'identifiant du produit n'est pas spécifié.";
            }
        } 
        else 
        {
            echo "Vous n'êtes pas connecté.";
        }
        ?>
    </div>
</body>
</html>
