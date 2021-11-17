<?php
namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use \Exception;
use Tools\MyTwig;
use APP\Entity\Client;
use Tools\Repository;


class GestionClientController {
    
    public function chercheUn($params) {
        //appel de la méthode find($id) de la classe Model adequate
        $repository= Repository::getRepository("APP\Entity\Client");
        // dans tous les cas on récupère les Ids des clients
        $ids = $repository->findIds();
        // on place ces Ids dans le tableau de paramètres que l'on va envoyer à la rue
        $params['lesId']=$ids;
        // on teste si l'id du client à chercher a été passé dans l'URL
        if (array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $unClient = $repository->find($id);
        // on place le client trouvé dans le tableau de paramètres que l'on va envoyer à la vue
        $params['unClient']=$unClient;
        }
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClient.html.twig";
        MyTwig::afficheVue($vue, $params);
        // include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/unClient.php";
        //} else {
        //    throw new Exception("Client " . $id . " inconnu");
        //}
    }
    
    public function chercheTous(){
        // instanciation du repository
        $repository= Repository::getRepository("APP\Entity\Client");
        $clients = $repository->findAll();
        if ($clients){
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
            MyTwig::afficheVue($vue, array('clients' => $clients));
            // include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.php";
        } else {
            throw new Exception("Aucun client à afficher");
        }
    }
    
    public function creerClient($params){
        if (empty($params)) {
            $vue = "GestionClientView\\creerClient.html.twig";
            MyTwig::afficheVue($vue, array());
        } 
        else{
            $params= filter_var_array($params);
            // création de l'objet client
            $client = new Client($params);
            $repository = Repository::getRepository("APP\Entity\Client");
            $repository->insert($client);
            $this->chercheTous();
        }
    }
    
    public function enregistreClient($params) {
        // création de l'objet client
        $client = new Client($params);
        $modele = new GestionClientModel();
        $modele->enregistreClient($client);
    }
    
    public function nbClients($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        $nbClients = $repository->countRows();
        echo "nombre de clients : " . $nbClients;
    }
}

