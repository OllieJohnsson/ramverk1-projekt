<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Frågor",
            "url" => "questions",
            "title" => "Frågor",
        ],
        [
            "text" => "Taggar",
            "url" => "questions/tags",
            "title" => "Taggar",
        ],
        [
            "text" => "Användare",
            "url" => "users",
            "title" => "Användare",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "currentUser",
            "url" => "users",
            "title" => "",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Profil",
                        "url" => "users/",
                        "title" => ""
                    ],
                    [
                        "text" => "Logga ut",
                        "url" => "users/logout",
                        "title" => ""
                    ]
                ],
            ],
        ],
        [
            "text" => '<img src="https://img.icons8.com/ios-glyphs/30/ffffff/user-male-circle.png">',
            "url" => "users/login",
            "title" => "user",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Logga in",
                        "url" => "users/login",
                        "title" => "Logga in",
                    ],
                    [
                        "text" => "Registrera",
                        "url" => "users/register",
                        "title" => "Registrera",
                    ],
                ],
            ],
        ],
    ],
];
