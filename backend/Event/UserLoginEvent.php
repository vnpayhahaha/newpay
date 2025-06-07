<?php

namespace backend\Event;

/**
 * @template T
 */
final class UserLoginEvent
{
    /**
     * @param T $user
     */
    public function __construct(
        private readonly object $user,
        private readonly string $ip,
        private readonly string $os,
        private readonly string $browser,
        private readonly bool $isLogin = true,
    )
    {
    }

    /**
     * @return T
     */
    public function getUser(): object
    {
        return $this->user;
    }

    public function isLogin(): bool
    {
        return $this->isLogin;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getBrowser(): string
    {
        return $this->browser;
    }

    public function getOs(): string
    {
        return $this->os;
    }
}
