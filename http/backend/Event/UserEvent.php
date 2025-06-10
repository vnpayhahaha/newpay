<?php

namespace http\backend\Event;

use app\lib\JwtAuth\event\EventHandler;
use Lcobucci\JWT\Token;

class UserEvent implements EventHandler
{
    public function login(Token $token)
    {
        // TODO: Implement login() method.
    }

    public function logout(Token $token)
    {
        // TODO: Implement logout() method.
    }

    public function verify(Token $token)
    {
        // TODO: Implement verify() method.
    }

}
