<?php

namespace WebmanTech\LaravelHttp\Facades;

use Closure;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Factory;
use support\Log;
use WebmanTech\LaravelHttp\Guzzle\Log\CustomLogInterface;
use WebmanTech\LaravelHttp\Guzzle\Log\Middleware as LogMiddleware;
use WebmanTech\LaravelHttp\Helper\ConfigHelper;
use WebmanTech\LaravelHttp\Helper\ExtComponentGetter;

/**
 * @method static \Illuminate\Http\Client\Factory globalMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\Factory globalRequestMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\Factory globalResponseMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\Factory globalOptions(Closure|array $options)
 * @method static \GuzzleHttp\Promise\PromiseInterface response(array|string|null $body = null, int $status = 200, array $headers = [])
 * @method static \GuzzleHttp\Promise\PromiseInterface failedConnection(string|null $message = null)
 * @method static \Illuminate\Http\Client\ResponseSequence sequence(array $responses = [])
 * @method static bool preventingStrayRequests()
 * @method static \Illuminate\Http\Client\Factory allowStrayRequests()
 * @method static void recordRequestResponsePair(\Illuminate\Http\Client\Request $request, \Illuminate\Http\Client\Response|null $response)
 * @method static void assertSent(callable $callback)
 * @method static void assertSentInOrder(array $callbacks)
 * @method static void assertNotSent(callable $callback)
 * @method static void assertNothingSent()
 * @method static void assertSentCount(int $count)
 * @method static void assertSequencesAreEmpty()
 * @method static \Illuminate\Support\Collection recorded(callable $callback = null)
 * @method static \Illuminate\Http\Client\PendingRequest createPendingRequest()
 * @method static \Illuminate\Contracts\Events\Dispatcher|null getDispatcher()
 * @method static array getGlobalMiddleware()
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static \Illuminate\Http\Client\PendingRequest baseUrl(string $url)
 * @method static \Illuminate\Http\Client\PendingRequest withBody(\Psr\Http\Message\StreamInterface|string $content, string $contentType = 'application/json')
 * @method static \Illuminate\Http\Client\PendingRequest asJson()
 * @method static \Illuminate\Http\Client\PendingRequest asForm()
 * @method static \Illuminate\Http\Client\PendingRequest attach(string|array $name, string|resource $contents = '', string|null $filename = null, array $headers = [])
 * @method static \Illuminate\Http\Client\PendingRequest asMultipart()
 * @method static \Illuminate\Http\Client\PendingRequest bodyFormat(string $format)
 * @method static \Illuminate\Http\Client\PendingRequest withQueryParameters(array $parameters)
 * @method static \Illuminate\Http\Client\PendingRequest contentType(string $contentType)
 * @method static \Illuminate\Http\Client\PendingRequest acceptJson()
 * @method static \Illuminate\Http\Client\PendingRequest accept(string $contentType)
 * @method static \Illuminate\Http\Client\PendingRequest withHeaders(array $headers)
 * @method static \Illuminate\Http\Client\PendingRequest withHeader(string $name, mixed $value)
 * @method static \Illuminate\Http\Client\PendingRequest replaceHeaders(array $headers)
 * @method static \Illuminate\Http\Client\PendingRequest withBasicAuth(string $username, string $password)
 * @method static \Illuminate\Http\Client\PendingRequest withDigestAuth(string $username, string $password)
 * @method static \Illuminate\Http\Client\PendingRequest withToken(string $token, string $type = 'Bearer')
 * @method static \Illuminate\Http\Client\PendingRequest withUserAgent(string|bool $userAgent)
 * @method static \Illuminate\Http\Client\PendingRequest withUrlParameters(array $parameters = [])
 * @method static \Illuminate\Http\Client\PendingRequest withCookies(array $cookies, string $domain)
 * @method static \Illuminate\Http\Client\PendingRequest maxRedirects(int $max)
 * @method static \Illuminate\Http\Client\PendingRequest withoutRedirecting()
 * @method static \Illuminate\Http\Client\PendingRequest withoutVerifying()
 * @method static \Illuminate\Http\Client\PendingRequest sink(string|resource $to)
 * @method static \Illuminate\Http\Client\PendingRequest timeout(int|float $seconds)
 * @method static \Illuminate\Http\Client\PendingRequest connectTimeout(int|float $seconds)
 * @method static \Illuminate\Http\Client\PendingRequest retry(array|int $times, Closure|int $sleepMilliseconds = 0, callable|null $when = null, bool $throw = true)
 * @method static \Illuminate\Http\Client\PendingRequest withOptions(array $options)
 * @method static \Illuminate\Http\Client\PendingRequest withMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\PendingRequest withRequestMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\PendingRequest withResponseMiddleware(callable $middleware)
 * @method static \Illuminate\Http\Client\PendingRequest beforeSending(callable $callback)
 * @method static \Illuminate\Http\Client\PendingRequest throw(callable|null $callback = null)
 * @method static \Illuminate\Http\Client\PendingRequest throwIf(callable|bool $condition)
 * @method static \Illuminate\Http\Client\PendingRequest throwUnless(callable|bool $condition)
 * @method static \Illuminate\Http\Client\PendingRequest dump()
 * @method static \Illuminate\Http\Client\PendingRequest dd()
 * @method static \Illuminate\Http\Client\Response get(string $url, array|string|null $query = null)
 * @method static \Illuminate\Http\Client\Response head(string $url, array|string|null $query = null)
 * @method static \Illuminate\Http\Client\Response post(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response patch(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response put(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response delete(string $url, array $data = [])
 * @method static array pool(callable $callback)
 * @method static \Illuminate\Http\Client\Response send(string $method, string $url, array $options = [])
 * @method static \GuzzleHttp\Client buildClient()
 * @method static \GuzzleHttp\Client createClient(\GuzzleHttp\HandlerStack $handlerStack)
 * @method static \GuzzleHttp\HandlerStack buildHandlerStack()
 * @method static \GuzzleHttp\HandlerStack pushHandlers(\GuzzleHttp\HandlerStack $handlerStack)
 * @method static Closure buildBeforeSendingHandler()
 * @method static Closure buildRecorderHandler()
 * @method static Closure buildStubHandler()
 * @method static \GuzzleHttp\Psr7\RequestInterface runBeforeSendingCallbacks(\GuzzleHttp\Psr7\RequestInterface $request, array $options)
 * @method static array mergeOptions(array ...$options)
 * @method static \Illuminate\Http\Client\PendingRequest stub(callable $callback)
 * @method static \Illuminate\Http\Client\PendingRequest async(bool $async = true)
 * @method static \GuzzleHttp\Promise\PromiseInterface|null getPromise()
 * @method static \Illuminate\Http\Client\PendingRequest setClient(\GuzzleHttp\Client $client)
 * @method static \Illuminate\Http\Client\PendingRequest setHandler(callable $handler)
 * @method static array getOptions()
 * @method static \Illuminate\Http\Client\PendingRequest|mixed when(Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \Illuminate\Http\Client\PendingRequest|mixed unless(Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 *
 * @see \Illuminate\Http\Client\Factory
 * @see \Illuminate\Support\Facades\Http
 */
class Http
{
    protected static ?Factory $instance = null;

    /**
     * @return Factory
     */
    public static function instance(): Factory
    {
        if (static::$instance === null) {
            $factory = static::createFactory();
            static::boot($factory);
            static::$instance = $factory;
        }
        return static::$instance;
    }

    /**
     * @return Factory
     */
    protected static function createFactory(): Factory
    {
        return new Factory(ExtComponentGetter::get(Dispatcher::class));
    }

    /**
     * 用于注册一些自定义的方法
     * @param Factory $factory
     * @return void
     */
    protected static function boot(Factory $factory): void
    {
        $factoryClass = get_class($factory);

        $config = array_merge([
            'macros' => [],
            'guzzle' => [],
            'log' => [],
        ], ConfigHelper::get('http-client', []));

        // boot macros
        foreach ($config['macros'] as $name => $macro) {
            $factoryClass::macro($name, $macro);
        }

        // add guzzle options
        $factory->globalOptions($config['guzzle']);

        // add log middleware
        if ($logMiddleware = static::getLogMiddleware($config['log'])) {
            $factory->globalMiddleware($logMiddleware);
        }
    }

    /**
     * @param array $config
     * @return callable|null
     */
    protected static function getLogMiddleware(array $config): ?callable
    {
        if (!isset($config['enable']) || !$config['enable']) {
            return null;
        }
        $config = array_merge([
            'channel' => 'default',
            'level' => 'info',
            'format' => MessageFormatter::CLF,
            'custom' => null,
        ], $config);

        if ($config['custom'] instanceof Closure) {
            $customLog = call_user_func($config['custom'], $config);
            if ($customLog instanceof CustomLogInterface) {
                return (new LogMiddleware($customLog))->__invoke();
            }
            if ($customLog instanceof Closure) {
                return $customLog;
            }
        }

        return Middleware::log(Log::channel($config['channel']), new MessageFormatter($config['format']), $config['level']);
    }

    public static function __callStatic($name, $arguments)
    {
        return static::instance()->{$name}(...$arguments);
    }
}
