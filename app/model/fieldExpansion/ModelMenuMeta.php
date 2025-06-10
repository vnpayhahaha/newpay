<?php

namespace app\model\fieldExpansion;

use support\Model;

/**
 * @property string $title 标题
 * @property string $i18n 国际化
 * @property string $badge 徽章
 * @property string $icon 图标
 * @property bool $affix 是否固定
 * @property bool $hidden 是否隐藏
 * @property string $type 类型
 * @property bool $cache 是否缓存
 * @property bool $copyright 是否显示版权
 * @property string $link 链接
 * @property string $componentPath 视图文件类型
 * @property string $componentSuffix 视图前缀路径
 * @property string $breadcrumbEnable 是否显示面包屑
 * @property string $activeName 激活高亮的菜单标识
 * @property string $auth 前端权限判断，允许访问的权限码
 * @property string $role 前端权限判断，允许访问的角色码
 * @property string $user 前端权限判断，允许访问的用户名
 */
final class ModelMenuMeta extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'title',
        'i18n',
        'badge',
        'icon',
        'affix',
        'hidden',
        'type',
        'cache',
        'copyright',
        'link',
        'componentPath',
        'componentSuffix',
        'breadcrumbEnable',
        'activeName',
        'auth',
        'role',
        'user',
    ];

    protected $casts = [
        'affix'            => 'boolean',
        'hidden'           => 'boolean',
        'cache'            => 'boolean',
        'copyright'        => 'boolean',
        'breadcrumbEnable' => 'boolean',
        'title'            => 'string',
        'componentPath'    => 'string',
        'componentSuffix'  => 'string',
        'i18n'             => 'string',
        'badge'            => 'string',
        'icon'             => 'string',
        'type'             => 'string',
        'link'             => 'string',
        'activeName'       => 'string',
        'auth'             => 'array',
        'role'             => 'array',
        'user'             => 'array',
    ];
}
