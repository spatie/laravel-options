<?php

namespace Spatie\LaravelOptions\Providers;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelOptions\SelectOption;
use Spatie\ModelStates\State;
use TypeError;

/**
 * @implements Provider<State>
 */
class SpatieStateProvider implements Provider
{
    /**
     * @param class-string<State>|array<State>|Collection<State> $states
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
            default => throw new TypeError('Unknown select options type')
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

    /**
     * @param State $provided
     * @param State|string $userDefined
     */
    public function equals(mixed $provided, mixed $userDefined): bool
    {
        if($userDefined instanceof State) {
            return $provided->equals($userDefined);
        }

        return $provided::class === $userDefined;
    }
}
