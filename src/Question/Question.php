<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

// use Oliver\Question\Tag;
use Oliver\Question\Answer;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel
{
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

    private $tag;
    private $answer;

    public function __construct(Tag $tag = null, Answer $answer = null)
    {
        $this->tag = $tag;
        $this->answer = $answer;
    }


    public function getLastId()
    {
        return $this->db->lastInsertId();
    }


    public function findAllOrderByPosted()
    {
        $this->checkDb();
        $questions = $this->db->connect()
                        ->select("q.id as questionId, q.title, q.text, q.posted, u.id as userId, u.username, u.email, MAX(a.posted) as latestPosted")
                        ->from("$this->tableName as q")
                        ->leftJoin("answer as a", "a.questionId = q.id")
                        ->join("user as u", "u.id = q.userId")
                        ->groupby("q.id")
                        ->orderby("COALESCE(GREATEST(q.posted, MAX(a.posted)), q.posted) DESC")
                        ->execute()
                        ->fetchAllClass(get_class($this));
        foreach ($questions as $question) {
            $question->gravatar = gravatar($question->email);
            $question->latestAnswer = $this->answer->findLatest($question->questionId);
        }
        return $questions;
    }



    public function findQuestion($id)
    {
        $this->checkDb();
        $question = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join("user", "user.id = question.userId")
                        ->where("question.id = $id")
                        ->execute()
                        ->fetchAllClass(get_class($this))[0];

        $question->gravatar = gravatar($question->email);
        $question->tags = $this->tag->findTags($id);
        $question->comments = $this->getComments($id);

        return $question;
    }


    private function getComments(int $id)
    {
        return $this->db->connect()
                        ->select()
                        ->from('questionComment')
                        ->where("questionComment.questionId = $id")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }



    public function filter($tagId)
    {
        $this->checkDb();
        $questions = $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join("user", "user.id = question.userId")
                        ->join("questionTag", "questionTag.questionId = question.id")
                        ->join("tag", "tag.id = questionTag.tagId")
                        ->where("tag.id = $tagId")
                        ->execute()
                        ->fetchAllClass(get_class($this));

        foreach ($questions as $question) {
            $question->id = $question->questionId;
            $question->gravatar = gravatar($question->email);
        }
        return $questions;
    }
}
