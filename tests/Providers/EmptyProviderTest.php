<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\ArrayProvider;
use Spatie\LaravelOptions\Providers\EmptyProvider;

it('can have empty options', function () {
    $options = Options::forProvider(new EmptyProvider())->toArray();

    expect($options)->toBeArray()->toBe([]);
});
