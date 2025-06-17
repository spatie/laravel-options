<?php

use Illuminate\Database\Eloquent\Factories\Sequence;
use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\ModelProvider;
use Spatie\LaravelOptions\Tests\Fakes\Model\Character;

beforeEach(fn () => Character::factory()
    ->count(5)
    ->state(new Sequence(
        ['name' => 'Frodo', 'id' => 1],
        ['name' => 'Sam', 'id' => 2],
        ['name' => 'Merry', 'id' => 3],
        ['name' => 'Pippin', 'id' => 4],
        ['name' => 'Aragon', 'kind' => 'men', 'id' => 5],
    ))
    ->create());

it('can create options from a model', function () {
    $options = Options::forProvider(new ModelProvider(Character::first()))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 1],
    ]);
});

it('can create options from a model kind', function () {
    $options = Options::forProvider(new ModelProvider(Character::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 1],
        ['label' => 'Sam', 'value' => 2],
        ['label' => 'Merry', 'value' => 3],
        ['label' => 'Pippin', 'value' => 4],
        ['label' => 'Aragon', 'value' => 5],
    ]);
});

it('can create options from an array of models', function () {
    $options = Options::forProvider(new ModelProvider([
        Character::find(1),
        Character::find(2),
    ]))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 1],
        ['label' => 'Sam', 'value' => 2],
    ]);
});

it('can create options from a collection of models', function () {
    $options = Options::forProvider(new ModelProvider(collect([
        Character::find(1),
        Character::find(2),
    ])))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 1],
        ['label' => 'Sam', 'value' => 2],
    ]);
});

it('can create options from an eloquent collection of models', function () {
    $options = Options::forProvider(new ModelProvider(Character::query()->where('kind', 'men')->get()))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Aragon', 'value' => 5],
    ]);
});

it('can create options from an eloquent builder', function () {
    $options = Options::forProvider(new ModelProvider(Character::query()->where('kind', 'men')))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Aragon', 'value' => 5],
    ]);
});

it('can use another field as label', function () {
    $options = Options::forProvider(new ModelProvider(
        Character::first(),
        label: 'kind',
    ))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'hobbit', 'value' => 1],
    ]);
});

it('can use a closure as label', function () {
    $options = Options::forProvider(new ModelProvider(
        Character::first(),
        label: fn (Character $character) => strtoupper($character->name),
    ))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'FRODO', 'value' => 1],
    ]);
});

it('can use another field as value', function () {
    $options = Options::forProvider(new ModelProvider(
        Character::first(),
        value: 'kind',
    ))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'hobbit'],
    ]);
});

it('can use a closure as value', function () {
    $options = Options::forProvider(new ModelProvider(
        Character::first(),
        value: fn (Character $character) => md5($character->name),
    ))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => md5(Character::first()->name)],
    ]);
});


it('can use only and except on model options', function () {
    $options = Options::forProvider(new ModelProvider(Character::query()))
        ->only(...Character::query()->whereIn('name', ['Frodo', 'Sam'])->get())
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 1],
        ['label' => 'Sam', 'value' => 2],
    ]);

    $options = Options::forProvider(new ModelProvider(Character::query()))
        ->except(...Character::query()->whereIn('name', ['Frodo', 'Sam'])->get())
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Merry', 'value' => 3],
        ['label' => 'Pippin', 'value' => 4],
        ['label' => 'Aragon', 'value' => 5],
    ]);
});
