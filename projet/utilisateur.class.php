<?php
class utilisateur
{
    public $nom;
    public $prenom;
    public $username;
    public $pwd;
    public $tel;
    public $type;
    function getUser()
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="SELECT * FROM utilisateur WHERE nom='$this->nom'and pwd='$this->pwd'";
        $res=$pdo->query($req) or print_r($pdo->errorInfo()); 
        return $res;
    }
    function insertuser()
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="insert into utilisateur (nom, prenom, username, pwd, tel) values
        ('$this->nom','$this->prenom','$this->username','$this->pwd','$this->tel')";
        $pdo->exec($req) ;
    }
    function listclient()
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req=
        "SELECT * FROM utilisateur WHERE $type='client'";
        $res=$pdo->query($req);
        return $res;
    }
    function modifieruser($nom)
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="UPDATE utilisateur SET nom='$this->nom',prenom='$this->prenom',username='$this->username',pwd='$this->pwd',tel='$this->tel' WHERE nom=$nom";
        $pdo->exec($req) ;
    }
    function supprimeruser($nom)
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="DELETE FROM utilisateur WHERE nom=$nom";
        $pdo->exec($req);
    }
} 
?>
