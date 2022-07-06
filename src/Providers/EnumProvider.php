<?php

namespace Spatie\LaravelOptions\Providers;

use Closure;
use Spatie\LaravelOptions\SelectOption;

/**
 * @template TValue
 */
abstract class EnumProvider implements Provider
{
    /**
     * @param class-string<TValue> $enum
     */
    public function __construct(
        protected readonly string $enum,
        protected readonly string|Closure|null $label = 'labels'
    ) {
    }

    public function map(mixed $item): SelectOption
    {
        $value = $this->mapValue($item);

        $label = null;

        if ($this->label instanceof Closure) {
            $label = ($this->label)($item);
        }

        if (is_string($this->label) && method_exists($item, $this->label)) {
            $label = forward_static_call([$item, $this->label])[$value] ?? null;
        }

        return new SelectOption($label ?? ucfirst($this->mapDefaultLabel($item)), $value);
    }

    /**
     * @param TValue $item
     *
     * @return string|int
     */
    abstract protected function mapValue(mixed $item): string|int;

    /**
     * @param TValue $item
     *
     * @return string
     */
    abstract protected function mapDefaultLabel(mixed $item): string;
}
