<?php

namespace App\Modules\KafkaConsumer\Providers;

use App\Modules\KafkaConsumer\ConsumerWorker;
use App\Modules\KafkaConsumer\Logs\LogManagerDaily;
use App\Modules\KafkaConsumer\Processors\ProcessorManager;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Support\ServiceProvider;


class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Менеджер логов
        $this->app->singleton(LogManagerDaily::class, function () {
            return new LogManagerDaily();
        });

        //Консумер
        $this->app->singleton(ConsumerWorker::class, function () {
            return new ConsumerWorker(
                app(ProcessorManager::class),
                app(CacheContract::class),
                app(LogManagerDaily::class)
            );
        });
    }
}
