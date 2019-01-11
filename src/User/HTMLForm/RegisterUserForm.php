<?php

namespace Oliver\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use \Psr\Container\ContainerInterface;
use Oliver\User\User;

/**
 * Example of FormModel implementation.
 */
class RegisterUserForm extends FormModel
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
                "id" => "registerUserForm",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "placeholder" => "Användarnamn",
                    "autofocus" => true
                ],
                "email" => [
                    "type"        => "email",
                    "validation" => ["not_empty"],
                    "placeholder" => "E-post",
                ],
                "firstName" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "placeholder" => "Förnamn",
                ],
                "lastName" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "placeholder" => "Efternamn",
                ],

                "password" => [
                    "type"        => "password",
                    "validation" => ["not_empty"],
                    "placeholder" => "Lösenord",
                ],
                "password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "password",
                        "not_empty"
                    ],
                    "placeholder" => "Upprepa lösenord"
                ],


                "submit" => [
                    "type" => "submit",
                    "value" => "Registrera",
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
        $username      = $this->form->value("username");
        $email         = $this->form->value("email");
        $firstName     = $this->form->value("firstName");
        $lastName      = $this->form->value("lastName");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user = $this->di->get('user');
        $user->username = $username;
        $user->email = $email;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->setPassword($password);
        $user->save();

        $this->di->get("session")->set("userId", $user->getLastId());
        $this->form->addOutput("User {$username} was created.");
        return true;
    }



    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("")->send();
        return true;
    }
}
