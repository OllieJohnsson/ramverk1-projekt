<?php

namespace Oliver\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Oliver\User\HTMLForm\LoginUserForm;
use Oliver\User\HTMLForm\CreateUserForm;
use Oliver\User\HTMLForm\EditUserForm;
use Oliver\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



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
        $this->user = new User();
        $this->user->setDb($this->di->get("dbqb"));
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



    public function getUser(int $id)
    {
        $user = $this->user->findUser($id, 150);

        $action = $id === $this->di->get('session')->get('userId') ? [
            "link" => "users/edit",
            "name" => '<img src="https://img.icons8.com/ios-glyphs/30/53d794/pencil.png">'
        ] : null;

        $this->page->add("oliver/header", [
            "title" => $user->username,
            "back" => [
                "link" => "users",
                "name" => "Alla användare"
            ],
            "action" => $action
        ]);
        $this->page->add("oliver/users/userInfo", ["user" => $user]);

        return $this->page->render([
            "title" => $user->username
        ]);
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
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new LoginUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }


    public function logoutAction() : object
    {
        $this->di->get("session")->destroy();
        $this->di->get("response")->redirect("")->send();
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
    public function registerAction() : object
    {
        $form = new CreateUserForm($this->di);
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
            "title" => "Redigera",
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
