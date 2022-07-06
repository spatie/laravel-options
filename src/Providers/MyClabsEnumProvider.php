<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @extends \Spatie\LaravelOptions\Providers\EnumProvider<\MyCLabs\Enum\Enum>
 */
class MyClabsEnumProvider extends EnumProvider
{
    public function provide(): Collection
    {
        return collect($this->enum::values())->values();
    }

    protected function mapValue(mixed $item): string|int
    {
        return $item->getValue();
    }

    protected function mapDefaultLabel(mixed $item): string
    {
        return $item->getKey();
    }
}
