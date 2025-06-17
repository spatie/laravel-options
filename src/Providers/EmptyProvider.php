<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @implements Provider<SelectOption>
 */
class EmptyProvider implements Provider
{
    public function provide(): Collection
    {
        return collect();
    }

    public function map(mixed $item): SelectOption
    {
        return $item;
    }

    public function equals(mixed $provided, mixed $userDefined): bool
    {
        return true;
    }
}
