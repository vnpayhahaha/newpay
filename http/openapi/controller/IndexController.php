<?php

namespace http\openapi\controller;

use app\controller\BasicController;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use support\Request;

#[RestController("/openapi")]
class IndexController extends BasicController
{
    #[GetMapping('/home')]
    public function index(Request $request)
    {
        return $this->success([
            'dd' => trans('hello')
        ]);
    }
}
