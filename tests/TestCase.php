<?php

namespace Kblais\LaravelHelpers\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/migrations'),
        ]);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback', [
                '--database' => 'testbench',
                '--realpath' => realpath(__DIR__ . '/migrations'),
            ]);
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
