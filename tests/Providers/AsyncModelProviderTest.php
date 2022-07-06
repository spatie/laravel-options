<?php

use Spatie\LaravelOptions\Options;
use Spatie\LaravelOptions\Providers\AsyncModelProvider;
use Spatie\LaravelOptions\Providers\ModelProvider;
use Spatie\LaravelOptions\Tests\Fakes\Model\Character;

it('can provide null as an async model', function () {
    $options = Options::create(new AsyncModelProvider(null))->toArray();

    expect($options)->toBeArray()->toBe([]);
});
