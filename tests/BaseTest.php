<?php

namespace Julienbourdeau\MailView\Tests;

use Orchestra\Testbench\TestCase;
use Julienbourdeau\MailView\MailViewServiceProvider;

class BaseTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [MailViewServiceProvider::class];
    }
}
