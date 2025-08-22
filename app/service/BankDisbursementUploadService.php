<?php

namespace app\service;

use app\repository\BankDisbursementUploadRepository;
use DI\Attribute\Inject;

class BankDisbursementUploadService extends IService
{
    #[Inject]
    public BankDisbursementUploadRepository $repository;
    #[Inject]
    public AttachmentService $attachmentService;

    public function upload($file, array $params): array
    {
        return $this->attachmentService->chunkUpload($file, $params, 'bill');
    }
}
