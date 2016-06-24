<?php
namespace Gorghoa\Microbux\ReducerProvider;

use Gorghoa\Microbux\Action;

/**
 * A reducer provider, mostly use for debugging purposes.
 * It is run locally, hence without network or complicated stuff.
 */
class InSituReducerProvider implements IReducerProvider
{

  public function configure($options = null)
  {
  }

  public function reduce(array $state, Action $action) {

    switch($action->type) {

      case 'INSTRUMENT_PLUGGED':
        return $action->payload;

      case 'ENJOY_YOUR_DRINK':
        return $action->payload;

      default:
        return $state;
    }

  }

}