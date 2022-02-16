<?php

namespace App\Modules\KafkaConsumer\Processors\Providers;

use App\Modules\KafkaConsumer\Processors\ExampleProcessor;
use App\Modules\KafkaConsumer\Processors\ProcessorManager;
use Illuminate\Support\ServiceProvider;

class ProcessorProvider extends ServiceProvider
{
    /**
     *   Регистрация сервисов
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProcessorManager::class, function () {
            return new ProcessorManager();
        });

        $this->app->singleton(ExampleProcessor::class, function () {
            return new ExampleProcessor();
        });
    }
}
