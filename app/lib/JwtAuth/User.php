<?php

namespace app\lib\JwtAuth;

use app\lib\JwtAuth\exception\TokenInvalidException;
use app\lib\JwtAuth\user\AuthorizationUserInterface;

class User
{
    /**
     * @var AuthorizationUserInterface
     */
    protected $model;

    public function __construct($model)
    {
        $class = new $model;
        if ($class instanceof AuthorizationUserInterface) {
            $this->model = $class;
        } else {
            throw new TokenInvalidException('must be implements app\lib\JwtAuth\user\AuthorizationUserInterface', 500);
        }
    }

    /**
     * 获取登录用户对象
     *
     * @param Jwt $jwt
     * @return AuthorizationUserInterface
     */
    public function get(Jwt $jwt)
    {
        $token      = $jwt->getVerifyToken();
        $identifier = $token->claims()->get('jti');
        $identifier = explode(':', $identifier);
        $uid = end($identifier);

        return $this->model->getUserById($uid);
    }
}
