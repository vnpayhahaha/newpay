<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\lib\enum\ResultCode;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\AttachmentService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin")]
class AttachmentController extends BasicController
{
    #[Inject]
    protected AttachmentService $service;

    #[GetMapping('/attachment/list')]
    #[Permission(code: 'dataCenter:attachment:list')]
    #[OperationLog('附件列表')]
    public function pageList(Request $request): Response
    {
        $params = $this->getRequest()->all();
        if (isset($params['suffix'])) {
            $params['suffix'] = explode(',', $params['suffix']);
        }
        return $this->success(
            $this->service->page($params, $this->getCurrentPage(), $this->getPageSize())
        );
    }

    // upload
    #[PostMapping('/attachment/upload')]
    #[Permission(code: 'dataCenter:attachment:upload')]
    #[OperationLog('上传附件')]
    public function upload(Request $request): Response
    {
        $this->service->upload('file');
        return $this->success();
    }

    // delete
    #[DeleteMapping('/attachment/{id}')]
    #[Permission(code: 'dataCenter:attachment:delete')]
    #[OperationLog('删除附件')]
    public function delete(Request $request, int $id): Response
    {
        if (!$this->service->getRepository()->existsById($id)) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, trans('attachment_not_exist', [], 'attachment'));
        }
        $this->service->deleteById($id);
        return $this->success();
    }
}
