<?php

namespace backend\controller;

use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;

#[RestController("/haha")]
class IndexController
{
    #[GetMapping('/home')]
    public function index()
    {
        return "hello world";
    }

}
