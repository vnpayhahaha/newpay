<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\model\enums\UserType;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use DI\Attribute\Inject;
use http\backend\Service\PassportService;
use support\Request;
use support\Response;

#[RestController("/backend")]
class PassportController extends BasicController
{

    #[Inject]
    protected PassportService $passportService;

    #[PostMapping('/login')]
    public function login(Request $request): Response
    {
        $validator = validate($request->post(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::FAIL, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $username = (string)$validatedData['username'];
        $password = (string)$validatedData['password'];
        $browser = $request->header('User-Agent') ?: 'unknown';
        $os = $request->os();
        $result = $this->passportService->login(
            $username,

            $password,
            UserType::SYSTEM,
            $request->getRealIp(false),
            $browser,
            $os
        );

        return $this->success($result);
    }
}
