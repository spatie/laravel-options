<?php

namespace Spatie\LaravelOptions\Tests\Providers;

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\NativeEnumProvider;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\IntEnum;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\StringEnum;

it('can create options from a string backed enum', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can create options from an int backed enum', function () {
    $options = Options::create(new NativeEnumProvider(IntEnum::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'One', 'value' => 1],
        ['label' => 'Two', 'value' => 2],
        ['label' => 'Three', 'value' => 3],
    ]);
});
