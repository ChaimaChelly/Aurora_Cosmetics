<?php
class produit
{
    public $id;
    public $nom_p;
    public $prix;
    public $qte;
    public $categorie;
    public $photo;
    function insertproduit()
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="insert into produit (id, nom_p, prix, qte, categorie, photo) values
        ('$this->id','$this->nom_p','$this->prix','$this->qte','$this->categorie','$this->photo')";
        $pdo->exec($req) ;
    }
    function listproduit()
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req=
        "SELECT * FROM produit ";
        $res=$pdo->query($req);
        return $res;
    }
    function modifierproduit($id)
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="UPDATE produit SET nom_p='$this->nom_p',prix='$this->prix',qte='$this->qte',categorie='$this->categorie',photo='$this->photo' WHERE id=$id";
        $pdo->exec($req) ;
    }
    function supprimerproduit($id)
    {
        require_once('pdo.php');
        $cnx=new connexion();
        $pdo=$cnx->CNXbase();
        $req="DELETE FROM produit WHERE id=$id";
        $pdo->exec($req);
    }
} 
?>
