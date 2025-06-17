<?php

namespace Spatie\LaravelOptions\Providers;

use BackedEnum;
use Illuminate\Support\Collection;

/**
 * @extends EnumProvider<BackedEnum>
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

    /**
     * @param BackedEnum $provided
     * @param BackedEnum $userDefined
     */
    public function equals(mixed $provided, mixed $userDefined): bool
    {
        return $provided->value === $userDefined->value && $provided::class === $userDefined::class;
    }
}
