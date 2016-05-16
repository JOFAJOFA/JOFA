<?php

require_once('models/user.php');

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 12:19 PM
 */
class UsersController
{
    //post only
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return error();
        }

        $db = Db::getInstance();
        $email = $_POST["email"];
        $password = $_POST["password"];
        $username = $_POST["username"];
        $db->createUser($email, $password, $username);
        echo '<script>alert("very registered");</script>';
    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $db = Db::getInstance();
        $user = $db->login($email, $password);
        if ($user) {
            $_SESSION[USER] = $user;
            header('location:?controller=users&action=home', true);
        } else echo 'no good';
    }

    public function logout()
    {
        session_destroy();
        echo 'bb kind prince';
    }

    public function home()
    {
        require('views/users/home.php');
    }

    public function invalidLoginInfo()
    {
        require('views/users/invalid.html');
    }
    public function error()
    {
        require('views/pages/error.php');
    }
}