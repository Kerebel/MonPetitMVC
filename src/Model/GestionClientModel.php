<?php
namespace APP\Model;

use \PDO;
use APP\Entity\Client;
use Tools\Connexion;

class GestionClientModel {
    
    public function find($id){
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from CLIENT where id=:id";
        $ligne = $unObjetPdo->prepare($sql);
        $ligne->bindValue(':id', $id, PDO::PARAM_INT);
        $ligne->execute();
        return $ligne->fetchObject(Client::class);
    }
}

