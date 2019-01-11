<?php

// namespace Oliver\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Oliver\User\UserController;
use Oliver\User\User;

/**
 * Example test class.
 */
// class UserControllerTest extends TestCase
// {
//
//     // Create the di container.
//     protected $di;
//     protected $controller;
//
//     /**
//      * Prepare before each test.
//      */
//     protected function setUp()
//     {
//         global $di;
//
//         // Setup di
//         $this->di = new DIFactoryConfig();
//         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
//         // $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");
//
//         // View helpers uses the global $di so it needs its value
//         $di = $this->di;
//
//         // Setup the controller
//         $this->controller = new UserController();
//         $this->controller->setDI($this->di);
//         $this->controller->initialize();
//         // $this->controller->initialize();
//     }
//
//
//
//     public function testIndex()
//     {
//         $this->assertTrue(true);
//         // $res = $this->controller->indexActionGet();
//         // $this->assertContains("View all items", $res->getBody());
//     }
// }
