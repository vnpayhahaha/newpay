<?php

namespace backend\controller;

use app\lib\abstracts\AbstractController;
use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;
use app\service\UserService;
use DI\Annotation\Inject;

#[RestController("/haha")]
final class IndexController extends AbstractController
{
    /**
     * @Inject
     * @var UserService
     */
    protected  UserService $service;
    #[GetMapping('/home')]
    public function index()
    {

        $dds= $this->service->page([]);
        var_dump($dds);

        return $this->success($dds);
    }

}
