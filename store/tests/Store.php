<?php

namespace Gorghoa\Microbux\tests\units;

use atoum;

use Gorghoa\Microbux\Store;
use Gorghoa\Microbux\Action;
use Gorghoa\Microbux\ReducerProviderInterface;
use Gorghoa\Microbux\Observer\DumbObserver;

class Store extends atoum
{

    public function initializeReducer() {

      $reducer = new \mock\Gorghoa\Microbux\ReducerProviderInterface();
      $reducer->getMockController()->reduce = function($state) {
        return ['geronimo'];
      };

      return $reducer;
    }

    /**
     * It should initialize with an empty state
     */
    public function testConstruct() {

        $sut = new Store($this->initializeReducer());
        $this->array($sut->getState())
          ->isEqualTo([])
          ;
    }

    public function testMiddleware() {

        $sut = new Store($this->initializeReducer());
        $action = new Action('TEST');

        $mocky = new \mock\Gorghoa\Microbux\MiddlewareInterface();
        $sut->attachMiddleware($mocky);

        $sut->dispatch($action);

        $this->mock($mocky)
                ->call('preDispatch')
                  ->once()
                ->call('postDispatch')
                  ->once()
                  ;

    }

    public function testDisptach() {

        $sut = new Store($this->initializeReducer());
        $action = new Action('TEST');

        $this->array($sut->getState())
            ->isEqualTo([])
            ;

        $that = $this;
        $observer = new \mock\Rx\ObserverInterface;
        $observer->getMockController()->onNext = function($x) use ($that) {
            $that->array($x)
                ->isEqualTo([])
                ;
        };
        $sut->take(1)->subscribe($observer);

        $sut->dispatch($action);

        $observer = new \mock\Rx\ObserverInterface;
        $observer->getMockController()->onNext = function($x) use ($that) {
            $that->array($x)
                ->isEqualTo(['geronimo'])
                ;
        };
        $sut->take(1)->subscribe($observer);

    }

}
