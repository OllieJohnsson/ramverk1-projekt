<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use \Oliver\GravatarTrait;
    use \Oliver\MarkdownTrait;
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "question";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $text;
    public $posted;
    public $userId;


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }


    public function findAllOrderByPosted()
    {
        $this->checkDb();
        $questions = $this->db->connect()
                        ->select("q.id, q.title, q.text, q.posted, q.userId, MAX(a.posted)")
                        ->from("$this->tableName as q")
                        ->leftJoin("answer as a", "a.questionId = q.id")
                        ->groupby("q.id")
                        ->orderby("COALESCE(GREATEST(q.posted, MAX(a.posted)), q.posted) DESC")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($questions as $question) {
            $question->creator = $this->di->get("user")->findUser($question->userId);
            $question->text = $this->markdown($question->text);
            $question->numberOfAnswers = $this->di->get("answer")->countAnswers($question->id);
        }
        return $questions;
    }



    public function findQuestion($questionId)
    {
        $question = $this->findById($questionId);
        $question->text = $this->markdown($question->text);
        $question->creator = $this->di->get("user")->findUser($question->userId);
        $question->tags = $this->di->get("tag")->findTagsForQuestion($questionId);
        $question->comments = $this->di->get("comment")->findComments("questionComment", $questionId);
        $question->answers = $this->di->get("answer")->findAnswers($questionId);

        $rank = new \Oliver\Rank\Rank();
        $rank->setDb($this->di->get('dbqb'));
        $rank->setTableName("question");
        $question->rank = $rank;
        $question->rankScore = $rank->getRank($question->id) ?: 0;

        return $question;
    }



    public function findAllWithTag($tagId)
    {
        $this->checkDb();
        $questions = $this->db->connect()
                        ->select("q.id, q.title, q.text, q.posted, q.userId, MAX(a.posted)")
                        ->from("$this->tableName as q")
                        ->leftJoin("answer as a", "a.questionId = q.id")
                        ->join("questionTag", "questionTag.questionId = q.id")
                        ->join("tag", "tag.id = questionTag.tagId")
                        ->where("tag.id = $tagId")
                        ->groupby("q.id")
                        ->orderby("COALESCE(GREATEST(q.posted, MAX(a.posted)), q.posted) DESC")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($questions as $question) {
            $question->creator = $this->di->get("user")->findUser($question->userId);
            $question->latestAnswer = $this->di->get("answer")->findAnswers($question->id, 1, 35);
            $question->numberOfAnswers = $this->di->get("answer")->countAnswers($question->id);
        }
        return $questions;
    }


    public function findAllByUser($userId)
    {
        return $this->findAllWhere("userId = ?", $userId);
    }


    public function findLatestQuestions(int $limit) : array
    {
        $this->checkDb();
        $questions = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->orderby("posted desc")
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($questions as $question) {
            $question->creator = $this->di->get('user')->findUser($question->userId, 35);
        }
        return $questions;
    }


    public function countForUser(int $userId)
    {
        return count($this->findAllWhere("userId = ?", $userId));
    }

    public function isAccepted()
    {
        $answers = $this->di->get('answer')->findAnswers($this->id);
        foreach ($answers as $answer) {
            if ($answer->accepted) {
                return true;
            }
        }
        return false;
    }
}
