<?php
namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use \Exception;

class GestionClientController {
    
    public function chercheUn($params) {
        //appel de la méthode find($id) de la classe Model adequate
        $modele = new GestionClientModel();
        $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $unClient = $modele->find($id);
        if ($unClient) {
            $r = new \ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) . "/unClient.php";
        } else {
            throw new Exception("Client " . $id . " inconnu");
        }
    }
}

