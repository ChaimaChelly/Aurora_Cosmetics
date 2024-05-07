<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un client</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body 
        {
            background-color: #ffe4e1; 
            margin: 0;
            padding: 0;
        }
        .container 
        {
            padding: 20px;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #fff; 
            border-radius: 10px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
        }
        h1 
        {
            text-align: center;
            margin-bottom: 30px;
        }
        label 
        {
            font-weight: bold;
        }
        .form-control 
        {
            border-color: #ff3e6c; 
        }
        input[type="submit"] 
        {
            background-color: #ff3e6c; 
            border-color: #ff3e6c; 
            color: #fff; 
        }
        input[type="submit"]:hover 
        {
            background-color: #ff5d8f; 
            border-color: #ff5d8f; 
        }
        .navbar
        {
            background-color: #ffe4e1; 
            margin: 0;
            padding: 0;
        }
        .btn-container 
        {
            text-align: center;
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            require_once('pdo.php');
            require_once('utilisateur.class.php');
            $utilisateur = new utilisateur();
            $utilisateur->nom = $_POST['nom'];
            $utilisateur->prenom = $_POST['prenom'];
            $utilisateur->username = $_POST['username'];
            $utilisateur->pwd = $_POST['pwd'];
            $utilisateur->tel = $_POST['tel'];
            $utilisateur->type = 'client'; 
            $utilisateur->insertuser();
            echo "<p>Client ajouté avec succès!</p>";
        }
        ?>
        <h1>Ajouter un client</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="pwd">Mot de passe:</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
            </div>
            <div class="form-group">
                <label for="tel">Téléphone:</label>
                <input type="text" class="form-control" id="tel" name="tel" required>
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
