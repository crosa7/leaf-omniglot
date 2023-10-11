<?php

namespace App\src\Traits;

use App\src\Factory\HandlerFactory;

trait AbstractFactoryTrait
{
    /**
     * @return \App\src\Factory\HandlerFactory
     */
    protected function getHandlerFactory(): HandlerFactory
    {
        return new HandlerFactory();
    }
}
