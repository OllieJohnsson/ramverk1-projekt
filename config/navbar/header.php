<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

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

        // [
        //     "text" => "Redovisning",
        //     "url" => "redovisning",
        //     "title" => "Redovisningstexter från kursmomenten.",
        //     "submenu" => [
        //         "items" => [
        //             [
        //                 "text" => "Kmom01",
        //                 "url" => "redovisning/kmom01",
        //                 "title" => "Redovisning för kmom01.",
        //             ],
        //             [
        //                 "text" => "Kmom02",
        //                 "url" => "redovisning/kmom02",
        //                 "title" => "Redovisning för kmom02.",
        //             ],
        //         ],
        //     ],
        // ],
        // [
        //     "text" => "Styleväljare",
        //     "url" => "style",
        //     "title" => "Välj stylesheet.",
        // ],
        // [
        //     "text" => "Verktyg",
        //     "url" => "verktyg",
        //     "title" => "Verktyg och möjligheter för utveckling.",
        // ],
    ],
];
