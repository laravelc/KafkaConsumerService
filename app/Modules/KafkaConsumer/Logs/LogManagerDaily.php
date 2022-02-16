<?php

namespace App\Modules\KafkaConsumer\Logs;

use App\Modules\KafkaConsumer\Contracts\ILog;
use Illuminate\Support\Facades\Log;

/**
 * Менеджер логов
 */
class LogManagerDaily implements ILog
{
    /** Сообщение
     * @param string $message Сообщение
     * @return void
     */
    public function info(string $message): void
    {
        Log::channel('daily')->info($message);
    }

    /** Ошибка
     * @param string $message Сообщение
     * @return void
     */
    public function error(string $message): void
    {
        Log::channel('daily')->info($message);
    }
}
