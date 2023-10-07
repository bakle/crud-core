<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Enums;

enum RouteMethods: string
{
    case INDEX = 'index';
    case SHOW = 'show';
    case EDIT = 'edit';
    case UPDATE = 'update';
    case CREATE = 'create';
    case STORE = 'store';
    case DESTROY = 'destroy';
}
