<?php

namespace Tools;

use Tools\Connexion;
use PDO;

class Repository {
    
    private $classeNameLong;
    private $classeNamespace;
    private $table;
    private $connexion;
   
    public function __construct(string $entity) {
        $tablo = explode("\\", $entity);
        $this->table = array_pop($tablo);
        $this->classeNamespace = implode("\\", $tablo);
        $this->classeNameLong = $entity;
        $this->connexion = Connexion::getConnexion();
    }
    
    public static function getRepository($entity) {
        $repositoryName = str_replace('Entity', 'Repository', $entity) . 'Repository';
        $repository = new $repositoryName($entity);
        return $repository;
    }
    
    public function findAll() {
        $sql = "select * from " . $this->table;
        $lignes = $this->connexion->query($sql);
        $lignes->setFetchMode(PDO::FETCH_CLASS, $this->classeNameLong, null);
        return $lignes->fetchAll();
    }
    
    public function find($id) {
        $sql = "select * from " . $this->table . " where id=:id";
        $ligne = $this->connexion->prepare($sql);
        $ligne->bindValue(':id', $id, PDO::PARAM_INT);
        $ligne->execute();
        return $ligne->fetchObject($this->classeNameLong);
        return self::pdo_debugStrParams($ligne);
    }
    
    public function findIds() {
        $sql = "select id from " . $this->table;
        $lignes = $this->connexion->query($sql);
        $ids = $lignes->fetchAll(PDO::FETCH_ASSOC);
        return $ids;
    }
    
    public function insert($objet){
        //conversion d'un objet en tableau
        $attributs = (array) $objet;
        array_shift($attributs);
        $colonnes = "(";
        $colonnesParams = "(";
        $parametres = array();
        foreach($attributs as $cle => $valeur) {
            $cle = str_replace("\0", "", $cle);
            $c = str_replace($this->classeNameLong, "", $cle);
            $p = ":" . $c;
            if ($c != "id"){
                $colonnes .= $c ." ,";
                $colonnesParams .= " ? ,";
                $parametres[] = $valeur;
            }
        }
        $colonnes = substr($colonnes, 0, -1);
        $colonnesParams = substr($colonnesParams, 0 , -1);
        $sql = "insert into " . $this->table . " " . $colonnes . ") values " . $colonnesParams . ")";
        $unObjetPDO = Connexion::getConnexion();
        $req = $unObjetPDO->prepare($sql);
        $req->execute($parametres);
    }
    
    public function countRows(){
       $sql = "select count(*) AS total from " . $this->table;
       $req = $this->connexion->query($sql);
       $res = $req->fetch(PDO::FETCH_ASSOC);
       $nb = $res['total'];
       return $nb;
    }
    
    public function __call($methode, $params) {
        if (preg_match("#^findBy#", $methode)) {
            return $this->traiteFindBy($methode, array_values($params[0]));
        }
    }
    
    private function traiteFindBy($methode, $params) {
        $criteres = str_replace("findBy", "", $methode);
        $criteres = explode("_and_", $criteres);
        if (count($criteres) > 0) {
            $sql = 'select * from ' . $this->table . " where ";
            $pasPremier = false;
            foreach($criteres as $critere){
                if ($pasPremier) {
                    $sql .= ' and ';
                }
                $sql .= $critere . " = ? ";
                $pasPremier = true;
            }
            $lignes = $this->connexion->prepare($sql);
            $lignes->execute($params);
            $lignes->setFetchMode(PDO::FETCH_CLASS, $this->classeNameLong, null);
            return $lignes->fetchAll();
        }      
    }
    
    public function findColumnDistinctValues($colonne){
        $sql = "select distinct " . $colonne . " libelle from " . $this->table . " order by 1";
        //return $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $tab = $this->connexion->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        return $tab;
    }
}

