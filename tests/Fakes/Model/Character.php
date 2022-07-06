<?php

namespace Spatie\LaravelOptions\Tests\Fakes\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelOptions\Tests\Database\Factories\CharacterFactory;

class Character extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CharacterFactory::new();
    }
}
