<?php

namespace App\Modules\KafkaConsumer\Contracts;

/**
 * Интерфейс объекта логгирования
 */
interface ILog
{
    /**Логи
     * @param string $message Сообщение
     * @return void
     */
    public function info(string $message): void;

    /**Логи
     * @param string $message Ошибка
     * @return void
     */
    public function error(string $message): void;


}
