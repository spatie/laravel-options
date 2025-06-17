<?php

namespace Spatie\LaravelOptions;

use Illuminate\Database\Eloquent\Model;

/** @mixin Model */
trait HasSelectOption
{
    /**
     * Override this to customize the select option label / value
     */
    public function toSelectOption(): SelectOption
    {
        return SelectOption::create($this->name ?? $this->getKey(), $this->id);
    }
}
