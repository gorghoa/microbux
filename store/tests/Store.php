<?php

namespace Gorghoa\Microbux\tests\units;

use atoum;

use Gorghoa\Microbux\Store;
use Gorghoa\Microbux\ReducerProvider\{IReducerProvider, DumbReducer};

class Store extends atoum
{

    public function initializeReducer() {

      return new DumbReducer();
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

}
