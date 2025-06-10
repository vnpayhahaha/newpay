<?php

namespace app\constants\lib;

trait ConstantsOptionTrait
{
    public static function getOptionList(array $optionList, array $parameters = []): array
    {
        // $optionList 用t(string $key, array $replace = []): string 方法 翻译转换$optionList数组每一项的value值, key不变
        return array_map(
            static function ($item) use ($parameters) {
                return trans($item, $parameters);
            }, $optionList
        );
    }


    // 翻译并按键值对 label => value 返回选项列表
    public static function getOptionMap(array $optionList, array $parameters = []): array
    {
        // $optionList 用t(string $key, array $replace = []): string 方法 翻译转换$optionList数组每一项的value值, 并按 label => value 键值对返回
        return array_map(
            static function ($key, $item) use ($parameters) {
                return [
                    'label' => trans($item, $parameters),
                    'value' => $key,
                ];
            }, array_keys($optionList), array_values($optionList)
        );
    }

    // 获取翻译后的人性化描述
    public static function getHumanizeValue(array $optionList, int $key, array $parameters = []): string
    {
        return trans($optionList[$key], $parameters);
    }

}
