<?php

namespace Gorghoa\Microbux;

use Gorghoa\Microbux\ReducerProvider\IReducerProvider;

class Store {

    protected $state = [];
    protected $reducer;

    public function __construct(IReducerProvider $reducer) {
        $this->replaceReducer($reducer);
    }

    /**
     * @return array the state of the store
     */
    public function getState() {
        return $this->state;
    }

    public function dispatch(Action $action) {
        $this->state = $this->reducer->reduce($this->state, $action);
    }

    public function replaceReducer(IReducerProvider $reducer) {
        $this->reducer = $reducer;
    }

}
