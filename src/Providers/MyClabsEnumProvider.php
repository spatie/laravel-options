<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MyCLabs\Enum\Enum;

/**
 * @extends EnumProvider<Enum>
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
        return Str::of($item->getKey())->replace('_', ' ')->lower()->ucfirst();
    }

    /**
     * @param Enum $provided
     * @param string $userDefined
     */
    public function equals(mixed $provided, mixed $userDefined): bool
    {
        return $provided->getValue()  === $userDefined;
    }
}
