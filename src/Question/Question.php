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
            $question->title = $this->di->get("textfilter")->doFilter($question->title, "markdown");
            $question->creator = $this->di->get("user")->findUser($question->userId);
            $question->latestAnswer = $this->di->get("answer")->findAnswers($question->id, 1, 35);
            $question->numberOfAnswers = $this->di->get("answer")->countAnswers($question->id);
        }
        return $questions;
    }



    public function findQuestion($questionId)
    {
        $question = $this->findById($questionId);
        $question->title = $this->di->get("textfilter")->doFilter($question->title, "markdown");
        $question->text = $this->di->get("textfilter")->doFilter($question->text, "markdown");
        $question->creator = $this->di->get("user")->findUser($question->userId);
        $question->tags = $this->di->get("tag")->findTagsForQuestion($questionId);
        $question->comments = $this->di->get("comment")->findComments("questionComment", $questionId);
        $question->answers = $this->di->get("answer")->findAnswers($questionId);

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
}
