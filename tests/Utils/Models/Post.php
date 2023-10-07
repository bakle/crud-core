<?php declare(strict_types=1);

namespace Tests\Utils\Models;

class Post extends \Illuminate\Database\Eloquent\Model
{

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
