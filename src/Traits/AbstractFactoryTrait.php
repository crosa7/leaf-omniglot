<?php

namespace LeafOmniglot\Traits;

use LeafOmniglot\Factory\HandlerFactory;

trait AbstractFactoryTrait
{
    /**
     * @return \LeafOmniglot\Factory\HandlerFactory
     */
    protected function getHandlerFactory(): HandlerFactory
    {
        return new HandlerFactory();
    }
}
