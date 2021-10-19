<?php
define('DS', DIRECTORY_SEPARATOR);
define('RACINE', new DirectoryIterator(dirname(__FILE__)) . DS . ".." . DS);
include_once(RACINE . DS . 'config/conf.php');
require PATH_VENDOR . "autoload.php";
$BaseController = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING);
try {
    if (empty($BaseController)) {
        $BaseController = 'Identification';
        $action = 'login';
    }
    $controller = "APP\Controller\\" . $BaseController . 'Controller';
    
    $c = new $controller();
    $params = array(array_slice($_REQUEST, 2));
    call_user_func_array(array($c, $action), $params);
} catch (Exception $ex) {
    echo $ex->getMessage();
    //$vue=
    //$params= array(...)
   //include PATH_VIEW . '$BaseController'errors/ . 'View' . DS . 'unClient.php';
}
?>
