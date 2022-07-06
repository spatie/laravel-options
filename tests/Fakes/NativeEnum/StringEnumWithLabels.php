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
           'frodo' => 'Frodo Baggins',
           'sam' => 'Sam Gamgee',
           'merry' => 'Merry Brandybuck',
           'pippin' => 'Pippin Took',
       ];
    }
}
