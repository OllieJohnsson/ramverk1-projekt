<?php
/**
 * Configuration file for question.
 */
return [
    // Services to add to the container.
    "services" => [
        "question" => [
            "shared" => false,
            "callback" => function () {
                $user = $this->get('user');
                $answer = $this->get('answer');
                $tag = $this->get('tag');
                $comment = $this->get('questionComment');
                $rank = $this->get('questionRank');
                $textFilter = $this->get('textfilter');

                $question = new \Oliver\Question\Question();
                $question->setDb($this->get("dbqb"));
                $question->init($user, $answer, $tag, $comment, $rank, $textFilter);

                return $question;
            }
        ],
        "user" => [
            "shared" => false,
            "callback" => function () {
                $user = new \Oliver\User\User();
                $user->setDb($this->get("dbqb"));
                return $user;
            }
        ],
        "answer" => [
            "shared" => false,
            "callback" => function () {
                $user = $this->get('user');
                $rank = $this->get('answerRank');
                $comment = $this->get('answerComment');
                $textFilter = $this->get('textfilter');

                $answer = new \Oliver\Question\Answer();
                $answer->setDb($this->get("dbqb"));
                $answer->init($textFilter, $rank, $user, $comment);
                return $answer;
            }
        ],
        "questionComment" => [
            "shared" => false,
            "callback" => function () {
                $user = $this->get('user');
                $textFilter = $this->get('textfilter');
                $comment = new \Oliver\Question\Comment();
                $comment->setDb($this->get("dbqb"));
                $comment->init("questionComment", $user, $textFilter);
                return $comment;
            }
        ],
        "answerComment" => [
            "shared" => false,
            "callback" => function () {
                $user = $this->get('user');
                $textFilter = $this->get('textfilter');
                $comment = new \Oliver\Question\Comment();
                $comment->setDb($this->get("dbqb"));
                $comment->init("answerComment", $user, $textFilter);
                return $comment;
            }
        ],
        "tag" => [
            "shared" => false,
            "callback" => function () {
                $tag = new \Oliver\Question\Tag();
                $tag->setDb($this->get("dbqb"));
                return $tag;
            }
        ],
        "answerRank" => [
            "shared" => false,
            "callback" => function () {
                $rank = new \Oliver\Rank\Rank();
                $rank->setDb($this->get("dbqb"));
                $rank->setTableName("answer");
                return $rank;
            }
        ],
        "questionRank" => [
            "shared" => false,
            "callback" => function () {
                $rank = new \Oliver\Rank\Rank();
                $rank->setDb($this->get("dbqb"));
                $rank->setTableName("question");
                return $rank;
            }
        ],
    ],
];
