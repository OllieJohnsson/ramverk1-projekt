<?php

namespace Oliver\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use \Psr\Container\ContainerInterface;

use Oliver\Question\Question;
use Oliver\Question\Tag;
use Oliver\Question\QuestionTag;

/**
 * Form to create an item.
 */
class AddQuestionForm extends FormModel
{
    private $question;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, Question $question)
    {
        parent::__construct($di);
        $this->question = $question;
        $this->form->create(
            [
                "id" => "addQuestionForm"
            ],
            [
                "title" => [
                    "type" => "text",
                    "placeholder" => "Titel",
                    "validation" => ["not_empty"],
                ],
                "text" => [
                    "type"        => "textarea",
                    "placeholder" => "Text",
                    "validation"  => ["not_empty"],
                ],

                "tag" => [
                    "type" => "text",
                    "placeholder" => "Tag",
                ],
                "allTags" => [
                    "type" => "text",
                    "type" => "hidden"
                ],
                "button" => [
                    "type"      => "button",
                    "value" => "Lägg till tag"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka fråga",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    private function addTags(Question $question)
    {
        $lastQuestionId = $question->getLastId();
        $tags = explode(",", $this->form->value("allTags"));
        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $questionTag = new QuestionTag();
            $questionTag->setDb($this->di->get("dbqb"));

            $lastTagId = 0;
            try {
                $tag->name = $tagName;
                $tag->save();

                $lastTagId = $tag->getLastId();
            } catch (\Anax\Database\Exception\Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $lastTagId = $tag->findAllWhere("name = ?", $tagName)[0]->id;
                }
            }
            $questionTag->questionId = $lastQuestionId;
            $questionTag->tagId = $lastTagId;
            $questionTag->save();
        }
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $this->question->setDb($this->di->get("dbqb"));

        date_default_timezone_set("Europe/Stockholm");
        $date = date('Y-m-d H:i:s');

        $this->question->title  = $this->form->value("title");
        $this->question->text = $this->form->value("text");
        $this->question->userId = $this->di->get("session")->get("userId");
        $this->question->posted = $date;
        $this->question->save();

        if ($this->form->value("allTags") != "") {
            $this->addTags($this->question);
        }
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("questions")->send();
        return true;
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    public function callbackFail()
    {
        $this->di->get("response")->redirectSelf()->send();
    }
}
