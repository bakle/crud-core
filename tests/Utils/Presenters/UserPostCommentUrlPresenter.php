<?php declare(strict_types=1);

namespace Tests\Utils\Presenters;

use Bakle\CrudCore\Core\Presenters\BaseUrlPresenter;

class UserPostCommentUrlPresenter extends BaseUrlPresenter
{

    function getRouteName(): string
    {
        return 'users.posts.comments';
    }
}
