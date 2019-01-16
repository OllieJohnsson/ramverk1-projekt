<?php

namespace Oliver\Rank\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\DatabaseActiveRecord\ActiveRecordModel;
use \Psr\Container\ContainerInterface;

use \Oliver\Rank\Rank;

/**
 * Form to create an item.
 */
class RankQuestionForm extends FormModel
{

    private $rankModel;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $questionId, Rank $rankModel, int $rank)
    {
        parent::__construct($di);

        $this->rankModel = $rankModel;
        $this->rankModel->setTableName("question");
        $userId = $this->di->get('session')->get('userId');
        $this->form->create(
            [
                "id" => "rankQuestionForm"
            ],
            [
                "questionId" => [
                    "type"     => "number",
                    "readonly" => true,
                    "value"    => $questionId,
                    "type"     => "hidden",
                ],
                "userId" => [
                    "type"     => "number",
                    "readonly" => true,
                    "value"    => $userId,
                    "type"     => "hidden",
                ],
                "rank" => [
                    "type"        => "number",
                    "placeholder" => "Rank",
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
        $questionId = $this->form->value('questionId');
        $userId = $this->form->value('userId');
        $rank = $this->form->value('rank');

        $this->rankModel->targetId = $questionId;
        $this->rankModel->userId = $userId;
        $this->rankModel->rankScore = $rank;
        $this->rankModel->save();

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
