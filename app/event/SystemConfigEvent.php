<?php

namespace app\event;


class SystemConfigEvent
{
    public function Update(mixed $params): void
    {
        var_dump('SystemConfigUpdate  event==',$params);

    }
}
