<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\CollectionOrderService;
use app\service\DisbursementOrderService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/analysis")]
class AnalysisController extends BasicController
{
    #[Inject]
    public CollectionOrderService $collectionOrderService;
    #[Inject]
    public DisbursementOrderService $disbursementOrderService;

    // 一周订单统计
    #[GetMapping('/weekOrder')]
    public function weekOrder(Request $request): Response
    {
        $collectionOrder = $this->collectionOrderService->statisticsOrderOfWeek();
//        $disbursementOrder = $this->disbursementOrderService->statisticsOrderOfWeek();
        return $this->success([
            'collectionOrder'   => $collectionOrder,
            'disbursementOrder' => [],
        ]);
    }

}