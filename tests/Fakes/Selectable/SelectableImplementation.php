<?php

namespace Spatie\LaravelOptions\Tests\Fakes\Selectable;

use Spatie\LaravelOptions\Selectable;
use Spatie\LaravelOptions\SelectOption;

class SelectableImplementation implements Selectable
{
    public function __construct(
        protected readonly string $label,
        protected readonly string $value,
    ) {
    }

    public function toSelectOption(): SelectOption
    {
        return new SelectOption($this->label, $this->value);
    }
}
