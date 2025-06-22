<?php

declare (strict_types=1);

namespace app\router;

use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\MiddlewareIgnore;
use app\router\Annotations\PostMapping;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RequestMapping;
use app\router\Annotations\ResourceMapping;
use app\router\Annotations\RestController;
use ReflectionClass;
use ReflectionMethod;
use Webman\Route;

class AnnotationProvider
{
    public static function start(): void
    {
        $annotationClasses = self::scanFile();

        $tempClassAnnotations = [];
        foreach ($annotationClasses as $annotationClass) {
            $tempClassAnnotations[] = self::formatData($annotationClass);
        }
        $formatData = array_merge(...$tempClassAnnotations);

        foreach ($formatData as $item) {
            $method = $item['method'];
            if (is_array($method)) {
                Route::add($method, $item['path'], [$item['className'], $item['action']])->middleware($item['middleware']);
            } else if ($method === 'resource') {
                Route::group('', function () use ($item) {
                    Route::resource($item['path'], $item['className'], $item['allowMethods']);
                })->middleware($item['middleware']);
            } else {
                Route::$method($item['path'], [$item['className'], $item['action']])->middleware($item['middleware']);
            }
        }
    }

    private static function scanFile()
    {
        $suffix = config('app.controller_suffix', '');
        $suffixLength = strlen($suffix);
        $scanFolders = config("annotation.include_paths");
        foreach ($scanFolders as $scanFolder) {
            $dirIterator = new \RecursiveDirectoryIterator(base_path("$scanFolder/controller"));
            $iterator = new \RecursiveIteratorIterator($dirIterator);
            /** @var \SplFileInfo $file */
            foreach ($iterator as $file) {
                if ($file->isDir() || $file->getExtension() !== 'php') {
                    continue;
                }

                $filePath = str_replace('\\', '/', $file->getPathname());

                if ($suffixLength && substr($file->getBaseName('.php'), -$suffixLength) !== $suffix) {
                    continue;
                }
                $className = str_replace('/', '\\', substr(substr($filePath, strlen(base_path())), 0, -4));

                if (!class_exists($className)) {
                    continue;
                }

                yield $className;
            }
        }

    }

    private static function formatData($annotationClass)
    {
        $class = new ReflectionClass($annotationClass);
        $resourceMatch = false;
        $classAllowMethods = [];
        $className = $class->name;
        $tempClassAnnotations = [];
        $classPrefix = '';

        /** @var \ReflectionAttribute $classControllerAnnotation */
        $classControllerAnnotations = $class->getAttributes(RestController::class);
        if ($classControllerAnnotations) {
            foreach ($classControllerAnnotations as $classControllerAnnotation) {
                $classControllerAnnotationArgs = $classControllerAnnotation->getArguments();
                $classPrefix = $classControllerAnnotationArgs['path'] ?? current($classControllerAnnotationArgs) ?: '';
            }
        }


        $classMiddlewares = [];
        /** @var \ReflectionAttribute $classMiddlewareAnnotation */
        $classMiddlewareAnnotations = $class->getAttributes(Middleware::class);
        if ($classMiddlewareAnnotations) {
            foreach ($classMiddlewareAnnotations as $classMiddlewareAnnotation) {
                $args = $classMiddlewareAnnotation->getArguments();
                if (is_string($args[0])) {
                    $classMiddlewares[] = [$args[0]];
                } elseif (is_array($args[0])) {
                    $classMiddlewares[] = $args[0];
                }
            }
            $classMiddlewares = array_merge(...$classMiddlewares);
        }

        /** @var \ReflectionAttribute $classResourceAnnotation */
        $classResourceAnnotations = $class->getAttributes(ResourceMapping::class);
        if ($classResourceAnnotations) {
            foreach ($classResourceAnnotations as $classResourceAnnotation) {
                $classResourceAnnotationArgs = $classResourceAnnotation->getArguments();
                $classPath = $classPrefix . ($classResourceAnnotationArgs['path'] ?? $classResourceAnnotationArgs[0] ?? '');
                $classAllowMethods = $classResourceAnnotationArgs['allow_methods'] ?? [];
                $tempClassAnnotations[] = [
                    'method' => 'resource',
                    'className' => $className,
                    'path' => $classPath,
                    'allowMethods' => $classAllowMethods,
                    'middleware' => $classMiddlewares,
                ];
            }
            $resourceMatch = true;
        }

        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $item) {
            $action = $item->name;
            if ($resourceMatch && self::checkResourceAction($action, $classAllowMethods)) {
                continue;
            }

            $methodIgnoreMiddlewareAllSign = false;
            $methodIgnoreMiddlewares = [];
            $methodIgnoreMiddlewareAnnotations = $item->getAttributes(MiddlewareIgnore::class);
            if ($methodIgnoreMiddlewareAnnotations) {
                /** @var \ReflectionAttribute $methodMiddlewareAnnotation */
                foreach ($methodIgnoreMiddlewareAnnotations as $methodIgnoreMiddlewareAnnotation) {
                    $args = $methodIgnoreMiddlewareAnnotation->getArguments();
                    if (!empty($args)) {
                        if (is_string($args[0])) {
                            $methodIgnoreMiddlewares[] = [$args[0]];
                        } elseif (is_array($args[0])) {
                            $methodIgnoreMiddlewares[] = $args[0];
                        }
                    }
                }
                $methodIgnoreMiddlewares = array_merge(...$methodIgnoreMiddlewares);
                !$methodIgnoreMiddlewares && $methodIgnoreMiddlewareAllSign = true;
            }

            $methodMiddlewares = [];
            $methodMiddlewareAnnotations = $item->getAttributes(Middleware::class);
            if ($methodMiddlewareAnnotations) {
                /** @var \ReflectionAttribute $methodMiddlewareAnnotation */
                foreach ($methodMiddlewareAnnotations as $methodMiddlewareAnnotation) {
                    $args = $methodMiddlewareAnnotation->getArguments();
                    if (is_string($args[0])) {
                        $methodMiddlewares[] = [$args[0]];
                    } elseif (is_array($args[0])) {
                        $methodMiddlewares[] = $args[0];
                    }
                }
                $methodMiddlewares = array_merge(...$methodMiddlewares);
            }

            $methodMappingAnnotations = [
                $item->getAttributes(RequestMapping::class),
                $item->getAttributes(GetMapping::class),
                $item->getAttributes(PostMapping::class),
                $item->getAttributes(PutMapping::class),
                $item->getAttributes(DeleteMapping::class),
            ];

            foreach ($methodMappingAnnotations as $mappingAnnotation) {
                if ($mappingAnnotation) {
                    /** @var \ReflectionAttribute $item */
                    foreach ($mappingAnnotation as $item) {
                        $itemArgs = $item->getArguments();
                        $mappingPaths = $itemArgs['path'] ?? $itemArgs[0] ?? '';
                        if (is_string($mappingPaths)) {
                            $mappingPaths = [$mappingPaths];
                        }
                        if ($item->getName() === RequestMapping::class) {
                            $method = $itemArgs['methods'];
                            if (is_array($method)) {
                                array_walk($method, function (&$m) {
                                    $m = strtoupper($m);
                                });
                            }
                        } else {
                            $method = $item->newInstance()->getMethods();
                        }
                        foreach ($mappingPaths as $mappingPath) {
                            $allMiddlewares = array_merge($classMiddlewares, $methodMiddlewares);

                            if (!empty($methodIgnoreMiddlewares)) {
                                $allMiddlewares = array_diff($allMiddlewares, $methodIgnoreMiddlewares);
                            }

                            if ($methodIgnoreMiddlewareAllSign) {
                                $allMiddlewares = [];
                            }

                            $tempClassAnnotations[] = [
                                'method' => $method,
                                'path' => $classPrefix . $mappingPath,
                                'className' => $className,
                                'action' => $action,
                                'middleware' => $allMiddlewares,
                            ];
                        }
                    }
                }
            }
        }

        return $tempClassAnnotations;
    }

    private static function checkResourceAction(string $action, array $allowActions = []): bool
    {
        $actions = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'recovery'];
        if ($allowActions) {
            $actions = array_intersect($actions, $allowActions);
        }
        return in_array($action, $actions, true);
    }
}
