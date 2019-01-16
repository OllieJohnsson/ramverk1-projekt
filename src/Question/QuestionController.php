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


    public function indexActionGet() : object
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
        $this->page->add("oliver/header", [
            "action" => $action
        ]);
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

        $rankUpForm = new \Oliver\Rank\HTMLForm\RankQuestionForm($this->di, $question, 1);
        $rankUpForm->check();
        $rankDownForm = new \Oliver\Rank\HTMLForm\RankQuestionForm($this->di, $question, -1);
        $rankDownForm->check();


        $formHTML = $this->di->get('session')->get('userId') ? $commentQuestionForm->getHTML() : null;
        $rankUpFormHTML = null;
        $rankDownFormHTML = null;

        // $userId = $this->di->get('session')->get('userId');
        // if ($userId && !$question->rank->didRank($userId, $question->id)) {
        //     $rankUpFormHTML = $rankUpForm->getHTML();
        //     $rankDownFormHTML = $rankDownForm->getHTML();
        // }
        $rankUpFormHTML = $rankUpForm->getHTML();
        $rankDownFormHTML = $rankDownForm->getHTML();

        $this->page->add("oliver/questions/question-detail", [
            "item" => $question,
            "form" => $formHTML,
            "rankUpForm" => $rankUpFormHTML,
            "rankDownForm" => $rankDownFormHTML
        ]);

        $showAcceptButton = !$question->isAccepted() && $question->userId == $this->di->get('session')->get('userId');
        $commentAnswerForm = null;


        foreach ($question->answers as $answer) {
            $commentAnswerForm = new CommentForm($this->di, $answer->id, "answerComment");
            $formHTML = $this->di->get('session')->get('userId') ? $commentAnswerForm->getHTML() : null;

            $rankUpForm = new \Oliver\Rank\HTMLForm\RankAnswerForm($this->di, $answer, 1);
            $rankDownForm = new \Oliver\Rank\HTMLForm\RankAnswerForm($this->di, $answer, -1);

            $rankUpFormHTML = null;
            $rankDownFormHTML = null;
            // if ($userId && !$answer->rank->didRank($userId, $answer->id)) {
            //
            //     $rankUpFormHTML = $rankUpForm->getHTML();
            //     $rankDownFormHTML = $rankDownForm->getHTML();
            // }
            $rankUpFormHTML = $rankUpForm->getHTML();
            $rankDownFormHTML = $rankDownForm->getHTML();

            $this->page->add("oliver/questions/answer", [
                "item" => $answer,
                "form" => $formHTML,
                "showAcceptButton" => $showAcceptButton,
                "rankUpForm" => $rankUpFormHTML,
                "rankDownForm" => $rankDownFormHTML
            ]);
        }

        if ($commentAnswerForm) {
            $commentAnswerForm->check();
            $rankUpForm->check();
            $rankDownForm->check();
        }

        $answerForm = new AnswerQuestionForm($this->di, $questionId);
        $answerForm->check();

        $this->page->add("oliver/questions/create-answer", [
            "form" => $answerForm->getHTML()
        ]);

        $this->page->add("oliver/header", [
            "action" => $action
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
        $title = "Alla taggar";

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


    public function acceptAnswer($questionId, $answerId)
    {
        $this->answer->acceptAnswer($answerId);
        $this->di->get("response")->redirect("questions/$questionId");
    }
}
