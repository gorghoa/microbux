<?php

namespace Gorghoa\Microbux\ReducerProvider;
use Gorghoa\Microbux\Action;

interface IReducerProvider
{

  public function configure($options=null);

  public function reduce(Array $state, Action $action);

}
