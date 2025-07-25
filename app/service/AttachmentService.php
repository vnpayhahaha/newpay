<?php

namespace app\service;

use app\exception\UploadException;
use app\lib\annotation\DataScope;
use app\model\enums\ScopeType;
use app\repository\AttachmentRepository;
use app\service\upload\UploadFile;
use DI\Attribute\Inject;
use support\Db;


final class AttachmentService extends IService
{
    #[Inject]
    protected AttachmentRepository $repository;


    public function getRepository(): AttachmentRepository
    {
        return $this->repository;
    }

    #[DataScope(
        scopeType: ScopeType::CREATED_BY,
    )]
    public function page(array $params, int $page = 1, int $pageSize = 10): array
    {
        return parent::page($params, $page, $pageSize); // TODO: Change the autogenerated stub
    }

    public function upload(string $upload = '', bool $isLocal = false): ?array
    {
        try {
            $resource = Db::transaction(function () use ($upload, $isLocal) {
                $baseConfig = UploadFile::getDefaultConfig();//获取上次配置
                if (empty($baseConfig)) {
                    throw new UploadException('缺少上传配置信息');
                }

                $type = $baseConfig['mode'] ?? 'local';//上次模式默认本地
                if ($isLocal) {
                    $type = 'local';
                }

                $result = UploadFile::uploadFile();
                $data = $result[0];
                $hash = $data['unique_id'];

                $url = str_replace('\\', '/', $data['url']);
                $path = str_replace('\\', '/', $data['save_path']);

                // 检查文件是否已存在
                if ($filesInfo = $this->repository->getModel()->where(['hash' => $hash])->first()) {
                    return $filesInfo->toArray();
                }
                $inData = [
                    'storage_mode' => $type,
                    'origin_name'  => $data['origin_name'] ?? '',
                    'object_name'  => $data['save_name'],
                    'hash'         => $hash,
                    'mime_type'    => $data['mime_type'],
                    'base_path'    => $data['base_path'],
                    'suffix'       => $data['extension'],
                    'size_byte'    => $data['size'],
                    'size_info'    => formatBytes($data['size']),
                    'url'          => $url,
                    'storage_path' => $path,
                ];
                $result = $this->repository->getModel()->create($inData);
                if (!$result) {
                    return [];
                }
                return $result->toArray();
            });
        } catch (\Exception $e) {
            throw new UploadException($e->getMessage());
        }
        return $resource;
    }
}
