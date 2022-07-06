<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\MyClabsEnumProvider;
use Spatie\LaravelOptions\Providers\SpatieEnumProvider;
use Spatie\LaravelOptions\Tests\Fakes\MyclabsEnum\MyClabsEnum;
use Spatie\LaravelOptions\Tests\Fakes\SpatieEnum\SpatieEnum;

it('can create options from a myclabs enum', function () {
    $options = Options::create(new MyClabsEnumProvider(MyClabsEnum::class))->toArray();

    expect($options)->toBeArray()->toBe([
        ['label' => 'Frodo', 'value' => 'frodo'],
        ['label' => 'Sam', 'value' => 'sam'],
        ['label' => 'Merry', 'value' => 'merry'],
        ['label' => 'Pippin', 'value' => 'pippin'],
    ]);
});
