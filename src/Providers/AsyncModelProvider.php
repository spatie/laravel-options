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

class AsyncModelProvider extends ModelProvider
{
    /**
     * @param null|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array $models
     */
    public function __construct(
        null|Model|EloquentCollection|Collection|array $models,
        string|Closure|null $label = null,
        string|Closure|null $value = null,
    ) {
        parent::__construct($models ?? [], $label, $value);
    }
}
