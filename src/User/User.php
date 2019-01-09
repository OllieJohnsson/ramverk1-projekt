<?php

namespace Oliver\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ActiveRecordModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
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



    public function gravatar(string $email, int $size = 60) : string
    {
        $rating = 'pg';
        $default = "https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png"; // Set a Default Avatar
        $email = md5(strtolower(trim($email)));
        $gravurl = "http://www.gravatar.com/avatar/$email?d=$default&s=200&r=$rating";
        return '<img style="width: '.$size.'px; height: '.$size.'px;" class="profile-image" src="'.$gravurl.'" width="{$size}" height="{$size}" border="0" alt="Avatar">';
    }


    public function findAllOrderByUsername(int $imageSize)
    {
        $this->checkDb();
        $users = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->orderby("username")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($users as $user) {
            $user->gravatar = $this->gravatar($user->email, $imageSize);
        }
        return $users;
    }


    public function findUser(int $id, int $imageSize = 60) : object
    {
        $user = $this->findAllWhere("id = ?", $id)[0];
        $user->gravatar = $this->gravatar($user->email, $imageSize);
        return $user;
    }


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }


    public function findMostActiveUsers(int $limit) : array
    {
        $this->checkDb();
        $users = $this->db->connect()
                        ->select("user.*, q.questions, a.answers, qc.questionComments, ac.answerComments")
                        ->from($this->tableName)
                        ->join("numberOfQuestions AS q", "q.userId = user.id")
                        ->join("numberOfAnswers AS a", "a.userId = user.id")
                        ->join("numberOfQuestionComments AS qc", "qc.userId = user.id")
                        ->join("numberOfAnswerComments AS ac", "ac.userId = user.id")
                        ->orderby("(q.questions + a.answers + qc.questionComments + ac.answerComments) desc")
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
        return $users;
    }
}
