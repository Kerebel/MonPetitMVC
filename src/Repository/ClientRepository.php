<?php

namespace APP\Repository;
use Tools\Repository;

class ClientRepository extends Repository {
    public function __construct($entity) {
        parent::__construct($entity);
    }
    
    public function statistiquesTousClients(){
        $sql = "SELECT client.id as id, prenomCli as prenom, nomCli as nom, villeCli as ville, count(commande.id) "
                . "as nbCommande from client left join "
                . "commande on client.id = commande.idClient "
                . "group by client.id" ;
        return $this->executeSQL($sql);
    }
}

