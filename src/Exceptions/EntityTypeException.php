<?php declare(strict_types=1);

namespace Bakle\LskCore\Exceptions;

use Exception;
use Throwable;

class EntityTypeException extends Exception
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setMessage(trans('One of the entities does not extend from BaseEntity'));
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }
}
