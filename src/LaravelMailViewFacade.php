<?php

namespace Julienbourdeau\LaravelMailView;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Julienbourdeau\LaravelMailView\Skeleton\SkeletonClass
 */
class LaravelMailViewFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-mail-view';
    }
}
