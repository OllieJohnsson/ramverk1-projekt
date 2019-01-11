<?php

namespace Oliver\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use \Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class LoginUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => "loginUserForm",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "placeholder" => "Användarnamn",
                    "autofocus" => true
                ],

                "password" => [
                    "type"        => "password",
                    "placeholder" => "Lösenord",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $username = $this->form->value("username");
        $password = $this->form->value("password");

        $user = $this->di->get("user");
        $res = $user->verifyPassword($username, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $this->di->get("session")->set("userId", $user->id);

        $this->form->addOutput("User " . $user->username . " logged in.");
        return true;
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("")->send();
        return true;
    }
}
