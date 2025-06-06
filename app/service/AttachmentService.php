<?php

namespace app\service;

use app\repository\AttachmentRepository;

final class AttachmentService extends IService
{
    public function __construct(
        protected readonly AttachmentRepository $repository,
    ) {}

    public function getRepository(): AttachmentRepository
    {
        return $this->repository;
    }
}
