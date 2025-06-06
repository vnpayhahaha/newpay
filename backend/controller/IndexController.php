<?php

namespace backend\controller;

use app\lib\abstracts\AbstractController;
use app\model\ModelAttachment;
use app\repository\AttachmentRepository;
use app\Router\Annotations\GetMapping;
use app\Router\Annotations\RestController;
use app\service\AttachmentService;

#[RestController("/haha")]
final class IndexController extends AbstractController
{

    #[GetMapping('/home')]
    public function index()
    {
        $da = new AttachmentService(new AttachmentRepository(new ModelAttachment()));
        $dds= $da->getRepository()->getModel()->getQuery()->get();
        var_dump($dds);

        return $this->success(['dd'=>'ddees']);
    }

}
