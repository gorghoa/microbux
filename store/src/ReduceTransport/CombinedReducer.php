<?php

namespace Gorghoa\Microbux\ReduceTransport;
use Gorghoa\Microbux\ReduceTransportInterface;
use Gorghoa\Microbux\Action;

class CombinedReducer implements ReduceTransportInterface {

    private $reducers = [];

    public function configure($options = null) {

    }

    public function reduce($state, Action $action) {

        foreach ($this->reducers as $name => $reducer) {

          if (!isset($state[$name])) {
            $state[$name] = null;
          }

          try {
            $state[$name] = $reducer->reduce($state[$name], $action);
          } catch(\Exception $e) {
            var_dump($e->getMessage());
          }
        }

        return $state;
    }

    public function registerReducer(string $name, ReduceTransportInterface $reducer) {
        $this->reducers[$name] = $reducer;
    }

    public function combine(Array $reducers) {
        foreach($reducers as $name => $reducer) {
            $this->registerReducer($name, $reducer);
        }
    }

}
