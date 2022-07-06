<?php

namespace Spatie\LaravelOptions\Providers;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @implements Provider<array>
 */
class ArrayProvider implements Provider
{
    public function __construct(
        protected readonly array|Collection $items,
        protected readonly bool $useLabelsAsValue = false
    ) {
    }

    public function provide(): Collection
    {
        $items = $this->items instanceof Collection ? $this->items : collect($this->items);

        if ($this->useLabelsAsValue) {
            $items = $items->combine($items);
        }

        return $items->map(fn($label, $value) => [
            'label' => $label,
            'value' => $value,
        ]);
    }

    public function map(mixed $item): SelectOption
    {
        ['label' => $label, 'value' => $value] = $item;

        return new SelectOption($label, $value);
    }
}
