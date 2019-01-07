<?php
/**
 * Configuration file for question.
 */
return [
    // Services to add to the container.
    "services" => [
        "question" => [
            // "active" => true,
            "shared" => false,
            "callback" => function () {
                $question = new \Oliver\Question\Question();
                $question->setDb($this->get("dbqb"));
                $question->setDI($this);
                return $question;
            }
        ],
        "user" => [
            // "active" => true,
            "shared" => false,
            "callback" => function () {
                $user = new \Oliver\User\User();
                $user->setDb($this->get("dbqb"));
                $user->setDI($this);
                return $user;
            }
        ],
        "answer" => [
            // "active" => true,
            "shared" => false,
            "callback" => function () {
                $answer = new \Oliver\Question\Answer();
                $answer->setDb($this->get("dbqb"));
                $answer->setDI($this);
                return $answer;
            }
        ],
        "comment" => [
            // "active" => true,
            "shared" => false,
            "callback" => function () {
                $comment = new \Oliver\Question\Comment();
                $comment->setDb($this->get("dbqb"));
                $comment->setDI($this);
                return $comment;
            }
        ],
        "tag" => [
            // "active" => true,
            "shared" => false,
            "callback" => function () {
                $tag = new \Oliver\Question\Tag();
                $tag->setDb($this->get("dbqb"));
                return $tag;
            }
        ],
    ],
];
