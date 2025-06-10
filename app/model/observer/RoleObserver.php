<?php

namespace app\model\observer;

use app\model\ModelRole;

class RoleObserver
{
    /**
     * 监听数据即将删除的事件。
     *
     * @param ModelRole $role
     * @return void
     */
    public function deleting(ModelRole $role): void
    {
        $role->users()->detach();
        $role->menus()->detach();
    }

}
