<?php

namespace Spatie\LaravelOptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class SelectOption implements Arrayable, Jsonable
{
    public function __construct(public string $label, public string | int | null $value, protected array $extra = [])
    {
    }

    public static function create(string $label, string | int $value, array $extra = []): self
    {
        return new self($label, $value, $extra);
    }

    public function toArray(): array
    {
        return array_merge([
            'label' => $this->label,
            'value' => $this->value,
        ], $this->extra);
    }

    public function extra(array $extra): self
    {
        $this->extra = array_merge($this->extra, $extra);

        return $this;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
