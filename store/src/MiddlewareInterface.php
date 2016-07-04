<?php
namespace Gorghoa\Microbux;
use Gorghoa\Microbux\Action;

interface MiddlewareInterface {

  public function preDispatch(array $state, Action $action);
  public function postDispatch(array $state, Action $action);

}
