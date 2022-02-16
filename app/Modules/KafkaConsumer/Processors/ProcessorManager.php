<?php

namespace App\Modules\KafkaConsumer\Processors;

use App\Modules\KafkaConsumer\Contracts\IProcessorManager;
use App\Modules\KafkaConsumer\Processors\Contracts\IProcessor;
use Generator;
use Illuminate\Support\Str;

use function app;
use function config;

class ProcessorManager implements IProcessorManager
{
    /**
     * Получить обработчик
     *
     * @param string $id
     * @return IProcessor|null
     */
    public static function getProcessor(string $id): ?IProcessor
    {
        foreach (config('kafka.processors') as $id2 => $class) {
            if (Str::lower($id2) === Str::lower($id)) {
                return app($class);
            }
        }

        return null;
    }

    /**
     * Получить топики для консумера
     *
     * @return Generator|null
     */
    public static function getTopics(): ?Generator
    {
        foreach (config('kafka.processors') as $class) {
                yield app($class)->getTopicName();
        }
    }
}
