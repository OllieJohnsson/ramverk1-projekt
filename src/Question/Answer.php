<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
    use \Oliver\GravatarTrait;

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

    private $textFilter;
    private $rank;
    private $user;
    private $comment;

    public function init($textFilter, $rank, $user, $comment)
    {
        $this->textFilter = $textFilter;
        $this->rank = $rank;
        $this->user = $user;
        $this->comment = $comment;
    }

    public function findAnswers(int $questionId) : array
    {
        $this->checkDb();
        $answers = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where("questionId = $questionId")
                        ->orderby("posted asc")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($answers as $answer) {
            $answer->text = $this->textFilter->doFilter($answer->text, "markdown");
            $answer->creator = $this->user->findUser($answer->userId);
            $answer->comments = $this->comment->findComments("answerComment", $answer->id);
            $answer->rankScore = $this->rank->getRank($answer->id) ?: 0;
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
        $answer->creator = $this->user->findUser($answer->userId);
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
