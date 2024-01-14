<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\ViewModels;

use Illuminate\Contracts\View\View;

abstract class BaseViewModel
{
    public function buildWithView(string $view): View
    {
        return view($view, $this->build());
    }
}
