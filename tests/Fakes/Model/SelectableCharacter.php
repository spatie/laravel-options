<?php

namespace Spatie\LaravelOptions\Tests\Fakes\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelOptions\Selectable;
use Spatie\LaravelOptions\SelectOption;
use Spatie\LaravelOptions\Tests\Database\Factories\CharacterFactory;

class SelectableCharacter extends Model implements Selectable
{
    use HasFactory;
    protected $table = 'characters';

    protected static function newFactory()
    {
        return CharacterFactory::new();
    }

    public function toSelectOption(): SelectOption
    {
        return new SelectOption(
            $this->name,
            $this->id,
            ['kind' => $this->kind]
        );
    }
}
