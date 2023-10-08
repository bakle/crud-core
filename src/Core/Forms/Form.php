<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Forms;

use Bakle\CrudCore\Core\Enums\FormMethods;
use Bakle\CrudCore\Core\Enums\FormTypes;

readonly class Form
{
    public function __construct(private string $url, private FormTypes $type)
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getType(): string
    {
        return $this->type->value;
    }

    public function isCreateType(): bool
    {
        return $this->type === FormTypes::CREATE;
    }

    public function isEditType(): bool
    {
        return $this->type === FormTypes::EDIT;
    }

    public function getMethod(): string
    {
        return match ($this->type) {
            FormTypes::EDIT => FormMethods::PUT->value,
            default => FormMethods::POST->value
        };
    }
}
