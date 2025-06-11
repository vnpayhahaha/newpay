<?php

namespace http\backend\Service;


use app\exception\BusinessException;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\model\enums\UserType;
use app\repository\UserLoginLogRepository;
use app\repository\UserRepository;
use app\service\IService;
use DI\Attribute\Inject;
use http\backend\Event\Dto\UserLoginEventDto;
use Webman\Event\Event;
use Workerman\Coroutine;

class PassportService extends IService
{
    #[Inject]
    protected UserRepository $repository;

    #[Inject]
    protected UserLoginLogRepository $userLoginLogRepository;

    /**
     * @var string jwt场景
     */
    private string $jwt = 'backend';

    /**
     * @param string $username
     * @param string $password
     * @param UserType $userType
     * @param string $ip
     * @param string $browser
     * @param string $os
     * @return array
     */

    public function login(string $username, string $password, UserType $userType = UserType::SYSTEM, string $ip = '0.0.0.0', string $browser = 'unknown', string $os = 'unknown'): array
    {
        $user = $this->repository->findByUnameType($username, $userType);
        if (!filled($user)) {
            throw new UnprocessableEntityException(ResultCode::USER_LOGIN_FAILED, trans('password_error', [], 'auth'));
        }
        if (!$user->verifyPassword($password)) {
            var_dump('密码错误');
            Event::dispatch('backend.user.login', new UserLoginEventDto($user, $ip, $os, $browser, false));
            throw new UnprocessableEntityException(ResultCode::USER_LOGIN_FAILED, trans('password_error', [], 'auth'));
        }
        var_dump('密码正确');
        if ($user->status->isDisable()) {
            var_dump('用户被禁用');
            throw new BusinessException(ResultCode::DISABLED);
        }

        var_dump('用户登录成功');
        $jwt = user('backend');
        $config = $jwt->getConfig('backend');
        var_dump('==admin==');
        $token = $jwt->token($user->id)->toString();
        Event::dispatch('backend.user.login', new UserLoginEventDto($user, $ip, $os, $browser, true));
        return [
            'access_token' => $token,
            'token_type'   => $config->getType(),
            //            'refresh_token' => $jwt->refresh(),
            'expire_at'    => $config->getExpires(),
            'refresh_at'   => $config->getRefreshTTL(),
        ];
    }

    public function logout(string $token): bool
    {
        return user('backend')->logout($token);
    }

    // 记录登录日志
    public function loginLog(UserLoginEventDto $event): void
    {
        $user = $event->getUser();
        Coroutine::create(fn() => $this->userLoginLogRepository->getModel()->create([
            'username' => $user->username,
            'ip'       => $event->getIp(),
            'os'       => $event->getOs(),
            'browser'  => $event->getBrowser(),
            'status'   => $event->isLogin() ? 1 : 2,
        ]));
    }
}
