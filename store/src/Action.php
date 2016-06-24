<?php

namespace Gorghoa\Microbux;
use \JsonSerializable;

final class Action implements JsonSerializable
{

  private $type;
  private $payload;

  public function  __construct($type, $payload = null)
    {
      $this->type = $type;
      $this->payload = $type;
    }

  public function  __get(string $name) {
        switch($name) {
          case 'type':
            return $this->type;

          case 'payload':
            return $this->payload;
        }
  }

  public function jsonSerialize() {
    return [
        'type' => $this->type,
        'payload' => $this->payload
    ];
  }

}
