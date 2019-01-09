<?php

namespace Oliver\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

use Oliver\Question\Comment;

/**
 * Form to create an item.
 */
class CommentForm extends FormModel
{

    private $tableName;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $targetId, string $tableName)
    {
        parent::__construct($di);
        $this->tableName = $tableName;
        $this->form->create(
            [
                "id" => "${tableName}Form"
            ],
            [
                "id" => [
                    "type"     => "number",
                    "readonly" => true,
                    "value"    => $targetId,
                    "type"     => "hidden",
                ],
                "text" => [
                    "type"        => "text",
                    "placeholder" => "Text",
                    "validation"  => ["not_empty"],
                ],
                "submit" => [
                    "type"     => "submit",
                    "value"    => "Kommentera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }




    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $targetId = $this->form->value('id');
        $text = $this->form->value('text');

        date_default_timezone_set("Europe/Stockholm");
        $date = date('Y-m-d H:i:s');

        $comment = new Comment();
        $comment->setTableName($this->tableName);
        $comment->setDb($this->di->get('dbqb'));

        $comment->text = $text;
        $comment->posted = $date;
        $comment->targetId = $targetId;
        $comment->userId = $this->di->get('session')->get('userId');
        $comment->save();

        return true;
    }




    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("questions")->send();
    //     return True;
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
