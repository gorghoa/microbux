<?php

namespace Gorghoa\Microbux\ReducerProvider;
use Gorghoa\Microbux\ReducerProviderInterface;
use Gorghoa\Microbux\Action;

class DumbReducer implements ReducerProviderInterface
{
    public function configure($options = null) {

    }

    public function reduce(array $state, Action $action = null) {
        return $state;
    }
}
