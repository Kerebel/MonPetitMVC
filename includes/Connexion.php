<?php
namespace Tools;

use PDO;
class Connexion {

    private static $connexion = null;
    private static $connexionInstance = null;

    private function __construct() {
        try {
            $connect_str = CNSTRING;
            $connect_user = DATABASE_USER;
            $connect_pass = DATABASE_PWD;
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$connexion = new PDO($connect_str, $connect_user, $connect_pass, $options);
        } catch (PDOException $e) {
            throw new Exception('Erreur à la connexion <br>' . $e->getMessage());
        }
    }

    public static function getConnexion() {

        if (is_null(self::$connexionInstance)) {
            self::$connexionInstance = new Connexion();
        }

        return self::$connexion;
    }

}
