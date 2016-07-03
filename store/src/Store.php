<?php

namespace Gorghoa\Microbux;

use Gorghoa\Microbux\ReducerProviderInterface;
use RuntimeException;
use Gorghoa\Microbux\MiddlewareInterface;
use Rx\Subject\BehaviorSubject;


class Store extends BehaviorSubject {

    protected $state = [];
    protected $subscribers = [];
    protected $middlewares =[];
    protected $reducer;

    public function __construct(ReducerProviderInterface $reducer) {
        $this->replaceReducer($reducer);
        parent::onNext($this->state);
        $this->subscribe(new \Rx\Observer\CallbackObserver(function($state) {
            $this->sendStateToSubscribers($state);
        }));
    }

    public function getState(): array {
        return $this->state;
    }

    public function dispatch(Action $action) {

        foreach ($this->middlewares as $middleware) {
            $middleware->preDispatch($this->state, $action);
        }

        $this->state = $this->reducer->reduce($this->state, $action);

        parent::onNext($this->state);

        foreach ($this->middlewares as $middleware) {
            $middleware->postDispatch($this->state, $action);
        }

    }

    public function replaceReducer(ReducerProviderInterface $reducer) {
        $this->reducer = $reducer;
    }


    public function attachSubscriber(StoreSubscriberInterface $subscriber) {
        $this->subscribers[] = $subscriber;
    }

    private function sendStateToSubscribers($state) {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->send($state);
        }
    }


    /**
     * Ok ok, not proud of this.
     *
     * @deprecated
     * @throw RuntimeException
     */
    public function onNext($value) {
      throw new RuntimeException("onNext is forbidden. Use dispatch instead.");
    }

    public function attachMiddleware(MiddlewareInterface  $middleware) {
        $this->middlewares[] = $middleware;
    }

}
