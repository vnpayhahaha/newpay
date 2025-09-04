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
    #[GetMapping('/weekOrder/collection_order_num')]
    public function weekOrderCollectionOrderNum(Request $request): Response
    {
        $user = $request->user;
        $collectionOrder = $this->collectionOrderService->statisticsOrderNumberOfWeek($user->id);
        return $this->success($collectionOrder);
    }

    #[GetMapping('/weekOrder/disbursement_order_num')]
    public function weekOrderDisbursementOrderNum(Request $request): Response
    {
        $user = $request->user;
        $disbursementOrder = $this->disbursementOrderService->statisticsOrderNumberOfWeek($user->id);
        return $this->success($disbursementOrder);
    }

    #[GetMapping('/weekOrder/collection_successful_num')]
    public function weekOrderCollectionSuccessfulNum(Request $request): Response
    {
        $user = $request->user;
        $collectionOrder = $this->collectionOrderService->statisticsOrderSuccessfulNumberOfWeek($user->id);
        return $this->success($collectionOrder);
    }

    #[GetMapping('/weekOrder/disbursement_successful_num')]
    public function weekOrderDisbursementSuccessfulNum(Request $request): Response
    {
        $user = $request->user;
        $disbursementOrder = $this->disbursementOrderService->statisticsOrderSuccessfulNumberOfWeek($user->id);
        return $this->success($disbursementOrder);
    }

    #[GetMapping('/weekOrder/collection_successful_amount')]
    public function weekOrderCollectionSuccessfulAmount(Request $request): Response
    {
        $user = $request->user;
        $collectionOrder = $this->collectionOrderService->statisticsOrderSuccessfulAmountOfWeek($user->id);
        return $this->success($collectionOrder);
    }

    #[GetMapping('/weekOrder/disbursement_successful_amount')]
    public function weekOrderDisbursementSuccessfulAmount(Request $request): Response
    {
        $user = $request->user;
        $disbursementOrder = $this->disbursementOrderService->statisticsOrderSuccessfulAmountOfWeek($user->id);
        return $this->success($disbursementOrder);
    }

    #[GetMapping('/weekOrder/collection_successful_rate')]
    public function weekOrderCollectionSuccessfulRate(Request $request): Response
    {
        $user = $request->user;
        $collectionOrderNumber = $this->collectionOrderService->statisticsOrderNumberOfWeek($user->id);
        $collectionOrderSuccessfulNumber = $this->collectionOrderService->statisticsOrderSuccessfulNumberOfWeek($user->id);
        if ($collectionOrderNumber['count'] > 0) {
            $collectionOrderSuccessfulRate['count'] = bcmul(bcdiv((string)$collectionOrderSuccessfulNumber['count'], (string)$collectionOrderNumber['count'], 4), '100', 2);
        } else {
            $collectionOrderSuccessfulRate['count'] = 0;
        }

        if ($collectionOrderNumber['yesterday'] > 0) {
            $collectionOrderSuccessfulRate['yesterday'] = bcmul(bcdiv((string)$collectionOrderSuccessfulNumber['yesterday'], (string)$collectionOrderNumber['yesterday'], 4), '100', 2);
        } else {
            $collectionOrderSuccessfulRate['yesterday'] = 0;
        }

        $collectionOrderSuccessfulRate['growth'] = bcsub($collectionOrderSuccessfulRate['count'], $collectionOrderSuccessfulRate['yesterday'], 2);
        foreach ($collectionOrderNumber['chartData'] as $key => $value) {
            if ($value['y'] > 0) {
                $itemY = bcmul(bcdiv((string)$collectionOrderSuccessfulNumber['chartData'][$key]['y'], (string)$value['y'], 4), '100', 2);
            } else {
                $itemY = 0;
            }

            $collectionOrderSuccessfulRate['chartData'][$key] = [
                'x'    => $value['x'],
                'y'    => $itemY,
                'name' => '%'
            ];
        }
        return $this->success($collectionOrderSuccessfulRate);
    }

    #[GetMapping('/weekOrder/disbursement_successful_rate')]
    public function weekOrderDisbursementSuccessfulRate(Request $request): Response
    {
        $user = $request->user;
        $disbursementOrderNumber = $this->disbursementOrderService->statisticsOrderNumberOfWeek($user->id);
        $disbursementOrderSuccessfulNumber = $this->disbursementOrderService->statisticsOrderSuccessfulNumberOfWeek($user->id);
        if ($disbursementOrderNumber['count']) {
            $disbursementOrderSuccessfulRate['count'] = bcmul(bcdiv((string)$disbursementOrderSuccessfulNumber['count'], (string)$disbursementOrderNumber['count'], 4), '100', 2);
        } else {
            $disbursementOrderSuccessfulRate['count'] = 0;
        }
        if ($disbursementOrderNumber['yesterday'] > 0) {
            $disbursementOrderSuccessfulRate['yesterday'] = bcmul(bcdiv((string)$disbursementOrderSuccessfulNumber['yesterday'], (string)$disbursementOrderNumber['yesterday'], 4), '100', 2);
        } else {
            $disbursementOrderSuccessfulRate['yesterday'] = 0;
        }


        $disbursementOrderSuccessfulRate['growth'] = bcsub($disbursementOrderSuccessfulRate['count'], $disbursementOrderSuccessfulRate['yesterday'], 2);
        foreach ($disbursementOrderNumber['chartData'] as $key => $value) {
            if ($value['y'] > 0) {
                $itemY = bcmul(bcdiv((string)$disbursementOrderSuccessfulNumber['chartData'][$key]['y'], (string)$value['y'], 4), '100', 2);
            } else {
                $itemY = 0;
            }
            $disbursementOrderSuccessfulRate['chartData'][$key] = [
                'x'    => $value['x'],
                'y'    => $itemY,
                'name' => '%'
            ];
        }
        return $this->success($disbursementOrderSuccessfulRate);
    }

}