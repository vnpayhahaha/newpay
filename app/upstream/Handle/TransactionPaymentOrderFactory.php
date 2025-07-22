<?php

namespace app\upstream\Handle;

class TransactionPaymentOrderFactory
{
    private static $instances = [];

    public static function getInstance(string $className): TransactionPaymentOrderInterface
    {
        // 如果是 /，先转换成 \ ,例如  App/Transaction/Service =》 App\Transaction\Service
        $className = str_replace('/', '\\', $className);
        // var_dump($className);
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className();
        }
        return self::$instances[$className];
    }

}
