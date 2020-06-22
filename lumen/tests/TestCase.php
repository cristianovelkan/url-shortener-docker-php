<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(
        ExceptionHandler::class,
        new class extends Handler {
            public function __construct() {}
            public function report(Throwable $exception) {}
            public function render($request, Throwable $e) {
                throw $e;
            }
        }
        );
    }
}
