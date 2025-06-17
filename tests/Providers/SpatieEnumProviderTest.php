<?php

namespace Spatie\LaravelOptions\Tests\Providers;

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\SpatieEnumProvider;
use Spatie\LaravelOptions\Tests\Fakes\SpatieEnum\SpatieEnum;

it('can create options from a spatie enum', function () {
    $options = Options::forProvider(new SpatieEnumProvider(SpatieEnum::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can use only and except on spatie enums', function () {
    $options = Options::forProvider(new SpatieEnumProvider(SpatieEnum::class))
        ->only(SpatieEnum::frodo(), SpatieEnum::sam())
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
    ]);

    $options = Options::forProvider(new SpatieEnumProvider(SpatieEnum::class))
        ->except(SpatieEnum::frodo(), SpatieEnum::sam())
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});
