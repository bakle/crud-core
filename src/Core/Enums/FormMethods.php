<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Enums;

enum FormMethods: string
{
    case POST = 'POST';
    case PATCH = 'PATCH';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
