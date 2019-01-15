<?php

namespace Oliver\Rank;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Rank extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName;

    public function setTableName(string $type)
    {
        $this->tableName = "{$type}Rank";
    }


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $targetId;
    public $userId;
    public $rankScore;


    public function rank($targetId, $userId, $rank)
    {
        $this->targetId = $targetId;
        $this->userId = $userId;
        $this->rankScore = $rank;
        $this->save();
    }


    public function getRank(int $targetId)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select("COALESCE(SUM({$this->tableName}.rankScore), 0) AS rankScore")
                        ->from($this->tableName)
                        ->where("targetId = $targetId")
                        ->execute()
                        ->fetchClass(get_class($this))->rankScore;
    }



    public function didRankUp(int $userId, int $targetId)
    {
        return $this->findWhere("userId = ? and targetId = ?", [$userId, $targetId]) ? true : false;
    }

    public function didRankDown(int $userId)
    {
        return $this->findWhere("userId = ?", $userId) ? true : false;
    }
}
