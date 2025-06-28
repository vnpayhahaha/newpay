<?php
/**
 * Here is your custom functions.
 */

use app\lib\JwtAuth\JwtAuth;
use support\Context;

if (!function_exists('validate')) {
    /**
     * Laravel 验证器
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
     */
    function validate(array $data = [], array $rules = [], array $messages = [], array $customAttributes = []): \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
    {
        $request = \request();
        $lang = $request->header('accept-language', 'zh_cn');
        $factory = \app\lib\factory\ValidatorFactory::getInstance($lang);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}
if (!function_exists('user')) {
    /**
     * 获取当前登录用户实例.
     */
    function user(string $scene = 'default'): JwtAuth
    {
        return new JwtAuth($scene);
    }
}

if (!function_exists('formatBytes')) {
    /**
     * 根据字节计算大小
     *
     * @param string|int $bytes
     *
     * @return string
     */
    function formatBytes(string|int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

}
if (!function_exists('sys_config')) {
    /**
     * 获取后台系统配置.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function sys_config(string $key, mixed $default = null): mixed
    {
        return \support\Container::get(app\service\SystemConfigService::class)->getConfigByKey($key) ?? $default;
    }
}
if (!function_exists('t')) {

    function t(string $key, array $replace = []): string
    {
        if (str_contains($key, '.')) {
            $tranKey = substr($key, strpos($key, '.') + 1);
            $domain = substr($key, 0, strpos($key, '.'));
            $locale = Context::get('locale');
            return trans($tranKey, $replace, $domain, $locale);
        }

        return $key;
    }
}
