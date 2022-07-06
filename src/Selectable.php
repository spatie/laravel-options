<?php

namespace Spatie\LaravelOptions;

interface Selectable
{
    public function toSelectOption(): SelectOption;
}
