<?php

namespace Spatie\LaravelOptions\Tests\Fakes\SpatieEnum;

use Spatie\Enum\Enum;

/**
 * @method static self frodo()
 * @method static self sam()
 * @method static self merry()
 * @method static self pippin()
 */
class SpatieEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'frodo' => 'Frodo',
            'sam' => 'Sam',
            'merry' => 'Merry',
            'pippin' => 'Pippin',
        ];
    }
}
