<?php

namespace Oliver\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Oliver\User\HTMLForm\LoginUserForm;
use Oliver\User\User;

/**
 * Example test class.
 */
// class UserTest extends TestCase
// {
//
//     protected $di;
//
//     protected function setUp()
//     {
//         global $di;
//
//         $this->di = new DIFactoryConfig();
//         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
//
//         $di = $this->di;
//     }
//
//
//     public function testCallbackSubmit()
//     {
//
//         var_dump($this->di->get("user"));
//
//         $form = new LoginUserForm($this->di);
//         $res = $form->callbackSubmit();
//         $form->check();
//         $this->assertTrue($res);
//     }
// }
