<?php
namespace Oliver\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Oliver\Question\HTMLForm\AddQuestionForm;
use Oliver\Question\HTMLForm\AnswerQuestionForm;
use Oliver\Question\HTMLForm\CommentForm;


/**
 *
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $page;
    private $user;
    private $question;
    private $answer;
    private $tag;

    public function initialize() : void
    {
        $this->page = $this->di->get("page");
        $this->user = $this->di->get('user');
        $this->question = $this->di->get('question');
        $this->answer = $this->di->get('answer');
        $this->tag = $this->di->get('tag');
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

        $commentQuestionForm = new CommentForm($this->di, $question->id, "questionComment");
        $commentQuestionForm->check();

        $this->page->add("oliver/questions/question-detail", [
            "item" => $question,
            "form" => $commentQuestionForm->getHTML()
        ]);

        foreach ($question->answers as $answer) {
            $commentAnswerForm = new CommentForm($this->di, $answer->id, "answerComment");
            $this->page->add("oliver/questions/answer", [
                "item" => $answer,
                "form" => $commentAnswerForm->getHTML()
            ]);
        }

        if (count($question->answers) > 0) {
            $commentAnswerForm->check();
        }

        $answerForm = new AnswerQuestionForm($this->di, $questionId);
        $answerForm->check();

        $this->page->add("oliver/questions/create-answer", [
            "form" => $answerForm->getHTML()
        ]);

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

        $form = new AddQuestionForm($this->di, $this->question);
        $form->check();

        $this->page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $this->page->render([
            "title" => $title
        ]);
    }


    public function filterQuestions(int $tagId) : object
    {
        $tagName = $this->tag->getName($tagId);
        $title = "#$tagName";

        $this->page->add("oliver/header", [
            "back" => [
                "link" => "questions/tags",
                "name" => "Alla taggar"
            ],
            "title" => $title
        ]);

        $questions = $this->question->findAllWithTag($tagId);

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
