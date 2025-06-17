<?php

namespace Spatie\LaravelOptions\Providers;

use Closure;
use Illuminate\Support\Collection;
use Spatie\Enum\Enum;
use Spatie\LaravelOptions\SelectOption;

/**
 * @extends  EnumProvider<Enum>
 */
class SpatieEnumProvider extends EnumProvider
{
    public function provide(): Collection
    {
        return collect($this->enum::cases());
    }

    public function map(mixed $item): SelectOption
    {
        $value = $this->mapValue($item);

        $label = match (true) {
            $this->label instanceof Closure => ($this->label)($item),
            default => $this->mapDefaultLabel($item)
        };

        return new SelectOption($label, $value);
    }

    protected function mapValue(mixed $item): string|int
    {
        return $item->value;
    }

    protected function mapDefaultLabel(mixed $item): string
    {
        return $item->label;
    }

    /**
     * @param Enum $provided
     * @param Enum $userDefined
     */
    public function equals(mixed $provided, mixed $userDefined): bool
    {
        return $provided->value === $userDefined->value && $provided::class === $userDefined::class;
    }
}
