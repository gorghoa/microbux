<?php

namespace Gorghoa\Microbux\ReducerProvider;
use Gorghoa\Microbux\Action;

class DumbReducer implements IReducerProvider
{
    public function configure($options = null) {

    }

    public function reduce(array $state, Action $action = null) {
        return $state;
    }
}
