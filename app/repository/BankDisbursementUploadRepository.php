<?php

namespace app\repository;

use app\model\ModelBankDisbursementUpload;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BankDisbursementDownloadRepository.
 * @extends IRepository<ModelBankDisbursementUpload>
 */
class BankDisbursementUploadRepository  extends IRepository
{
    #[Inject]
    protected ModelBankDisbursementUpload $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['file_name']) && filled($params['file_name'])) {
            $query->where('file_name', $params['file_name']);
        }

        if (isset($params['hash']) && filled($params['hash'])) {
            $query->where('hash', $params['hash']);
        }

        return $query;
    }

    /**
     * 通过hash获取上传文件的信息.
     */
    public function getFileInfoByHash(string $hash, array $columns = ['*'])
    {
        $model = $this->model::query()->where('hash', $hash)->first($columns);
        if (!$model) {
            $model = $this->getModel()->withTrashed()->where('hash', $hash)->first(['id']);
            $model && $model->forceDelete();
            return null;
        }
        return $model;
    }

}
