<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use \Oliver\GravatarTrait;
    use \Oliver\MarkdownTrait;

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "answer";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $text;
    public $posted;
    public $questionId;
    public $userId;
    public $accepted;


    public function findAnswers(int $questionId) : array
    {
        $this->checkDb();
        $answers = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where("questionId = $questionId")
                        ->orderby("posted desc")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($answers as $answer) {
            $answer->text = $this->markdown($answer->text);
            $answer->creator = $this->di->get("user")->findUser($answer->userId);
            $answer->comments = $this->di->get("comment")->findComments("answerComment", $answer->id);
        }
        return $answers;
    }


    public function findLatest($questionId)
    {
        $this->checkDb();
        $answer = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where("questionId = $questionId")
                        ->orderby("posted desc")
                        ->limit(1)
                        ->execute()
                        ->fetchClass(get_class($this));
        if (!$answer) {
            return null;
        }
        $answer->creator = $this->di->get('user')->findUser($answer->userId);
        return $answer;
    }




    public function countAnswers(int $questionId)
    {
        return count($this->findAllWhere("questionId = ?", $questionId));
    }


    public function findAllByUser($userId)
    {
        return $this->findAllWhere("userId = ?", $userId);
    }


    public function acceptAnswer($answerId)
    {
        $answer = $this->findById($answerId);
        $answer->accepted = true;
        $answer->save();
    }

    public function countForUser(int $userId)
    {
        return count($this->findAllWhere("userId = ?", $userId));
    }
}
