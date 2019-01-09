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

        $this->di->get('page')->add("oliver/header", [
            "title" => $title
        ]);



        $question = $this->di->get('question');
        $tag = $this->di->get('tag');
        $user = $this->di->get('user');

        $latestQuestions = $question->findLatestQuestions(3);
        $mostPopularTags = $tag->findMostPopularTags(3);
        $mostActiveUsers = $user->findMostActiveUsers(3);



        foreach ($latestQuestions as $question) {
            $this->di->get('page')->add("oliver/home/latestQuestion", [
                "question" => $question
            ]);
        }

        foreach ($mostPopularTags as $tag) {
            $this->di->get('page')->add("oliver/home/popularTag", [
                "tag" => $tag
            ]);
        }

        foreach ($mostActiveUsers as $user) {
            $this->di->get('page')->add("oliver/home/activeUser", [
                "user" => $user
            ]);
        }

        return $this->di->get('page')->render([
            "title" => $title
        ]);
    }

}
