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


    public function findAnswers(int $questionId, int $limit = 0, int $gravatarSize = 60) : array
    {
        $answers = $this->findAllWhere("questionId = ?", $questionId);

        if (count($answers) === 0) {
            return [];
        }

        foreach ($answers as $answer) {
            $answer->text = $this->di->get("textfilter")->doFilter($answer->text, "markdown");
            $answer->creator = $this->di->get("user")->findUser($answer->userId, $gravatarSize);
            $answer->comments = $this->di->get("comment")->findComments("answerComment", $answer->id);
        }

        if ($limit === 1) {
            return array_slice($answers, -$limit);
        }
        if ($limit > 0) {
            return array_slice($answers, -$limit);
        }
        return $answers;
    }


    public function countAnswers(int $questionId)
    {
        return count($this->findAllWhere("questionId = ?", $questionId));
    }


    public function findAllByUser($userId)
    {
        return $this->findAllWhere("userId = ?", $userId);
    }

}
