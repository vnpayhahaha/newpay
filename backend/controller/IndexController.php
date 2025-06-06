<?php

namespace backend\controller;

use app\controller\BasicController;
use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;
use app\service\UserService;


use DI\Attribute\Inject;
use support\Request;

#[RestController("/haha")]
final class IndexController extends BasicController
{
    #[Inject]
    protected UserService $service;

    #[GetMapping('/home')]
    public function index(Request $request)
    {
//        return $this->success([
//            'dd' => trans('hello')
//        ]);
//        $validator = validate($request->post(), [
//            'title' => 'required|unique:posts|max:255',
//            'body'  => 'required',
//        ]);
//        if ($validator->fails()) {
//            return $this->error($validator->errors()->first());
//        }
        $dds = $this->service->page([]);
        var_dump($dds);

        return $this->success($dds);
    }

}
