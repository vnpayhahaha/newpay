<?php

namespace backend\controller;

use app\lib\abstracts\AbstractController;
use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;
use app\service\AttachmentService;
use DI\Annotation\Inject;

#[RestController("/haha")]
final class IndexController extends AbstractController
{
    /**
     * @Inject
     * @var AttachmentService
     */
    protected  AttachmentService $service;
    #[GetMapping('/home')]
    public function index()
    {

        $dds= $this->service->getRepository()->getModel()->getQuery()->get();
        var_dump($dds);

        return $this->success(['dd'=>'ddees']);
    }

}
