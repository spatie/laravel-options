<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\ArrayProvider;

it('can create options from an array', function () {
    $options = Options::forProvider(new ArrayProvider([
        'frodo' => 'Frodo',
        'sam' => 'Sam',
        'merry' => 'Merry',
        'pippin' => 'Pippin',
    ]))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can create options from an array without keys', function () {
    $options = Options::forProvider(new ArrayProvider([
        'Frodo',
        'Sam',
        'Merry',
        'Pippin',
    ], useLabelsAsValue: true))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'Frodo'],
        ['label' => 'Sam', 'value' => 'Sam'],
        ['label' => 'Merry', 'value' => 'Merry'],
        ['label' => 'Pippin', 'value' => 'Pippin'],
    ]);
});

it('can map options from an array with custom keys', function () {
    config([
        'options.label_key' => 'name',
        'options.value_key' => 'id',
    ]);

    $option = (new ArrayProvider([]))->map([
        'name' => 'Frodo',
        'id' => 'frodo',
    ]);

    expect($option->toArray())->toBeArray()->toBe([
        'name' => 'Frodo',
        'id' => 'frodo',
    ]);
});

it('can use only and except on array options', function () {
    $providedOptions = [
        'frodo' => 'Frodo',
        'sam' => 'Sam',
        'merry' => 'Merry',
        'pippin' => 'Pippin',
    ];

    $options = Options::forProvider(new ArrayProvider($providedOptions))
        ->only('sam', 'frodo')
        ->toArray();

    expect($options)->toEqual([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
    ]);

    $options = Options::forProvider(new ArrayProvider($providedOptions))
        ->except('sam', 'frodo')
        ->toArray();

    expect($options)->toEqual([
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can use only and except on array options with custom keys', function () {
    config([
        'options.label_key' => 'name',
        'options.value_key' => 'id',
    ]);

    $providedOptions = [
        'frodo' => 'Frodo',
        'sam' => 'Sam',
        'merry' => 'Merry',
        'pippin' => 'Pippin',
    ];

    $options = Options::forProvider(new ArrayProvider($providedOptions))
        ->only('sam', 'frodo')
        ->toArray();

    expect($options)->toEqual([
        ['name' => 'Frodo', 'id' => 'frodo'],
        ['name' => 'Sam', 'id' => 'sam'],
    ]);

    $options = Options::forProvider(new ArrayProvider($providedOptions))
        ->except('sam', 'frodo')
        ->toArray();

    expect($options)->toEqual([
        ['name' => 'Merry', 'id' => 'merry'],
        ['name' => 'Pippin', 'id' => 'pippin'],
    ]);
});
