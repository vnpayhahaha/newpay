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
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB'
        ];
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
// buildPlatformOrderNo
if (!function_exists('buildPlatformOrderNo')) {
    function buildPlatformOrderNo(string $prefix = ''): string
    {
        // 使用更高精度的时间戳（微秒级）
        $microsecond = microtime(true);
        $date = DateTime::createFromFormat('U.u', sprintf('%.6f', $microsecond));
        try {
            // 首选加密安全的随机字节生成器
            $randomBytes = random_bytes(4);
        } catch (Throwable $e) {
            // 降级方案1：尝试使用 OpenSSL 扩展
            if (function_exists('openssl_random_pseudo_bytes')) {
                $strong = false;
                // 添加第二个参数并验证加密强度
                $randomBytes = openssl_random_pseudo_bytes(4, $strong);
                // 添加双重验证：返回值有效性 + 算法强度
                if ($randomBytes === false || !$strong) {
                    throw new RuntimeException('Secure random number generator not available');
                }
            } // 降级方案2：使用 mt_rand 生成伪随机数
            else {
                // 生成4字节（32位）随机数
                $randomInt = mt_rand(0, 0xFFFFFFFF);
                $randomBytes = pack('N', $randomInt); // 将32位整数打包为4字节字符串
            }
        }
        // 格式化时间部分（包含毫秒）
        $timePart = $date->format('YmdHis') . str_pad($date->format('v'), 3, '0', STR_PAD_LEFT);
        // 转换为十六进制并大写
        $randomHex = bin2hex($randomBytes);
        // 组合时间戳和随机部分
        return $prefix . $timePart . strtoupper($randomHex);
    }
}

if (!function_exists('isWeekend')) {
    function isWeekend(DateTime $date): bool
    {
        // 使用 PHP 的 DateTime::format 方法获取星期几的数字表示
        // 1 表示星期一，7 表示星期日
        // 所以我们需要检查数字是否为 6（星期六）或 7（星期日）
        return in_array($date->format('N'), [
            6,
            7
        ], true);
    }
}
// 根据延时结算类型 D0(当天) D(自然日) T(工作日) + 延时结算天数 计算 预计结算时间
if (!function_exists('calculateSettlementDate')) {
    /**
     * 计算预计结算时间
     * @param int $type 结算类型（1:D0/2:D/3:T）
     * @param int $days 延时天数
     * @param DateTime|null $startDate 起始日期（默认当前时间）
     * @return DateTime
     * @throws InvalidArgumentException
     */
    function calculateSettlementDate(int $type = 1, int $days = 0, DateTime|null $startDate = null): DateTime
    {
        // 参数校验
        if (!is_int($days) || $days < 0) {
            throw new InvalidArgumentException("Days must be a non-negative integer.");
        }

        // 初始化日期对象
        if ($startDate === null) {
            $startDate = new DateTime();
        } else {
            $startDate = clone $startDate;
        }

        $currentDate = clone $startDate;

        switch (strtoupper($type)) {
            case 1:
            case 2:
                // 自然日计算（包含周末）
                $currentDate->modify("+$days days");
                break;

            case 3:
                // 工作日计算（跳过周末）
                $addedDays = 0;
                while ($addedDays < $days) {
                    $currentDate->modify('+1 day');
                    if (!isWeekend($currentDate)) {
                        $addedDays++;
                    }
                }
                break;

            default:
                throw new InvalidArgumentException("Invalid type. Use 'D0', 'D', or 'T'.");
        }

        return $currentDate;
    }
}

if (!function_exists('formatSize')) {
    function formatSize($size): string
    {
        $sizes = array(
            ' Bytes',
            ' KB',
            ' MB',
            ' GB',
            ' TB'
        );
        return round($size / (1024 ** ($i = floor(log($size, 1024)))), 2) . $sizes[$i];
    }
}

// 构建印度电话号码
if (!function_exists('generateIndianMobileNum')) {
    // 构建电话号码，每次调用从[7,8,9]中随机一个作为开头，生成10位长度的随机数
    function generateIndianMobileNum(): string
    {
        try {
            $prefix = random_int(7, 9);
            $suffix = '';
            for ($i = 0; $i < 9; $i++) {
                $suffix .= random_int(0, 9);
            }
        } catch (\Exception $e) {
            return '00000000000';
        }
        return $prefix . $suffix;
    }
}