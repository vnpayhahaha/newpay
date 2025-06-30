<?php

namespace app\service;

use app\repository\BankAccountRepository;
use DI\Attribute\Inject;

final class BankAccountService extends IService
{
    #[Inject]
    public BankAccountRepository $repository;
}
