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

        // $this->di->get('page')->add("oliver/header", [
        //     "title" => $title
        // ]);

        $question = $this->di->get('question');
        $tag = $this->di->get('tag');
        $user = $this->di->get('user');

        $latestQuestions = $question->findLatestQuestions(5);
        $mostPopularTags = $tag->findMostPopularTags(10);
        $mostActiveUsers = $user->findMostActiveUsers(5);

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

        // $this->di->get('page')->add("oliver/home/list-header");
        // foreach ($latestQuestions as $question) {
        //     $this->di->get('page')->add("oliver/home/latestQuestion", [
        //         "question" => $question
        //     ]);
        // }
        // $this->di->get('page')->add("oliver/home/list-footer");
        //
        // $this->di->get('page')->add("oliver/home/list-header");
        // foreach ($mostPopularTags as $tag) {
        //     $this->di->get('page')->add("oliver/home/popularTag", [
        //         "tag" => $tag
        //     ]);
        // }
        // $this->di->get('page')->add("oliver/home/list-footer");
        //
        // $this->di->get('page')->add("oliver/home/list-header");
        // foreach ($mostActiveUsers as $user) {
        //     $this->di->get('page')->add("oliver/home/activeUser", [
        //         "user" => $user
        //     ]);
        // }
        // $this->di->get('page')->add("oliver/home/list-footer");

        return $this->di->get('page')->render([
            "title" => $title
        ]);
    }
}
