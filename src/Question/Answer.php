<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

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


    public function findAnswers(int $questionId)
    {
        $this->checkDb();
        $answers = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join("user", "user.id = answer.userId")
                        ->where("questionId = $questionId")
                        ->execute()
                        ->fetchAllClass(get_class($this));



        foreach ($answers as $answer) {
            $answer->gravatar = gravatar($answer->email);
            $answer->comments = $this->answerComment->findAllWhere("answerId = ?", $answer->id);
        }
        return $answers;
    }

}
