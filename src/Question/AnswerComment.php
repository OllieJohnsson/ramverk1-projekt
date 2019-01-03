<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\TextFilter\TextFilter;

/**
 * A database driven model using the Active Record design pattern.
 */
class AnswerComment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "answerComment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $text;
    public $posted;
    public $answerId;
    public $userId;


    public function findComments(int $answerId)
    {
        $this->checkDb();
        $comments = $this->db->connect()
                        ->select("ac.text, ac.posted, ac.userId, u.username")
                        ->from("$this->tableName AS ac")
                        ->join("user AS u", "u.id = ac.userId")
                        ->where("answerId = $answerId")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        $textFilter = new TextFilter();
        foreach ($comments as $comment) {
            $comment->text = $textFilter->doFilter($comment->text, ["markdown"]);
        }
        return $comments;
    }

}
