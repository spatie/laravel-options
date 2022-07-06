<?php

use Illuminate\Support\Str;
use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\SpatieEnumProvider;
use Spatie\LaravelOptions\Providers\SpatieStateProvider;
use Spatie\LaravelOptions\Tests\Fakes\SpatieEnum\SpatieEnum;
use Spatie\LaravelOptions\Tests\Fakes\SpatieState\FrodoState;
use Spatie\LaravelOptions\Tests\Fakes\SpatieState\MerryState;
use Spatie\LaravelOptions\Tests\Fakes\SpatieState\PippinState;
use Spatie\LaravelOptions\Tests\Fakes\SpatieState\SamState;
use Spatie\LaravelOptions\Tests\Fakes\SpatieState\SpatieState;

it('can create options from a spatie state', function () {
    $options = Options::create(new SpatieStateProvider(SpatieState::class, label: null))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'aragon', 'value' => 'aragon'],
        ['label' => FrodoState::getMorphClass(), 'value' => FrodoState::getMorphClass()],
        ['label' => MerryState::getMorphClass(), 'value' => MerryState::getMorphClass()],
        ['label' => PippinState::getMorphClass(), 'value' => PippinState::getMorphClass()],
        ['label' => SamState::getMorphClass(), 'value' => SamState::getMorphClass()],
    ]);
});

it('can create options from a spatie state using a label field', function () {
    $options = Options::create(new SpatieStateProvider(SpatieState::class, label: 'label'))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'aragon', 'value' => 'aragon'],
        ['label' => 'Frodo', 'value' => FrodoState::getMorphClass()],
        ['label' => MerryState::getMorphClass(), 'value' => MerryState::getMorphClass()],
        ['label' => PippinState::getMorphClass(), 'value' => PippinState::getMorphClass()],
        ['label' => 'Sam', 'value' => SamState::getMorphClass()],
    ]);
});

it('can create options from a spatie state using a different label method', function () {
    $options = Options::create(new SpatieStateProvider(SpatieState::class, label: 'characterLabel'))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'aragon', 'value' => 'aragon'],
        ['label' => FrodoState::getMorphClass(), 'value' => FrodoState::getMorphClass()],
        ['label' => MerryState::getMorphClass(), 'value' => MerryState::getMorphClass()],
        ['label' => 'Pippin', 'value' => PippinState::getMorphClass()],
        ['label' => SamState::getMorphClass(), 'value' => SamState::getMorphClass()],
    ]);
});

it('can create options from a spatie state using a closure', function () {
    $options = Options::create(new SpatieStateProvider(
        SpatieState::class,
        label: fn(SpatieState $state) => Str::of($state::class)->after('Spatie\LaravelOptions\Tests\Fakes\SpatieState\\')->before('State')
    ))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Aragon', 'value' => 'aragon'],
        ['label' => 'Frodo', 'value' => FrodoState::getMorphClass()],
        ['label' => 'Merry', 'value' => MerryState::getMorphClass()],
        ['label' => 'Pippin', 'value' => PippinState::getMorphClass()],
        ['label' => 'Sam', 'value' => SamState::getMorphClass()],
    ]);
});
