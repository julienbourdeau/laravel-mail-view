<?php

namespace Julienbourdeau\LaravelMailView\Tests;

use Orchestra\Testbench\TestCase;
use Julienbourdeau\MailView\LaravelMailViewServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelMailViewServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
