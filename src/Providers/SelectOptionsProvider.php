<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\Selectable;
use Spatie\LaravelOptions\SelectOption;
use TypeError;

/**
 * @implements Provider<SelectOption>
 */
class SelectOptionsProvider implements Provider
{
    public function __construct(
        protected readonly array|Collection|SelectOption|Selectable $items,
    ) {
    }

    public function provide(): Collection
    {
        return match (true) {
            $this->items instanceof Selectable => collect([$this->items->toSelectOption()]),
            $this->items instanceof SelectOption => collect([$this->items]),
            $this->items instanceof Collection => $this->items,
            is_array($this->items) => collect($this->items),
            default => throw new TypeError('Unknown select options type')
        };
    }

    public function map(mixed $item): SelectOption
    {
        return $item;
    }

    /**
     * @param SelectOption $provided
     * @param string $userDefined
     */
    public function equals(mixed $provided, mixed $userDefined): bool
    {
        return $provided->value === $userDefined;
    }
}
