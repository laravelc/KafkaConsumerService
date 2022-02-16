<?php

namespace App\Modules\KafkaConsumer\Contracts;

use App\Modules\KafkaConsumer\Processors\Contracts\IProcessor;
use Generator;

/**
 * Менеджер сервиса
 */
interface IProcessorManager
{
    /**
     * Получить обработчик
     * @param string $id
     * @return IProcessor|null
     */
    public static function getProcessor(string $id): ?IProcessor;

    /**
     * Получить топики для консумера
     *
     * @return Generator|null
     */
    public static function getTopics(): ?Generator;
}
