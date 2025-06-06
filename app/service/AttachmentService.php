<?php

namespace app\service;

use app\repository\AttachmentRepository;
use DI\Annotation\Inject;

final class AttachmentService extends IService
{
    /**
     * @Inject
     * @var AttachmentRepository
     */
    protected  AttachmentRepository $repository;

    public function getRepository(): AttachmentRepository
    {
        return $this->repository;
    }
}
