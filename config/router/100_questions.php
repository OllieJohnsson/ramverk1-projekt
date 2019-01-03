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
            // "method" => "get",
            "path" => "{questionId:digit}",
            "handler" => ["\Oliver\Question\QuestionController", "getQuestion"],
        ],
        [
            "info" => "Lägg till fråga",
            // "method" => "get",
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
    ]
];
