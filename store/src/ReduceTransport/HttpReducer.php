<?php
namespace Gorghoa\Microbux\ReduceTransport;

use Gorghoa\Microbux\{Action, ReduceTransportInterface};

/**
 * A reducer provider, mostly use for debugging purposes.
 * It is run locally, hence without network or complicated stuff.
 */
class HttpReducer implements ReduceTransportInterface
{
  protected $options;

  public function configure($options = null)
  {
    $this->options = $options;
  }

  public function reduce($state, Action $action) {

    $payload = [
      'state' => $state,
      'action' => $action
    ];

    $data_string = json_encode($payload);

    $ch = curl_init($this->options['base_uri']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $response = curl_exec($ch);

    if(!$response) {
        throw new \Exception(curl_error($ch));
    }

    $result = json_decode($response, true);
    return $result;
  }

}

