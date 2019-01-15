<?php
/**
 * /questions
 */
return [
    "mount" => "questions",
    "routes" => [
        [
            "info" => "Frågor",
            "method" => "get",
            "path" => "",
            "handler" => "\Oliver\Question\QuestionController",
        ],
        [
            "info" => "Fråga",
            "path" => "{questionId:digit}",
            "handler" => ["\Oliver\Question\QuestionController", "getQuestion"],
        ],
        [
            "info" => "Lägg till fråga",
            "path" => "add",
            "handler" => ["\Oliver\Question\QuestionController", "addQuestion"],
        ],
        [
            "info" => "Filtrerad",
            "method" => "get",
            "path" => "tag/{tag:alphanum}",
            "handler" => ["\Oliver\Question\QuestionController", "filterQuestions"],
        ],
        [
            "info" => "Alla taggar",
            "method" => "get",
            "path" => "tags",
            "handler" => ["\Oliver\Question\QuestionController", "tags"],
        ],
        [
            "info" => "Acceptera svar",
            "method" => "post",
            "path" => "{questionId:digit}/{answerId:digit}",
            "handler" => ["\Oliver\Question\QuestionController", "acceptAnswer"],
        ],
        // [
        //     "info" => "Rank",
        //     "method" => "post",
        //     "path" => "rank/{type:alphanum}/{targetId:digit}/{rank:digit}",
        //     "handler" => ["\Oliver\Question\QuestionController", "rank"],
        // ],
    ]
];
