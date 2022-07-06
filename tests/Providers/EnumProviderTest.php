<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\NativeEnumProvider;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\StringEnum;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\StringEnumWithLabels;

it('can create labels from a label function', function () {
    $options = Options::create(new NativeEnumProvider(StringEnumWithLabels::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo Baggins', 'value' => 'frodo'],
        ['label' => 'Sam Gamgee', 'value' => 'sam'],
        ['label' => 'Merry Brandybuck', 'value' => 'merry'],
        ['label' => 'Pippin Took', 'value' => 'pippin'],
    ]);
});


it('can create labels from a label closure', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class, fn(StringEnum $enum) => $enum->name. ' Hobbit'))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo Hobbit', 'value' => 'frodo'],
        ['label' => 'Sam Hobbit', 'value' => 'sam'],
        ['label' => 'Merry Hobbit', 'value' => 'merry'],
        ['label' => 'Pippin Hobbit', 'value' => 'pippin'],
    ]);
});
