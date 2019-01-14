<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "questionComment";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $text;
    public $posted;
    public $targetId;
    public $userId;


    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }


    public function findComments(string $tableName, int $targetId) : array
    {
        $this->tableName = $tableName;
        $comments = $this->findAllWhere("targetId = ?", $targetId);

        foreach ($comments as $comment) {
            $comment->text = $this->di->get("textfilter")->doFilter($comment->text, "markdown");
            $comment->creator = $this->di->get("user")->findUser($comment->userId, 30);
        }
        return $comments;
    }


    public function findAllByUser($userId)
    {
        return $this->findAllWhere("userId = ?", $userId);
    }

    public function countForUser(int $userId)
    {
        return count($this->findAllWhere("userId = ?", $userId));
    }
}
