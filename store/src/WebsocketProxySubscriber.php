<?php

namespace Gorghoa\Microbux;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebsocketProxySubscriber implements MessageComponentInterface, StoreSubscriberInterface {

    private $clients;
    private $lastState;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients->attach($conn);

        if ($this->lastState) {
          $conn->send($this->lastState);
        }

    }


    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }


    /*
     *   Broadcasting state to all connections
     */
    public function send($state) {
        $this->lastState = json_encode($state);
        foreach ($this->clients as $client) {
            $client->send($this->lastState);
        }
    }
}
