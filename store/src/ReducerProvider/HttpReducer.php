<?php
namespace Gorghoa\Microbux\ReducerProvider;

use Gorghoa\Microbux\{Action, ReducerProviderInterface};
use GuzzleHttp\Client;

/**
 * A reducer provider, mostly use for debugging purposes.
 * It is run locally, hence without network or complicated stuff.
 */
class HttpReducer implements ReducerProviderInterface
{
  protected $options;

  public function configure($options = null)
  {
    $this->options = $options;
  }

  public function reduce(array $state, Action $action) {

    $payload = json_encode($action);
    $client = new Client($this->options);

    $response = $client->request('GET', '', [
        'json' =>  $action
    ]);

    return json_decode($response->getBody());
  }

}

