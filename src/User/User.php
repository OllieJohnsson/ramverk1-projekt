<?php

namespace Oliver\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use \Oliver\GravatarTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
// class User extends ActiveRecordModel implements ContainerInjectableInterface
class User extends ActiveRecordModel
{
    use GravatarTrait;
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "user";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $username;
    public $email;
    public $firstName;
    public $lastName;
    public $password;


    /**
    * Set the password.
    *
    * @param string $password the password to use.
    *
    * @return void
    */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }


    /**
    * Verify the acronym and the password, if successful the object contains
    * all details from the database row.
    *
    * @param string $acronym  acronym to check.
    * @param string $password the password to use.
    *
    * @return boolean true if acronym and password matches, else false.
    */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }



    public function findAllOrderByUsername()
    {
        $this->checkDb();
        $users = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->orderby("username")
                        ->execute()
                        ->fetchAllClass(get_class($this));
        return $users;
    }


    public function findUser(int $id) : object
    {
        return $this->findAllWhere("id = ?", $id)[0];
    }


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }

    public function findLimit(int $limit)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));

    }
}
