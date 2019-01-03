<?php
namespace Oliver\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Oliver\Question\Question;
use Oliver\Question\Answer;
use Oliver\Question\Tag;
use Oliver\Question\HTMLForm\AddQuestionForm;
use Oliver\Question\HTMLForm\AnswerQuestionForm;
use Oliver\Question\HTMLForm\CommentAnswerForm;
use Oliver\Question\HTMLForm\CommentQuestionForm;

use Oliver\User\User;




/**
 *
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $page;
    private $question;
    private $user;
    private $answer;
    private $tag;

    public function initialize() : void
    {
        $this->page = $this->di->get("page");

        $this->tag = new Tag();
        $this->tag->setDb($this->di->get("dbqb"));

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $this->question = new Question($this->tag, $answer);
        $this->question->setDb($this->di->get("dbqb"));

        $this->user = new User();
        $this->user->setDb($this->di->get("dbqb"));

    }


    function indexActionGet() : object
    {
        $title = "Alla frågor";

        $action = $this->di->get("session")->get("userId") ? [
            "link" => "questions/add",
            "name" => '<img src="https://img.icons8.com/ios-glyphs/30/53d794/plus-math.png">'
        ] : null;

        $this->page->add("oliver/header", [
            "title" => $title,
            "action" => $action
        ]);

        $questions = $this->question->findAllOrderByPosted();
        foreach ($questions as $question) {
            $this->page->add("oliver/questions/question", [
                "item" => $question
            ]);
        }
        return $this->page->render([
            "title" => $title
        ]);
    }



    public function getQuestion(int $questionId) : object
    {

        $action = $this->di->get("session")->get("userId") ? [
            "link" => "",
            "name" => "Svara"
        ] : null;

        $this->page->add("oliver/header", [
            "back" => [
                "link" => "questions",
                "name" => "Alla frågor"
            ],
            "action" => $action
        ]);

        $question = $this->question->findQuestion($questionId);

        $this->page->add("oliver/questions/question-detail", [
            "item" => $question
        ]);




        $answerComment = new AnswerComment();
        $answerComment->setDb($this->di->get("dbqb"));

        $answer = new Answer($answerComment);
        $answer->setDb($this->di->get("dbqb"));

        $answers = $answer->findAnswers($questionId);

        foreach ($answers as $answer) {
            $commentForm = new CommentAnswerForm($this->di, $answer->id);
            $this->page->add("oliver/questions/answer", [
                "item" => $answer,
                "form" => $commentForm->getHTML()
            ]);
        }

        if (count($answers) > 0) {
            $commentForm->check();
        }

        $answerForm = new AnswerQuestionForm($this->di, $questionId);
        $answerForm->check();

        $this->page->add("oliver/questions/create-answer", [
            "form" => $answerForm->getHTML()
        ]);
        // $this->page->add("anax/v2/article/default", [
        //     "content" => $form->getHTML(),
        // ]);

        return $this->page->render([
            "title" => $question->title
        ]);
    }


    public function addQuestion() : object
    {
        $title = "Lägg till fråga";

        $this->page->add("oliver/header", [
            "back" => [
                "link" => "questions",
                "name" => "Tillbaka"
            ],
            "title" => $title
        ]);

        $form = new AddQuestionForm($this->di);
        $form->check();

        $this->page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $this->page->render([
            "title" => $title
        ]);
    }


    public function filterQuestions(int $id) : object
    {
        $tagName = $this->tag->getName($id);
        $title = "#$tagName";

        $this->page->add("oliver/header", [
            "back" => [
                "link" => "questions/tags",
                "name" => "Alla taggar"
            ],
            "title" => $title
        ]);

        $questions = $this->question->filter($id);

        foreach ($questions as $question) {
            $this->page->add("oliver/questions/question", ["item" => $question]);
        }

        return $this->page->render([
            "title" => $title
        ]);
    }


    public function tags()
    {
        $title = "Taggar";

        $this->page->add("oliver/header", [
            "title" => $title
        ]);

        $this->page->add("oliver/tags", [
            "tags" => $this->tag->findAll()
        ]);
        return $this->page->render([
            "title" => $title
        ]);
    }
}
