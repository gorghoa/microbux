<?php

namespace Gorghoa\Microbux\Middleware;
use Gorghoa\Microbux\MiddlewareInterface;
use Gorghoa\Microbux\Action;

class LoggerMiddleware implements MiddlewareInterface {

  public function preDispatch(array $state, Action $action) {
    echo "\n\n =========== DISPATCHING ACTION =============\n";
    print_r($action);
  }

  public function postDispatch(array $state, Action $action) {
    echo "\n\n =========== STATE AFTER DISPATCH =============\n";
    print_r($state);
  }

}
