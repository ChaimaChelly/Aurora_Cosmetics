<!DOCTYPE html>
<?php
  session_start();
  require_once('pdo.php');
  $cnx = new connexion();
  $pdo = $cnx->CNXbase();
  $nom= $_SESSION['nom'];
  $req = "SELECT * FROM utilisateur WHERE nom = :nom";
  $stmt = $pdo->prepare($req);
  $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC); 
?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body, html {
      height: 100%;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
    }
    * {
      box-sizing: border-box;
    }
    .bg-img {
      background-image: url("images/fond.jpg");
      min-height: 100vh; 
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      display: flex;
    }
    .container {
      margin: auto; 
      margin-left: auto;
      margin-right: 160px; 
      padding: 16px;
      background-color: white;
      max-width: 300px;
      width: 100%; 
    }
    input[type=text], input[type=password], input[type=file], input[type=tel] {
      width: calc(100% - 10px); 
      padding: 10px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;
    }
    input[type=text]:focus, input[type=password]:focus, input[type=file]:focus, input[type=tel]:focus {
      background-color: #ddd;
      outline: none;
    }
    .btn {
      background-color: #04AA6D;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }
    .btn:hover {
      opacity: 1;
    }
    .profile-pic {
      margin: auto; 
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
    }
    .profile-pic img {
      width: 100%; 
      height: 100%; 
      object-fit: cover; 
    }
  </style>
</head>
<body>
  <div class="bg-img">
    <div class="container">
      <h1>Modifier Profil</h1>
      <form action="modifier_profile.php" method="POST">
        <label for="nom"><b>Nom:</b></label>
        <input type="text" id="nom" name="nom" placeholder="Nom" required value="<?php echo ($user['nom']); ?>"><br>
        <label for="prenom"><b>Prénom:</b></label>
        <input type="text" id="prenom" name="prenom" placeholder="Prénom" required value="<?php echo ($user['prenom']); ?>"><br>
        <label for="username"><b>Nom d'utilisateur:</b></label>
        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" disabled required  value="<?php echo ($user['username']); ?>"><br>
        <label for="tel"><b>Téléphone:</b></label>
        <input type="tel" id="tel" name="tel" placeholder="Téléphone" required value="<?php echo ($user['tel']); ?>"><br>
        <label for="pwd"><b>Mot de passe:</b></label>
        <input type="password" id="pwd" name="pwd" placeholder="Mot de passe" required><br>
        <input type="submit" value="Enregistrer les modifications" class="btn">
      </form>
    </div>
  </div>
</body>
</html>
