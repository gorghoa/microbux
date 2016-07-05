<?php

namespace Gorghoa\Microbux\ReduceTransport;
use Gorghoa\Microbux\ReduceTransportInterface;
use Gorghoa\Microbux\Action;

class DumbReducer implements ReduceTransportInterface
{
    public function configure($options = null) {

    }

    public function reduce($state, Action $action = null) {
        return $state;
    }
}
