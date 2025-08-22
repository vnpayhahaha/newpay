<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\BankDisbursementUploadService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/transaction")]
class BankDisbursementUploadController extends BasicController
{
    #[Inject]
    protected BankDisbursementUploadService $service;

    #[GetMapping('/bank_disbursement_upload/list')]
    #[Permission(code: 'transaction:bank_disbursement_upload:list')]
    #[OperationLog('银行账单下载记录列表')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            data: $this->service->page(
                $request->all(),
                $this->getCurrentPage(),
                $this->getPageSize(),
            )
        );
    }

    // 上传账单
    #[PostMapping('/bank_disbursement_upload/upload')]
    #[Permission(code: 'transaction:bank_disbursement_upload:upload')]
    #[OperationLog('上传银行账单')]
    public function upload(Request $request): Response
    {
        $file = $request->file('file');
        return $this->success(
            data: $this->service->upload(
                $file,
                $request->all(),
            )
        );
    }

}