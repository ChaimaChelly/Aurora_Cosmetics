<?php
class commande
{
    public $product_id;
    public $user_id;
    public $quantity;
    public $price;
    public $status;
    function insertOrderItem()
    {
        require_once ('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $req = "insert into commande (product_id,user_id,quantity,price, status) values
        ('$this->product_id','$this->user_id','$this->quantity','$this->price', '$this->status')";
        $pdo->exec($req) ;
    }

    function updateOrderItem($id)
    {
        require_once ('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $req = "UPDATE commande SET product_id='$this->product_id',user_id='$this->user_id',quantity='$this->quantity',price='$this->price', status='$this->status' WHERE ID=$id";
        $pdo->exec($req) ;
    }

    function removeOrderItem($id)
    {
        require_once ('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $req = "DELETE FROM commande WHERE ID = $id";
        $pdo->exec($req) ;
    }
    function listOrderItems()
    {
        require_once ('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $req = "SELECT * FROM commande";
        $res = $pdo->query($req) ;
        return $res;
    }

    function getNumberOfOrderItems()
    {
        require_once ('pdo.php');
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();
        $req = "SELECT COUNT(*) FROM commande";
        $res = $pdo->query($req) ;
        return $res;
    }

}

