<?php

namespace Gorghoa\Microbux\tests\units\ReducerProvider;

use atoum;

use Gorghoa\Microbux\Action;
use Gorghoa\Microbux\ReducerProvider\{CombinedReducer, DumbReducer, IReducerProvider};

class CombinedReducer extends atoum
{

    public function testReduceWhenNoReducerHasBeenRegistered() {

        $sut = new CombinedReducer();
        $action = new Action('FIRE');

        $state = ['toto'];

        $this->array($sut->reduce($state, $action))
          ->isEqualTo(['toto'])
          ;
    }

    public function testRegisterReducer() {
        $sut = new CombinedReducer();

        $this->given($reducer = new \mock\Gorghoa\Microbux\ReducerProvider\DumbReducer)
                ->and($sut->registerReducer('mock', $reducer))
                ->if($state = $sut->reduce([], new Action('MOCK')))
                ->then
                ->mock($reducer)
                ->call('reduce')
                ->once()

                ->array($state['mock'])
                    ->isEqualTo([])
                ;
    }

}

