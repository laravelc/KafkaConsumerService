<?php

namespace App\Modules\KafkaConsumer\Processors;


use App\Modules\KafkaConsumer\Processors\Contracts\IProcessor;

class ExampleProcessor implements IProcessor
{
    /**
     * Информация о сервисе
     *
     * @return string
     */
    public function getInfo(): string
    {
        return 'Example Service Info';
    }

    /**
     * Имеет ли коллбэк
     * @return bool
     */
    public function hasCallback(): bool
    {
        return false;
    }

    /**
     * Осуществление деятельности с данными
     * @param object $payload
     * @return int
     */
    public function process(object $payload): int
    {
        return 0;
    }

    /**
     * @return string Идентифицирует класс
     */
    public function getTopicName(): string
    {
        return 'example_service_handler';
    }
}
