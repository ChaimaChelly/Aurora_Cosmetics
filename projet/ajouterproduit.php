<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
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
        input[type="submit"], .custom-file-upload {
            background-color: #ff3e6c;
            border-color: #ff3e6c;
            color: #fff;
            display: inline-block;
            cursor: pointer;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        input[type="submit"]:hover, .custom-file-upload:hover {
            background-color: #ff5d8f;
            border-color: #ff5d8f;
        }
        .navbar {
            background-color: #ffe4e1;
            margin: 0;
            padding: 0;
        }
        .btn-container {
            text-align: center;
        }
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="../projet/images/logo.png" alt="Logo Aurora Cosmetics" style="width: 50px; height: 50px; border-radius: 50%;"> AURORA COSMETICS</a>
            </div>
        </nav>   
    </header>
    <div class="container">
    <?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('pdo.php');
    require_once('produit.class.php');
    
    $produit = new produit();
    $produit->id = $_POST['id'];
    $produit->nom_p = $_POST['nom_p'];
    $produit->prix = $_POST['prix'];
    $produit->qte = $_POST['qte'];
    $produit->categorie = $_POST['categorie'];
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) 
    {
        $image_info = getimagesize($_FILES['photo']['tmp_name']);
        if($image_info !== false) 
        {
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $extension_upload = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            if(in_array($extension_upload, $extensions_valides)) 
            {
                $target_dir = "images/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) 
                {
                    $produit->photo = basename($_FILES["photo"]["name"]);
                    $produit->insertproduit();
                    echo "<p>Produit ajouté avec succès!</p>";
                } 
                else 
                {
                    echo "<p>Erreur lors de l'upload de l'image.</p>";
                }
            } 
            else 
            {
                echo "<p>Extension de fichier non autorisée.</p>";
            }
        } 
        else 
        {
            echo "<p>Le fichier n'est pas une image valide.</p>";
        }
    } 
    else 
    {
        echo "<p>Aucune image n'a été téléchargée.</p>";
    }
}
?>
        <h1>Ajouter un produit</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="nom_p">Nom du produit:</label>
                <input type="text" class="form-control" id="nom_p" name="nom_p" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="qte">Quantité:</label>
                <input type="text" class="form-control" id="qte" name="qte" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <input type="text" class="form-control" id="categorie" name="categorie" required>
            </div>
            <div class="form-group">
                <label class="custom-file-upload">
                    Choisir un fichier
                    <input type="file" name="photo" accept="image/*">
                </label>
            </div>
            <div class="btn-container"> 
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </div>
        </form>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 AURORA COSMETICS. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
