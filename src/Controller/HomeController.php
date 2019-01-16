<?php
namespace Oliver\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 *
 */
class HomeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction()
    {
        $title = "Hem";

        $question = $this->di->get('question');
        $answer = $this->di->get('answer');
        $questionComment = $this->di->get('questionComment');
        $answerComment = $this->di->get('answerComment');
        $tag = $this->di->get('tag');
        $user = $this->di->get('user');

        $latestQuestions = $question->findLatestQuestions(5);
        $mostPopularTags = $tag->findMostPopularTags(10);
        $mostActiveUsers = $user->findLimit(5);

        foreach ($mostActiveUsers as $user) {
            $user->noQuestions = count($question->findAllWhere("userId = ?", $user->id));
            $user->noAnswers = count($answer->findAllWhere("userId = ?", $user->id));
            $user->noComments = count($questionComment->findAllWhere("userId = ?", $user->id)) + count($answerComment->findAllWhere("userId = ?", $user->id));
            $user->activity = $user->noQuestions + $user->noAnswers + $user->noComments;
        }
        usort($mostActiveUsers, function ($first, $second) {
            return $second->activity <=> $first->activity;
        });


        $this->di->get('page')->add("oliver/home/list-container", [
            "lists" => [
                [
                    "list" => $latestQuestions,
                    "template" => "latestQuestion.php",
                    "title" => "Senaste frågorna"
                ],
                [
                    "list" => $mostPopularTags,
                    "template" => "popularTag.php",
                    "title" => "Populärast taggar"
                ],
                [
                    "list" => $mostActiveUsers,
                    "template" => "activeUser.php",
                    "title" => "Aktivast användare"
                ]
            ]
        ]);

        return $this->di->get('page')->render([
            "title" => $title
        ]);
    }
}
