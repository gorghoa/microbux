<?php

namespace Gorghoa\Microbux;
use Gorghoa\Microbux\Action;

interface ReduceTransportInterface
{

  public function configure($options=null);
  public function reduce($state, Action $action);

}
