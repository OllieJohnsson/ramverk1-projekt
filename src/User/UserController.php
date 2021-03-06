<?php

namespace Oliver\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Oliver\User\HTMLForm\LoginUserForm;
use Oliver\User\HTMLForm\RegisterUserForm;
use Oliver\User\HTMLForm\EditUserForm;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $page;
    private $user;
    private $question;
    private $answer;

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->page = $this->di->get("page");
        $this->user = $this->di->get('user');
        $this->question = $this->di->get('question');
        $this->answer = $this->di->get('answer');
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $title = "Alla användare";

        $this->page->add("oliver/header", ["title" => $title]);

        $users = $this->user->findAllOrderByUsername(80);

        foreach ($users as $user) {
            $this->page->add("oliver/users/allUsersMenuItem", ["user" => $user]);
        }

        return $this->page->render([
            "title" => $title
        ]);
    }



    public function getUser(int $userId)
    {
        $user = $this->user->findUser($userId, 150);
        $questions = $this->question->findAllByUser($userId);
        $answers = $this->answer->findAllByUser($userId);

        $action = null;
        $h1Prefix = "{$user->username}s";
        $h2Prefix = $h1Prefix;
        $pPrefix = $user->username;
        if ($userId === $this->di->get('session')->get('userId')) {
            $action = [
                "link" => "users/edit",
                "name" => '<img src="https://img.icons8.com/ios-glyphs/30/53d794/pencil.png">'
            ];
            $h1Prefix = "Min";
            $h2Prefix = "Mina";
            $pPrefix = "Du";
        }

        $this->page->add("oliver/header", [
            "title" => "{$h1Prefix} profil",
            "back" => [
                "link" => "users",
                "name" => "Alla användare"
            ],
            "action" => $action
        ]);

        $this->page->add("oliver/users/userInfo", [
            "user" => $user,
            "questions" => $questions,
            "answers" => $answers,
            "h2Prefix" => $h2Prefix,
            "pPrefix" => $pPrefix
        ]);


        return $this->page->render([
            "title" => $user->username
        ]);
    }



    public function loginAction() : object
    {
        $this->page->add("oliver/header", [
            "title" => "Logga in"
        ]);
        $form = new LoginUserForm($this->di);
        $form->check();

        $this->page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $this->page->render([
            "title" => "A login page",
        ]);
    }


    public function logoutAction() : object
    {
        $this->di->get("session")->destroy();
        $this->di->get("response")->redirect("")->send();
    }



    public function registerAction() : object
    {
        $this->page->add("oliver/header", [
            "title" => "Registrera"
        ]);
        $form = new RegisterUserForm($this->di);
        $form->check();

        $this->page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $this->page->render([
            "title" => "A create user page",
        ]);
    }


    public function editAction()
    {
        $form = new EditUserForm($this->di);
        $form->check();

        $userId = $this->di->get('session')->get('userId');

        $this->page->add("oliver/header", [
            "title" => "Redigera din profil",
            "back" => [
                "link" => "users/{$userId}",
                "name" => "Profil"
            ]
        ]);

        $this->page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $this->page->render([
            "title" => "An edit user page",
        ]);
    }
}
