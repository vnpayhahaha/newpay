<?php

namespace app\service;

use app\repository\BankDisbursementDownloadRepository;
use DI\Attribute\Inject;

class BankDisbursementDownloadService extends IService
{
    #[Inject]
    public BankDisbursementDownloadRepository $repository;
}
