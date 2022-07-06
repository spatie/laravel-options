<?php

namespace Spatie\LaravelOptions\Providers;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;
use Spatie\ModelStates\State;

/**
 * @implements Provider<\Spatie\ModelStates\State>
 */
class SpatieStateProvider implements Provider
{
    /**
     * @param class-string<\Spatie\ModelStates\State>|array<\Spatie\ModelStates\State>|\Illuminate\Support\Collection<\Spatie\ModelStates\State> $states
     */
    public function __construct(
        protected readonly string|array|Collection $states,
        protected readonly ?Model $model = null,
        protected readonly string|Closure|null $label = 'label',
    ) {
    }

    public function provide(): Collection
    {
        $states = match (true) {
            is_string($this->states) && is_subclass_of($this->states, State::class) => $this->states::all(),
            is_array($this->states) => collect($this->states),
            $this->states instanceof Collection => $this->states,
        };

        return collect($states)->map(
            fn (State|string $state) => $state instanceof State
            ? $state
            : $this->resolveState($state)
        );
    }

    public function map(mixed $item): SelectOption
    {
        $label = match (true) {
            $this->label instanceof Closure => ($this->label)($item),
            $this->label !== null && method_exists($item, $this->label) => call_user_func([$item, $this->label]),
            $this->label !== null && property_exists($item, $this->label) => $item->{$this->label},
            default => $item::getMorphClass(),
        };

        return new SelectOption($label, $item::getMorphClass());
    }

    protected function resolveState(string $class): State
    {
        $model = $this->model ?? new class () extends Model {
        };

        return new $class($model);
    }
}
