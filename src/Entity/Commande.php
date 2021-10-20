<?php
namespace APP\Entity;

/**
 * Description of Commande
 *
 * @author ploick
 */
class Commande {
    private $id;
    private $idClient;
    private $dateCde;
    private $noFacture;

    public function __construct($params = null) {
        if (!is_null($params)) {
            foreach ($params as $cle => $valeur) {
                if(strlen($valeur)>0){
                $this->$cle = $valeur;
                } else{
                     $this->$cle = null;
                }
            }
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function getIdClient() {
        return $this->idClient;
    }

    public function getDateCde() {
        return $this->dateCde;
    }

    public function getNoFacture() {
        return $this->noFacture;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdClient($idClient) {
        $this->idClient = $idClient;
    }

    public function setDateCde($dateCde) {
        $this->dateCde = $dateCde;
    }

    public function setNoFacture($noFacture) {
        $this->noFacture = $noFacture;
    }
}
