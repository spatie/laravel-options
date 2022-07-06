<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @extends  EnumProvider<\StringBackedEnum|\IntBackedEnum>
 */
class NativeEnumProvider extends EnumProvider
{
    public function provide(): Collection
    {
        return collect($this->enum::cases());
    }

    protected function mapValue(mixed $item): string|int
    {
        return $item->value;
    }

    protected function mapDefaultLabel(mixed $item): string
    {
        return $item->name;
    }
}
