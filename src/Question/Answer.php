<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\TextFilter\TextFilter;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
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

    private $answerComment;

    public function __construct(AnswerComment $answerComment = null)
    {

        $this->answerComment = $answerComment;
    }


    private function prepareAnswers(array $answers)
    {
        foreach ($answers as $answer) {
            $answer->gravatar = gravatar($answer->email);
            $answer->comments = $this->answerComment ? $this->answerComment->findComments($answer->id) : null;

            $textFilter = new TextFilter();
            $answer->text = $textFilter->doFilter($answer->text, ["markdown"]);
        }
        return $answers;
    }


    public function findAnswers(int $questionId)
    {
        $this->checkDb();
        $answers = $this->db->connect()
                        ->select("a.id, a.text, a.posted, a.questionId, a.userId, u.username, u.email")
                        ->from("$this->tableName AS a")
                        ->join("user AS u", "u.id = a.userId")
                        ->where("questionId = $questionId")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        return $this->prepareAnswers($answers);
    }


    public function findLatest(int $questionId)
    {
        $this->checkDb();
        $answer = $this->db->connect()
                        ->select("a.id, a.text, a.posted, a.questionId, a.userId, u.username, u.email")
                        ->from("$this->tableName AS a")
                        ->join("user AS u", "u.id = a.userId")
                        ->limit("1")
                        ->where("a.questionId = $questionId")
                        ->orderby("a.posted desc")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        // return $this->prepareAnswers($answer);
        return count($answer) > 0 ? $answer[0] : null;
    }

}
