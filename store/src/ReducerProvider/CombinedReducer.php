<?php

namespace Gorghoa\Microbux\ReducerProvider;
use Gorghoa\Microbux\Action;

class CombinedReducer implements IReducerProvider {

    private $reducers = [];

    public function configure($options = null) {

    }

    public function reduce(Array $state, Action $action) {

        foreach ($this->reducers as $name => $reducer) {

          if (!isset($state[$name])) {
            $state[$name] = [];
          }

          $state[$name] = $reducer->reduce($state[$name], $action);    
        }

        return $state;
    }

    public function registerReducer(string $name, IReducerProvider $reducer) {
        $this->reducers[$name] = $reducer;
    } 

    public function combine(Array $reducers) {
        foreach($reducers as $name => $reducer) {
            $this->registerReducer($name, $reducer);
        }
    }


}
