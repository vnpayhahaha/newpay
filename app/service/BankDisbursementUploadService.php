<?php

namespace app\service;

use app\exception\BusinessException;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\repository\BankDisbursementUploadRepository;
use app\service\upload\ChunkUploadFile;
use DI\Attribute\Inject;
use Webman\Http\UploadFile;

class BankDisbursementUploadService extends IService
{
    #[Inject]
    public BankDisbursementUploadRepository $repository;
    #[Inject]
    public ChunkUploadFile $chunkUploadFile;

    public function upload($file,array $params): array
    {
        // 验证参数
        if (!$params['fileId'] ||
            !$params['index'] ||
            !$params['total'] ||
            !$params['fileName'] ||
            !$params['fileSize'] ||
            !$params['fileType'] ||
            !$params['fileHash']) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY);
        }

        if (!($file instanceof UploadFile)) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY);
        }
        try {
            // 保存分片
            $saveChunkOK = $this->chunkUploadFile->saveChunk($file, [
                'fileId' => $params['fileId'],
                'index'  => $params['index'],
                'total'  => $params['total'],
                'name'   => $params['fileName'],
                'size'   => $params['fileSize'],
                'hash'   => $params['fileHash'],
                'type'   => $params['fileType'],
            ]);
        } catch (\RuntimeException $e) {
            throw new BusinessException(ResultCode::UPLOAD_CHUNK_FAILED, $e->getMessage());
        }

        if (!$saveChunkOK) {
            throw new BusinessException(ResultCode::UPLOAD_CHUNK_FAILED);
        }
        $result['chunk'] = $params['index'];
        // 如果是最后一个分片，则合并
        if ($params['index'] === $params['total']) {
            try {
                $result = $this->chunkUploadFile->mergeChunks($params['fileId'], $params['fileName'], (int)$params['total'], $params['fileHash'], (int)$params['fileSize'], $params['fileType']);
            } catch (\RuntimeException $e) {
                throw new BusinessException(ResultCode::UPLOAD_FAILED, $e->getMessage());
            }
        }
        return $result;
    }
}
