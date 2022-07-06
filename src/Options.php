<?php

namespace Spatie\LaravelOptions;

use Closure;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use JsonSerializable;
use MyCLabs\Enum\Enum as MyclabsEnum;
use Spatie\Enum\Enum as SpatieEnum;
use Spatie\LaravelOptions\Providers\ArrayProvider;
use Spatie\LaravelOptions\Providers\AsyncModelProvider;
use Spatie\LaravelOptions\Providers\ModelProvider;
use Spatie\LaravelOptions\Providers\MyClabsEnumProvider;
use Spatie\LaravelOptions\Providers\NativeEnumProvider;
use Spatie\LaravelOptions\Providers\Provider;
use Spatie\LaravelOptions\Providers\SelectOptionsProvider;
use Spatie\LaravelOptions\Providers\SpatieEnumProvider;
use Spatie\LaravelOptions\Providers\SpatieStateProvider;
use Stringable;

class Options implements Arrayable, Jsonable, JsonSerializable, Stringable
{
    protected Closure|bool|null $unique = null;

    protected Closure|bool|null $sort = null;

    protected ?bool $nullable = null;

    protected ?Closure $reject = null;

    protected ?Closure $filter = null;

    protected Closure|array|null $append = null;

    protected ?string $nullableLabel = '-';

    protected array $pushedOptions = [];

    public static function create(Provider $provider): self
    {
        return new self($provider);
    }

    public static function forArray(
        array|Collection $items,
        bool $useLabelsAsValue = false
    ): self {
        return new self(new ArrayProvider($items, $useLabelsAsValue));
    }

    public static function forEnum(
        string $enum,
        string|Closure|null $label = 'labels'
    ): self {
        return new self(match (true) {
            enum_exists($enum) => new NativeEnumProvider($enum, $label),
            is_subclass_of($enum, SpatieEnum::class) => new SpatieEnumProvider($enum, $label),
            is_subclass_of($enum, MyclabsEnum::class) => new MyClabsEnumProvider($enum, $label),
            default => throw new Exception('Unknown enum type'),
        });
    }

    public static function forModels(
        string|Model|EloquentBuilder|EloquentCollection|Collection|Relation|array $models,
        string|Closure|null $label = null,
        string|Closure|null $value = null,
    ): self {
        return new self(new ModelProvider($models, $label, $value));
    }

    public static function forAsyncModels(
        null|Model|EloquentCollection|Collection|array $models,
        string|Closure|null $label = null,
        string|Closure|null $value = null,
    ): self {
        return new self(new AsyncModelProvider($models, $label, $value));
    }

    public static function forStates(
        string|array|Collection $states,
        ?Model $model = null,
        string|Closure|null $label = 'label',
    ): self {
        return new self(new SpatieStateProvider($states, $model, $label));
    }

    public static function forSelectOptions(
        array|Collection|SelectOption $options,
    ): self {
        return new self(new SelectOptionsProvider($options));
    }

    public static function forSelectableOptions(
        array|Collection|SelectOption $options,
    ): self {
        return new self(new SelectOptionsProvider($options));
    }

    public function __construct(protected readonly Provider $provider)
    {
    }

    public function reject(Closure $reject): static
    {
        $this->reject = $reject;

        return $this;
    }

    public function filter(Closure $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function append(Closure|array $append): static
    {
        $this->append = $append;

        return $this;
    }

    public function unique(bool|Closure $unique = true): self
    {
        $this->unique = $unique;

        return $this;
    }

    public function sort(bool|Closure $sort = true): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function nullable(string $label = '-', bool $nullable = true): self
    {
        $this->nullableLabel = $label;
        $this->nullable = $nullable;

        return $this;
    }

    public function push(SelectOption ...$options): self
    {
        $this->pushedOptions = array_merge($this->pushedOptions, $options);

        return $this;
    }

    public function toArray(): array
    {
        return $this->provider
            ->provide()
            ->when($this->filter instanceof Closure, fn(Collection $collection) => $collection->filter($this->filter))
            ->when($this->reject instanceof Closure, fn(Collection $collection) => $collection->reject($this->reject))
            ->when($this->sort instanceof Closure, fn(Collection $collection) => $collection->sortBy($this->sort))
            ->when($this->unique instanceof Closure, fn(Collection $collection) => $collection->unique($this->sort))
            ->map(function (mixed $item) {
                $option = $item instanceof Selectable
                    ? $item->toSelectOption()
                    : $this->provider->map($item);

                if (is_array($this->append)) {
                    $option->extra($this->append);
                }

                if ($this->append instanceof Closure) {
                    $option->extra(($this->append)($item));
                }

                return $option;
            })
            ->when($this->unique === true, fn(Collection $collection) => $collection->unique(
                fn(SelectOption $option) => $option->value
            ))
            ->push(...$this->pushedOptions)
            ->when($this->sort === true, fn(Collection $collection) => $collection->sortBy(
                fn(SelectOption $option) => $option->label
            ))
            ->values()
            ->when(
                $this->nullable === true,
                fn(Collection $collection) => $collection->prepend(new SelectOption(
                    $this->nullableLabel,
                    null
                ))
            )
            ->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this, flags: JSON_THROW_ON_ERROR);
    }

    public function __toString()
    {
        return json_encode($this, flags: JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
