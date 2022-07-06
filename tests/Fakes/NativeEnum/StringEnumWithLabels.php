<?php

namespace Spatie\LaravelOptions\Tests\Fakes\NativeEnum;

enum StringEnumWithLabels: string
{
    case Frodo = 'frodo';
    case Sam = 'sam';
    case Merry = 'merry';
    case Pippin = 'pippin';

    public static function labels(): array
    {
       return [
           'frodo' => 'Frodo Hobbit',
           'sam' => 'Sam Hobbit',
           'merry' => 'Merry Hobbit',
           'pippin' => 'Pippin Hobbit',
       ];
    }
}
