<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "tag";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }


    public function findTagsForQuestion($questionId)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select("id, name")
                        ->from($this->tableName)
                        ->join("questionTag", "questionTag.tagId = tag.id")
                        ->where("questionTag.questionId = $questionId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


    public function getName($id)
    {
        return $this->findById($id)->name;
    }


    public function findMostPopularTags(int $limit) : array
    {
        $this->checkDb();
        $tags = $this->db->connect()
                        ->select("id, name, COUNT(name) as amount")
                        ->from($this->tableName)
                        ->join("questionTag", "questionTag.tagId = id")
                        ->orderby("amount desc")
                        ->groupby("name")
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
        return $tags;
    }

}
