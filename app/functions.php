<?php
/**
 * Here is your custom functions.
 */

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
        $factory = \app\factorys\ValidatorFactory::getInstance($lang);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}
