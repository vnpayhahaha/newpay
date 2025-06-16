<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\annotation\NoNeedLogin;
use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;
use app\service\UserService;


use DI\Attribute\Inject;
use support\Request;

#[RestController("/admin")]
final class IndexController extends BasicController
{
    #[Inject]
    protected UserService $service;

    #[GetMapping('/home')]
    #[NoNeedLogin]
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
        $dds = sys_config('upload_mode');

        return $this->success($dds);
    }

}
