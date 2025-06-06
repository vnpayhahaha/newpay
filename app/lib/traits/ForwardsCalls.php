<?php
declare(strict_types=1);
namespace app\lib\traits;

use BadMethodCallException;
use Error;

use function get_class;

trait ForwardsCalls
{
    /**
     * Forward a method call to the given object.
     *
     * @param mixed $object
     * @throws Error
     */
    protected function forwardCallTo($object, string $method, array $parameters)
    {
        try {
            return $object->{$method}(...$parameters);
        } catch (BadMethodCallException|Error $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (! preg_match($pattern, $e->getMessage(), $matches)) {
                throw $e;
            }

            if ($matches['class'] !== get_class($object) || $matches['method'] !== $method) {
                throw $e;
            }

            self::throwBadMethodCallException($method);
        }
    }

    /**
     * Throw a bad method call exception for the given method.
     * @throws BadMethodCallException
     */
    protected static function throwBadMethodCallException(string $method): void
    {
        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', static::class, $method));
    }
}
