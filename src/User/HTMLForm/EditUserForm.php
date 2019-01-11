<?php

namespace Oliver\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use \Psr\Container\ContainerInterface;
use Oliver\User\User;

/**
 * Example of FormModel implementation.
 */
class EditUserForm extends FormModel
{
    private $user;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $id = $this->di->get('session')->get('userId');
        $this->user = $this->di->get("user")->findById($id);

        $this->form->create(
            [
                "id" => "editUserForm",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $this->user->id,
                    "type" => "hidden"
                ],
                "användarnamn" => [
                    "type"        => "text",
                    "value" => $this->user->username,
                    "placeholder" => "Användarnamn",
                    "validation" => ["not_empty"],
                    "autofocus" => true
                ],
                "e-post" => [
                    "type"        => "email",
                    "value" => $this->user->email,
                    "placeholder" => "E-post",
                    "validation" => ["not_empty"],
                ],
                "förnamn" => [
                    "type"        => "text",
                    "value" => $this->user->firstName,
                    "placeholder" => "Förnamn",
                    "validation" => ["not_empty"],
                ],
                "efternamn" => [
                    "type"        => "text",
                    "value" => $this->user->lastName,
                    "placeholder" => "Efternamn",
                    "validation" => ["not_empty"],
                ],
                // "password" => [
                //     "type"        => "password",
                // ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera",
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
        $this->user->username = $this->form->value("användarnamn");
        $this->user->email = $this->form->value("e-post");
        $this->user->firstName = $this->form->value("förnamn");
        $this->user->lastName = $this->form->value("efternamn");
        $this->user->save();

        return true;
        $this->form->addOutput("User " . $this->user->username . " updated.");
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("users/{$this->user->id}")->send();
        return true;
    }

    public function callbackFail()
    {
        $this->form->addOutput("Failed");
        $this->di->get("response")->redirectSelf()->send();
    }
}
