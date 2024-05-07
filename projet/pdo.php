<?php
class connexion
{
public function CNXbase()
{
$dbc=new PDO('mysql:host=localhost;dbname=vente_en_ligne','root','');
return $dbc;
}
}
?>