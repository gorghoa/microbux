<?php

namespace Gorghoa\Microbux;
use Gorghoa\Microbux\Action;

interface ReducerProviderInterface
{

  public function configure($options=null);
  public function reduce(Array $state, Action $action);

}
