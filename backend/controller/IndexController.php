<?php

namespace backend\controller;

use lib\Router\Annotations\GetMapping;
use lib\Router\Annotations\RestController;

#[RestController("/haha")]
class IndexController
{
    #[GetMapping('/home')]
    public function index()
    {
        return "hello world";
    }

}
