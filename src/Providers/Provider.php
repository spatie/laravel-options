<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @template TValue
 */
interface Provider
{
    /** @return Collection<TValue> */
    public function provide(): Collection;

    /**
     * @param TValue $item
     */
    public function map(mixed $item): SelectOption;
}
