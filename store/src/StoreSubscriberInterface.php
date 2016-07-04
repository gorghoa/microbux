<?php

namespace Gorghoa\Microbux;

interface StoreSubscriberInterface
{
    public function send($state);
}
