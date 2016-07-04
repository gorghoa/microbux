<?php

require_once(__DIR__."/vendor/autoload.php");
use React\Stream\BufferedSink;

use Gorghoa\Microbux\Store;
use Gorghoa\Microbux\WebsocketProxySubscriber;
use Gorghoa\Microbux\Action;
use Gorghoa\Microbux\ProviderFactory;
use Gorghoa\Microbux\ReducerProvider\{InSituReducerProvider, CombinedReducer, HttpReducer};
use Gorghoa\Microbux\Middleware\LoggerMiddleware;

$reducer = new CombinedReducer();
$store = new Store($reducer);
$WS = new WebsocketProxySubscriber();
$store->attachMiddleware(new LoggerMiddleware());
$store->attachSubscriber($WS);

$app = function ($request, $response) use ($store, $reducer) {

    $headers = array('Content-Type' => 'application/json');

    switch($request->getPath()) {

      case '/state':
        $data = $store->getState();
        break;

      case '/register':

        BufferedSink::createPromise($request)->then(function ($data) use ($reducer) {
          $data = json_decode($data);
          $newReducer = ProviderFactory::create($data->provider, (array) $data->options);
          $reducer->registerReducer($data->name, $newReducer);
        });
        $data = 'ok';
        break;

      case '/dispatch':
        BufferedSink::createPromise($request)->then(function ($data) use ($store) {

          $data = json_decode($data);
          $action = new Action($data->type, (array) $data->payload);

          try {
            $store->dispatch($action);
            $data = 'OK';
          } catch (RuntimeException $e) {
            $data = "NOK {$e->getMessage()}";
          }
        });
        $data = 'tried';

        break;

      default:
        $data = 'welcome';
        break;
    }

    $response->writeHead(200, $headers);
    $response->end(json_encode($data));

};

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket);

$http->on('request', $app);
$socket->listen(getenv('REACT_PORT') ?? 1337, "0.0.0.0");


$websock = new \React\Socket\Server($loop);
$websock->listen(8001, '0.0.0.0');
$webserver = new \Ratchet\Server\IoServer(
    new \Ratchet\Http\HttpServer(
      new \Ratchet\WebSocket\WsServer(
              $WS
      )
    ),
    $websock
);

$loop->run();
