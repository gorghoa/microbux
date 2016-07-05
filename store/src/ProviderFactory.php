<?php

namespace Gorghoa\Microbux;


class ProviderFactory
{
  public static function create(string $type, array $options) {

    $container = [
        'HTTP' => '\Gorghoa\Microbux\ReduceTransport\HttpReducer',
    ];

    $className = $container[$type];
    $reducer = new $className;
    $reducer->configure($options);
    return $reducer;

  }

}
