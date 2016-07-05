<?php
/**
 * Very simple reducer (as it should be) responsible to pigeonhole the members of the weasley family
 */

$data = json_decode(file_get_contents('php://input'), true);

trigger_error(var_export($data, true));

$initialData = [
    'Molly' => 'HOME',
    'Arthur' => 'HOME',
    'Charlie' => 'HOME',
    'Bill' => 'HOME',
    'Percy' => 'HOME',
    'Fred' => 'HOME',
    'Georges' => 'HOME',
    'Ron' => 'HOME',
    'Ginny' => 'HOME',
  ];

$state = $data['state'] ?? $initialData;
$action = $data['action'];

function reduce(array $state, array $action) {

  $type = $action['type'];
  $payload = $action['payload'] ?? null;

  switch($type) {

    case 'WEASLEY_UPDATE':
      $weasley = $payload['weasley'];
      $place = $payload['place'];
      $state[$weasley] = $place;
      return $state;

    default:
      return $state;
  }

}


die(json_encode(reduce($state, $action)));
