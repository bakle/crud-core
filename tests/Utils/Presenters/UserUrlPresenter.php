<?php declare(strict_types=1);

namespace Tests\Utils\Presenters;

use Bakle\LskCore\Core\Presenters\BaseUrlPresenter;

class UserUrlPresenter extends BaseUrlPresenter
{

    function setRouteName(): void
    {
        $this->routeName = 'users';
    }
}
