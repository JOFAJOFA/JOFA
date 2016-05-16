<?php

class Db extends PDO
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            require_once('../dbconfig.php');
            if (isset($dbname) AND isset($dbuser) AND isset($dbpassword)) {
                self::$instance = new Db ('mysql:host=localhost;dbname=' . $dbname, $dbuser, $dbpassword, $pdo_options);
            } else die ('A valid database configuration was not found!');
        }
        return self::$instance;
    }

    public function loadUserNameByID($userID)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE ID=?");
        $sth->execute(array($userID));
        $userName = $sth->fetchColumn(3);
        return $userName;
    }

    public function loadUserByID($userID)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE ID=?");
        $sth->execute(array($userID));
        $userName = $sth->fetchColumn(3);
        return $userName;
    }

    public function loadUserByEmail($userEmail)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE EMAIL=?");
        $sth->execute(array($userEmail));
        $userName = $sth->fetchColumn(3);
        return $userName;
    }

    public function createUser($email, $password, $username)
    {
        $id = $this->generateUserID();
        $hashed_password = $this->hash_password($password);
        $active = 1;

        $statement = $this->prepare("INSERT INTO user(ID, EMAIL, PASSWORD, USERNAME, ACTIVE)
    VALUES(?, ?, ?, ?, ?)");
        $statement->execute(array($id, $email, $hashed_password, $username, $active));
    }

    function hash_password($plainpw){
        $options = [
            'cost' => 12,
        ];
        $hashed_password = password_hash($plainpw, PASSWORD_BCRYPT, $options) . "\n";
        return $hashed_password;
    }

    function generateUserID()
    {
        return trim($this->generateGUID(), '{}');
    }

    function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);// "}"
            return $uuid;
        }
    }

    function login($email, $password)
    {
        $this->loadUserByEmail($email);
        echo USERNAME;
    }
}

?>