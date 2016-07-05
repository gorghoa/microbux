<?php
namespace Gorghoa\Microbux\ReduceTransport;

use Gorghoa\Microbux\ReduceTransportInterface;
use Gorghoa\Microbux\Action;

/**
 * A reducer provider, mostly use for debugging purposes.
 * It is run locally, hence without network or complicated stuff.
 */
class InSituReduceTransport implements ReduceTransportInterface
{

  public function configure($options = null)
  {
  }

  public function reduce(array $state, Action $action) {

    switch($action->type) {

      case 'GERARD_IS_THE_LORD':
        $state['gerard'] = $action->payload;
        return $state;

      case 'INSTRUMENT_PLUGGED':
        return $action->payload;

      case 'ENJOY_YOUR_DRINK':
        return $action->payload;

      default:
        return $state;
    }

  }

}
