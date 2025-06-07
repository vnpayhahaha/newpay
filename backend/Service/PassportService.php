<?php

namespace backend\Service;


use app\http\ResultCode;
use app\model\enums\UserType;
use app\repository\UserRepository;
use app\service\IService;
use backend\Event\UserLoginEvent;
use DI\Attribute\Inject;
use JetBrains\PhpStorm\ArrayShape;
use support\exception\BusinessException;
use Webman\Event\Event;

class PassportService extends IService
{
    #[Inject]
    protected UserRepository $repository;


    /**
     * @var string jwt场景
     */
    private string $jwt = 'default';

    /**
     * @param string $username
     * @param string $password
     * @param UserType $userType
     * @param string $ip
     * @param string $browser
     * @param string $os
     * @return array
     */
    #[ArrayShape(['access_token' => "string", 'refresh_token' => "string", 'expire_at' => "int"])]
    public function login(string $username, string $password, UserType $userType = UserType::SYSTEM, string $ip = '0.0.0.0', string $browser = 'unknown', string $os = 'unknown'): array
    {
        $user = $this->repository->findByUnameType($username, $userType);
        if (!filled($user)) {
            throw new BusinessException(trans('password_error', [], 'auth'), ResultCode::UNPROCESSABLE_ENTITY->value);
        }
        if (!$user->verifyPassword($password)) {
            Event::dispatch('backend.user.login', new UserLoginEvent($user, $ip, $os, $browser, false));
            throw new BusinessException(trans('password_error',[], 'auth'), ResultCode::UNPROCESSABLE_ENTITY->value);
        }
        if ($user->status->isDisable()) {
            throw new BusinessException('', ResultCode::DISABLED->value);
        }
        Event::dispatch('backend.user.login', new UserLoginEvent($user, $ip, $os, $browser));

        return [
            'access_token'  => 'access_token',
            'refresh_token' => 'refresh_token',
            'expire_at'     => 'expire_at',
        ];
    }


    // 记录登录日志
    public function loginLog(UserLoginEvent $event): void
    {
        var_dump('记录登录日志== run ==', $event);
    }
}
