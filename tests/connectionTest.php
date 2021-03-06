<?php

require('../src/connection.php');
require('../src/models/user.php');
require('../src/ini.php');

/**
 * Deprecated file, it was used to test datbase usage
 */
class connectionTest extends PHPUnit_Framework_TestCase
{
    private $db;
    private $generatedID = 'B8733B41-BF8C-465B-99E9-A45AE784065A';

    protected function setUp()
    {
        $this->db = Db::getInstance();
    }

    protected function tearDown()
    {
        $this->db = NULL;
    }

    public function testCreateUser()
    {
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $temp = $this->db->createUser($email, $password, $username, $active);
        echo $temp;
        $this->generatedID = $temp;
        echo $this->generatedID;
        $this->assertEquals('steve', $this->db->loadUserNameByID($this->generatedID));
    }

    public function testLoadUserByEmail()
    {
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $exp_user = new User($this->generatedID, $email, $password, $username, $active);
        $act_user = $this->db->loadUserByEmail('spam@spam.spam');
        $this->assertEquals($exp_user->getId(), $act_user->getId());
    }

    public function testDeleteUserByID()
    {
        $this->db->deleteUserByID($this->generatedID);
        $this->db->loadUserByID($this->generatedID);
    }
}
