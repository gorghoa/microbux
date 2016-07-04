<?php
namespace Gorghoa\Microbux\Observer;
use Rx\ObserverInterface;

class DumbObserver implements ObserverInterface
{

  protected $callback;

  public function __construct($x) {
    $this->callback = $x;
  }

  public function onCompleted() {
  }

  public function onError(\Exception $e) {

  }

  public function onNext($data) {
   ($this->callback)($data);
  }

}
