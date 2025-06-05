<?php

declare (strict_types=1);

namespace lib\Router\Annotations;

abstract class Mapping
{
    public $path;

    /**
     * @return string | array
     */
    public function getPath()
    {
        return $this->path;
    }

    abstract public function getMethods();
}
