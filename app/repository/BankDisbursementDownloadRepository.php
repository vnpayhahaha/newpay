<?php

namespace app\repository;

use app\model\ModelBankDisbursementDownload;
use DI\Attribute\Inject;

/**
 * Class BankDisbursementDownloadRepository.
 * @extends IRepository<ModelBankDisbursementDownload>
 */
class BankDisbursementDownloadRepository  extends IRepository
{
    #[Inject]
    protected ModelBankDisbursementDownload $model;
}