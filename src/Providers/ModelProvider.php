<?php

namespace Spatie\LaravelOptions\Providers;

use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;

/**
 * @implements Provider<Model>
 */
class ModelProvider implements Provider
{
    /**
     * @param class-string<Model>|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Relations\Relation|array $models
     */
    public function __construct(
        protected readonly string|Model|EloquentBuilder|EloquentCollection|Collection|Relation|array $models,
        protected readonly string|Closure|null $label = null,
        protected readonly string|Closure|null $value = null,
    ) {
    }

    public function provide(): Collection
    {
        return match (true) {
            is_string($this->models) => $this->models::all(),
            $this->models instanceof Model => collect([$this->models]),
            is_array($this->models) => collect($this->models),
            $this->models instanceof EloquentCollection => $this->models->toBase(),
            $this->models instanceof Collection => $this->models,
            $this->models instanceof EloquentBuilder, $this->models instanceof Relation => $this->models->get(),
        };
    }

    public function map(mixed $item): SelectOption
    {
        $label = match (true){
            $this->label === null => $item->name,
            is_string($this->label) => $item->{$this->label},
            $this->label instanceof Closure => ($this->label)($item)
        };

        $value = match (true){
            $this->value === null => $item->getKey(),
            is_string($this->value) => $item->{$this->value},
            $this->value instanceof Closure => ($this->value)($item)
        };

        return new SelectOption($label, $value);
    }
}
