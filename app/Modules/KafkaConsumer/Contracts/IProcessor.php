<?php

namespace App\Modules\KafkaConsumer\Processors\Contracts;

interface IProcessor
{
    /**
     * Осуществление деятельности с данными
     * @param object $payload
     * @return int
     */
    public function process(object $payload): int;

    /**
     * Идентификатор сервиса
     * @return string
     */
    public function getTopicName(): string;

    /**
     * Получение информации о сервисе
     *
     * @return string
     */
    public function getInfo(): string;

    /**
     * Имеет ли сервис коллбэк
     * @return bool
     */
    public function hasCallback(): bool;
}
