<?php
namespace APP\Controller;

use APP\Model\GestionCommandeModel;
use ReflectionClass;
use \Exception;
use Tools\MyTwig;
use Tools\Repository;

class GestionCommandeController {
    
    public function chercheUne($params) {
        
        $modele = new GestionCommandeModel();
        $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $uneCommande = $modele->find($id);
        if($uneCommande){
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/uneCommande.php"; # "GestionCommandeController/uneCommande.php" => "GestionCommandeView/uneCommande.php"
        } else {
            throw new Exception("Commande " . $id . " introuvable");
        }
    }
    
    public function chercheToutes(){
        $modele = new GestionCommandeModel();
        $commandes = $modele->findAll();
        if ($commandes) {
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursCommandes.php";
        } else {
            throw new Exception("Aucune commande à afficher");
        }
    }
    
    public function commandesUnClient($params){
       /* PREMIERE VERSION PARTIE 2
        $modele = new GestionCommandeModel();
        $params = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $commandes = $modele->findCommandsByClient($params);
        if($commandes){
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/commandesParClient.html.twig";
            MyTwig::afficheVue($vue, array('commandes' => $commandes));
        } else {
            throw new Exception("Aucune commande à afficher"); */
        $repositoryCommande = Repository::getRepository("APP\Entity\Commande");
        $repositoryClient = Repository::getRepository("APP\Entity\Client");
        $params = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $commandes = $repositoryCommande->findCommandsByClient($params);
        $client = $repositoryClient->find($params);
        if($commandes){
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/commandesParClient.html.twig";
            $array = array(
                'commandes' => $commandes,
                'client' => $client);
            MyTwig::afficheVue($vue,$array); 
        } else {
            throw new Exception("Aucune commande à afficher");
        }
    }
}