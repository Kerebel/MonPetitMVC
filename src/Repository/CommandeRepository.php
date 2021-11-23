<?php

namespace APP\Repository;
use Tools\Repository;
use Tools\Connexion;
use PDO;
use APP\Entity\Commande;

class CommandeRepository extends Repository {
    public function __construct($entity) {
        parent::__construct($entity);
    }
    
    public function findCommandsByClient($idClient){
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from " . $this->table . " where idClient= :idClient";
        $ligne = $unObjetPdo->prepare($sql);
        $ligne->bindValue(':idClient', $idClient, PDO::PARAM_INT);
        $ligne->execute();
        return $ligne->fetchAll(PDO::FETCH_CLASS, Commande::class);
    }
}

