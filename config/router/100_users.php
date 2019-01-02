<?php
/**
 * /questions
 */
return [
    "mount" => "users",
    "routes" => [
        [
            "info" => "Alla användare",
            "method" => "get",
            "path" => "",
            "handler" => "\Oliver\User\UserController",
        ],
        [
            "info" => "En användare",
            "method" => "get",
            "path" => "{id:digit}",
            "handler" => ["\Oliver\User\UserController", "getUser"],
        ],
        [
            "info" => "Registrera",
            // "method" => "get",
            "path" => "register",
            "handler" => "\Oliver\User\UserController"
        ],
        [
            "info" => "Logga in",
            "path" => "login",
            "handler" => "\Oliver\User\UserController"
        ],
        [
            "info" => "Logga ut",
            "path" => "logout",
            "handler" => "\Oliver\User\UserController"
        ],
        [
            "info" => "Redigera",
            "path" => "edit",
            "handler" => "\Oliver\User\UserController"
        ],
        // [
        //     "info" => "Filtrerad",
        //     "method" => "get",
        //     "path" => "tag/{tag:alphanum}",
        //     "handler" => ["\Oliver\Controller\QuestionsController", "filterQuestions"],
        // ],
        // [
        //     "info" => "Alla taggar",
        //     "method" => "get",
        //     "path" => "tags",
        //     "handler" => ["\Oliver\Controller\QuestionsController", "tags"],
        // ],
    ]
];
