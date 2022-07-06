<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\ArrayProvider;
use Spatie\LaravelOptions\Providers\NativeEnumProvider;
use Spatie\LaravelOptions\SelectOption;
use Spatie\LaravelOptions\Tests\Database\Factories\CharacterFactory;
use Spatie\LaravelOptions\Tests\Fakes\Model\Character;
use Spatie\LaravelOptions\Tests\Fakes\Model\SelectableCharacter;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\IntEnum;
use Spatie\LaravelOptions\Tests\Fakes\NativeEnum\StringEnum;

it('can filter options', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->filter(fn(StringEnum $enum) => $enum === StringEnum::Frodo)
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
    ]);
});

it('can reject options', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->reject(fn(StringEnum $enum) => $enum === StringEnum::Frodo)
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('can sort options', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->sort(true)
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
        ['label' => 'Sam', 'value' => 'sam'],
    ]);
});

it('can sort options using closure', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->sort(fn(StringEnum $enum) => match ($enum) {
            StringEnum::Frodo => 4,
            StringEnum::Sam => 3,
            StringEnum::Merry => 2,
            StringEnum::Pippin => 1,
        })
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Pippin', 'value' => 'pippin'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Frodo', 'value' => 'frodo'],
    ]);
});

it('can create unique options', function () {
    $model = Character::factory()->create();

    $nonUniqueOptions = Options::forModels([$model, $model])->toArray();

    expect($nonUniqueOptions)->toBeArray()->toBe([
        ['label' => $model->name, 'value' => $model->id],
        ['label' => $model->name, 'value' => $model->id],
    ]);

    $uniqueOptions = Options::forModels([$model, $model])->unique()->toArray();

    expect($uniqueOptions)->toBeArray()->toBe([
        ['label' => $model->name, 'value' => $model->id],
    ]);
});

it('can create unique options using a closure', function () {
    $model = Character::factory()->create();

    $options = Options::forModels([$model, $model])
        ->unique(fn(Character $character) => $character->getKey())
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => $model->name, 'value' => $model->id],
    ]);
});

it('can add a null option', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->nullable()
        ->sort(fn(StringEnum $enum) => match ($enum) {
            StringEnum::Frodo => 4,
            StringEnum::Sam => 3,
            StringEnum::Merry => 2,
            StringEnum::Pippin => 1,
        })
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => '-', 'value' => null],
        ['label' => 'Pippin', 'value' => 'pippin'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Frodo', 'value' => 'frodo'],
    ]);
});

it('will keep the null option on top when sorting', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->nullable()
        ->sort()
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => '-', 'value' => null],
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
        ['label' => 'Sam', 'value' => 'sam'],
    ]);
});

it('can append data', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->append(['movie' => 'Lord Of The Rings'])
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo', 'movie' => 'Lord Of The Rings'],
        ['label' => 'Sam', 'value' => 'sam', 'movie' => 'Lord Of The Rings'],
        ['label' => 'Merry', 'value' => 'merry', 'movie' => 'Lord Of The Rings'],
        ['label' => 'Pippin', 'value' => 'pippin', 'movie' => 'Lord Of The Rings'],
    ]);
});

it('can append data using closure', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->append(fn(StringEnum $enum) => ['upper' => strtoupper($enum->name)])
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo', 'upper' => 'FRODO'],
        ['label' => 'Sam', 'value' => 'sam', 'upper' => 'SAM'],
        ['label' => 'Merry', 'value' => 'merry', 'upper' => 'MERRY'],
        ['label' => 'Pippin', 'value' => 'pippin', 'upper' => 'PIPPIN'],
    ]);
});

it('can manually add an extra option', function () {
    $options = Options::create(new NativeEnumProvider(StringEnum::class))
        ->push(new SelectOption('Aragon', 'aragon'))
        ->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
        ['label' => 'Aragon', 'value' => 'aragon'],
    ]);
});

it('will use a selectable interface select option if it exists', function () {
    Character::factory()->create(['name' => 'Aragon', 'kind' => 'Men']);

    $options = Options::forModels(SelectableCharacter::class)->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Aragon', 'value' => 1, 'kind' => 'Men'],
    ]);
});

it('will use a selectable interface select option if it exists and can append more information', function () {
    Character::factory()->create(['name' => 'Aragon', 'kind' => 'Men']);

    $options = Options::forModels(SelectableCharacter::class)
        ->append(fn(SelectableCharacter $character) => ['upper_name' => strtoupper($character->name)])
        ->toArray();

    expect($options)->toBeArray()->toBe([
        [
            'label' => 'Aragon',
            'value' => 1,
            'kind' => 'Men',
            'upper_name' => 'ARAGON',
        ],
    ]);
});
