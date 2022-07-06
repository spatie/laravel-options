<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\ArrayProvider;
use Spatie\LaravelOptions\Providers\SelectOptionsProvider;
use Spatie\LaravelOptions\SelectOption;
use Spatie\LaravelOptions\Tests\Fakes\Selectable\SelectableImplementation;

it('can create options from a select option', function () {
    $options = Options::create(new SelectOptionsProvider(new SelectOption('Frodo', 'frodo')))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
    ]);
});

it('can create options from an array of select options', function () {
    $options = Options::create(new SelectOptionsProvider([
        new SelectOption('Frodo', 'frodo'),
        new SelectOption('Sam', 'sam'),
        new SelectOption('Merry', 'merry'),
        new SelectOption('Pippin', 'pippin'),
    ]))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can create options from an collection of select options', function () {
    $options = Options::create(new SelectOptionsProvider(collect([
        new SelectOption('Frodo', 'frodo'),
        new SelectOption('Sam', 'sam'),
        new SelectOption('Merry', 'merry'),
        new SelectOption('Pippin', 'pippin'),
    ])))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can create options from a selectable', function () {
    $options = Options::create(new SelectOptionsProvider(new SelectableImplementation('Frodo', 'frodo')))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
    ]);
});

it('can create options from a selectable array', function () {
    $options = Options::create(new SelectOptionsProvider([
        new SelectableImplementation('Frodo', 'frodo'),
        new SelectableImplementation('Sam', 'sam'),
        new SelectableImplementation('Merry', 'merry'),
        new SelectableImplementation('Pippin', 'pippin'),
    ]))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can create options from a selectable collection', function () {
    $options = Options::create(new SelectOptionsProvider(collect([
        new SelectableImplementation('Frodo', 'frodo'),
        new SelectableImplementation('Sam', 'sam'),
        new SelectableImplementation('Merry', 'merry'),
        new SelectableImplementation('Pippin', 'pippin'),
    ])))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});
