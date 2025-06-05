<?php

namespace backend\controller;

use app\lib\Router\Annotations\GetMapping;
use app\lib\Router\Annotations\RestController;

#[RestController("/haha")]
class IndexController
{
    #[GetMapping('/home')]
    public function index()
    {
        return "hello world";
    }

}
