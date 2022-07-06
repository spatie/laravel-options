<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\MyClabsEnumProvider;
use Spatie\LaravelOptions\Tests\Fakes\MyclabsEnum\MyClabsEnum;
use Spatie\LaravelOptions\Tests\Fakes\MyclabsEnum\MyClabsEnumHumanLabels;

it('can create options from a myclabs enum', function () {
    $options = Options::create(new MyClabsEnumProvider(MyClabsEnum::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});

it('will humanize a myclabs enum label by default', function () {
    $options = Options::create(new MyClabsEnumProvider(MyClabsEnumHumanLabels::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam gamgee', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});
