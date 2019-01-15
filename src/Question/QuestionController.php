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
            $latestAnswer = $this->answer->findLatest($question->id);

            $this->page->add("oliver/questions/question", [
                "item" => $question,
                "latestAnswer" => $latestAnswer
            ]);
        }

        $this->page->add("oliver/header", [
            "action" => $action
        ]);
        return $this->page->render([
            "title" => $title
        ]);
    }



    private function createRankArea(string $type, int $targetId)
    {
        $rank = new \Oliver\Rank\Rank();
        $rank->setDb($this->di->get('dbqb'));
        $rank->setTableName($type);


        $rankUpForm = new \Oliver\Rank\HTMLForm\RankForm($this->di, $targetId, 1, $rank, $type);
        $rankUpForm->check();
        $rankDownForm = new \Oliver\Rank\HTMLForm\RankForm($this->di, $targetId, -1, $rank, $type);
        $rankDownForm->check();

        $currentRank = $rank->getRank($targetId);

        $userId = $this->di->get('session')->get('userId');

        $rankUpForm = $rank->didRankUp($userId, $targetId) ? null : $rankUpForm->getHTML();
        $rankDownForm = $rank->didRankDown($userId, $targetId) ? null : $rankDownForm->getHTML();

        return [
            "rankUpForm" => $rankUpForm,
            "rankDownForm" => $rankDownForm,
            "currentRank" => $currentRank
        ];
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

        // $questionRank = new \Oliver\Rank\Rank();
        // $questionRank->setTableName("question");
        // $questionRank->setDb($this->di->get('dbqb'));
        // $rankQuestionUpForm = new \Oliver\Rank\HTMLForm\RankForm($this->di, $questionId, 1, $questionRank);
        // $rankQuestionUpForm->check();
        // $rankQuestionDownForm = new \Oliver\Rank\HTMLForm\RankForm($this->di, $questionId, -1, $questionRank);
        // $rankQuestionDownForm->check();

        // $currentQuestionRank = $questionRank->rank($questionId);


        $formHTML = $this->di->get('session')->get('userId') ? $commentQuestionForm->getHTML() : null;

        $rankForm = $this->createRankArea("question", $questionId);
        $this->page->add("oliver/questions/question-detail", [
            "item" => $question,
            "form" => $formHTML,
            "rankForm" => $rankForm
        ]);

        $showAcceptButton = !$this->question->isAccepted() && $question->userId == $this->di->get('session')->get('userId');
        $commentAnswerForm = null;

        foreach ($question->answers as $answer) {
            $commentAnswerForm = new CommentForm($this->di, $answer->id, "answerComment");
            $formHTML = $this->di->get('session')->get('userId') ? $commentAnswerForm->getHTML() : null;
            $rankForm = $this->createRankArea("answer", $answer->id);
            // die(var_dump($rankForm["rankUpForm"]));
            $this->page->add("oliver/questions/answer", [
                "item" => $answer,
                "form" => $formHTML,
                "showAcceptButton" => $showAcceptButton,
                "rankForm" => $rankForm
            ]);
        }

        if ($commentAnswerForm) {
            $commentAnswerForm->check();
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
        $this->di->get("response")->redirect("questions/${questionId}");
    }


// "path" => "rank/{type:string}/{targetId:digit}/{rank:digit}",
                            // questions/rank/question/1/1
    public function rank($type, $targetId, $rank)
    {
        // echo $type;
        // echo $targetId;
        // die($rank);


        $rankModel = new \Oliver\Rank\Rank($type);
        $rankForm = new \Oliver\Rank\HTMLForm\RankForm($this->di, $targetId, $rank, "upordown", $rankModel);

        die("hej");
        // $this->answer->acceptAnswer($answerId);
        // $this->di->get("response")->redirect("questions/${questionId}");
    }

}
