<?php

namespace Oliver\Rank\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\DatabaseActiveRecord\ActiveRecordModel;
use \Psr\Container\ContainerInterface;

/**
 * Form to create an item.
 */
class RankAnswerForm extends FormModel
{
    private $answer;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, ActiveRecordModel $answer, int $rank)
    {
        parent::__construct($di);
        $this->answer = $answer;
        $this->form->create(
            [
                "id" => "rankAnswerForm"
            ],
            [
                "rank" => [
                    "type"        => "number",
                    "readonly" => true,
                    "value"  => $rank,
                    "type"     => "hidden",
                ],
                "submit" => [
                    "type"     => "submit",
                    "value"    => $rank === 1 ? "↑" : "↓",
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
        $answerId = $this->answer->id;
        $userId = $this->di->get('session')->get('userId');
        $rank = $this->form->value('rank');

        $this->answer->rank->rank($answerId, $userId, $rank);
        return true;
    }




    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $questionId = $this->form->value('questionId');
        $this->di->get("response")->redirect("questions/$questionId")->send();
        return true;
    }



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
