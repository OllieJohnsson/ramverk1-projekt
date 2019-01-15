<?php

namespace Oliver\Rank\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\DatabaseActiveRecord\ActiveRecordModel;
use \Psr\Container\ContainerInterface;

/**
 * Form to create an item.
 */
class RankForm extends FormModel
{

    private $table;
    private $type;

    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $targetId, int $rank, ActiveRecordModel $table, string $type)
    {
        parent::__construct($di);

        $this->table = $table;
        $this->type = $type;

        $userId = $di->get('session')->get('userId');
        $this->form->create(
            [
                "id" => "rankForm"
            ],
            [
                "targetId" => [
                    "type"     => "number",
                    "readonly" => true,
                    "value"    => $targetId,
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
        $targetId = $this->form->value('targetId');
        $userId = $this->form->value('userId');
        $rank = $this->form->value('rank');

        $this->table->setDb($this->di->get('dbqb'));
        $this->table->setTableName($this->type);

        $this->table->rank($targetId, $userId, $rank);
        return true;
    }




    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $targetId = $this->form->value('targetId');
        $this->di->get("response")->redirect("{$this->type}s/{$targetId}")->send();
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
