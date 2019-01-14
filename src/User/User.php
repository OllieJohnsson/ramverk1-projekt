<?php

namespace Oliver\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use \Oliver\GravatarTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ActiveRecordModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
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
        return $this->findById($id);
    }


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }


    public function findMostActiveUsers(int $limit) : array
    {
        $users = $this->findAll();

        $questionComments = $this->di->get('comment');
        $questionComments->setTableName("questionComment");

        $answerComments = $this->di->get('comment');
        $answerComments->setTableName("answerComment");

        foreach ($users as $user) {
            $user->noQuestions = $this->di->get('question')->countForUser($user->id);
            $user->noAnswers = $this->di->get('answer')->countForUser($user->id);
            $user->noComments = $questionComments->countForUser($user->id) + $answerComments->countForUser($user->id);
        }

        usort($users, function ($first, $second) {
            $sumFirst = $first->noQuestions + $first->noAnswers + $first->noComments;
            $sumSecond = $second->noQuestions + $second->noAnswers + $second->noComments;
            return $sumSecond <=> $sumFirst;
        });

        return array_slice($users, 0, $limit);
    }
}
