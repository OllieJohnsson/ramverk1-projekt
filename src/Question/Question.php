<?php

namespace Oliver\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
// class Question extends ActiveRecordModel implements ContainerInjectableInterface
class Question extends ActiveRecordModel
{
    use \Oliver\GravatarTrait;

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

    private $user;
    private $answer;
    private $tag;
    private $comment;
    private $rank;
    private $textFilter;

    public function init($user, $answer, $tag, $comment, $rank, $textFilter)
    {
        $this->user = $user;
        $this->answer = $answer;
        $this->tag = $tag;
        $this->comment = $comment;
        $this->rank = $rank;
        $this->textFilter = $textFilter;
    }


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
            $question->creator = $this->user->findAllWhere("id = ?", $question->userId)[0];
            $question->text = $this->textFilter->doFilter($question->text, "markdown");
            $question->answers = $this->answer->findAnswers($question->id);
            $question->numberOfAnswers = count($question->answers);
            $question->latestAnswer = $this->answer->findLatest($question->id);
        }
        return $questions;
    }



    public function findQuestion($questionId)
    {
        $question = $this->findAllWhere("id = ?", $questionId)[0];

        $question->text = $this->textFilter->doFilter($question->text, "markdown");
        $question->creator = $this->user->findById($question->userId);

        $question->tags = $this->tag->findTagsForQuestion($questionId);
        $question->comments = $this->comment->findComments("questionComment", $questionId);
        $question->answers = $this->answer->findAnswers($question->id);

        $question->rankScore = $this->rank->getRank($question->id) ?: 0;


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
            $question->creator = $this->user->findAllWhere("id = ?", $question->userId)[0];
            $question->text = $this->textFilter->doFilter($question->text, "markdown");
            $question->answers = $this->answer->findAnswers($question->id);
            $question->numberOfAnswers = count($question->answers);
            $question->latestAnswer = $this->answer->findLatest($question->id);
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
            $question->creator = $this->user->findUser($question->userId, 35);
        }
        return $questions;
    }


    public function countForUser(int $userId)
    {
        return count($this->findAllWhere("userId = ?", $userId));
    }

    public function isAccepted()
    {
        foreach ($this->answers as $answer) {
            if ($answer->accepted) {
                return true;
            }
        }
        return false;
    }
}
