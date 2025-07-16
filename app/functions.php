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
        $locale = parseAcceptLanguage($lang);
        $factory = \app\lib\factory\ValidatorFactory::getInstance($locale);
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
if (!function_exists('parseAcceptLanguage')) {
    function parseAcceptLanguage(string $acceptLanguage): string
    {
        // 将字符串拆分为单个语言标签
        $languages = explode(',', $acceptLanguage);

        // 解析每个语言标签
        foreach ($languages as $language) {
            $parts = explode(';', $language);
            $code = trim($parts[0]);

            // 将连字符替换为下划线
            $code = str_replace('-', '_', $code);

            // 检查是否为有效的语言代码
            if (preg_match('/^[a-z]{2}_[A-Z]{2}$/', $code) || preg_match('/^[a-z]{2}$/', $code)) {
                return $code;
            }
        }

        // 如果以上都不匹配，则回退到默认语言
        return 'zh_CN';
    }
}
if (!function_exists('ascii_params')) {
    /**
     * 自定义ascii排序 返回字符串
     * @param array $params
     * @return string
     */
    function ascii_params(array $params = []): string
    {
        if (!empty($params)) {
            $p = ksort($params);
            if ($p) {
                $str = '';
                foreach ($params as $k => $val) {
                    $str .= $k . '=' . $val . '&';
                }
                return rtrim($str, '&');
            }
        }
        return '参数错误';
    }
}
// md5 加密签名 最后连接符
if (!function_exists('md5_signature')) {
    function md5_signature(array $params, string $key, string $key_name = 'key', string $connect = '&'): string
    {
        // 第一步：过滤空值和空字符串,保留数字0
        $params = array_filter($params, function ($val) {
            return $val !== '' && $val !== null;
        });
        // 第二步：拼接签名密钥
        $str = ascii_params($params);
        if ($key_name === null) {
            $str .= $connect . $key;
        } else {
            $str .= $connect . $key_name . '=' . $key;
        }
        var_dump('===签名前字符==', $str);
        return md5($str);
    }
}
