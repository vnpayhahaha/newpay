<?php

namespace app\service;

use app\repository\TransactionVoucherRepository;
use DI\Attribute\Inject;

final class TransactionVoucherService extends IService
{
    #[Inject]
    public TransactionVoucherRepository $repository;
}
