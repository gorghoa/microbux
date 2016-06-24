<?php

require_once(__DIR__."/vendor/autoload.php");
use Gorghoa\Microbux\Store;
use Gorghoa\Microbux\Action;
use Gorghoa\Microbux\ProviderFactory;
use Gorghoa\Microbux\ReducerProvider\{InSituReducerProvider, CombinedReducer, HttpReducer};
use React\Stream\BufferedSink;

$reducer = new CombinedReducer();
$store = new Store($reducer);

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
        $action = new Action('INSTRUMENT_PLUGGED', [
                    "name" => "guitar",
                    "owner" => "nitneuk"
                  ]);

        $action = new Action('ENJOY_YOUR_DRINK', [
                    "name" => "mascotte",
                    "type" => "beer"
                  ]);
        $store->dispatch($action);
        $data = 'OK';
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
$loop->run();
