<?php declare(strict_types=1);

namespace Bakle\LskCore\Exceptions;

use Exception;
use Throwable;

class ModelTypeException extends Exception
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setMessage(trans('One of the params does not extend from Model'));
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }
}
