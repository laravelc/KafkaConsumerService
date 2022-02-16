<?php

namespace App\Modules\KafkaConsumer\Contracts;

use Exception;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Interface IConsumerProcessor
 * @package App\Modules\ConsumerWorker
 */
interface IConsumerWorker
{
    /**
     * Консумер работает
     *
     * @throws Exception|InvalidArgumentException
     */
    public function work();


    /**
     * Остановка консумера
     *
     * @return bool
     */
    public function stop(): bool;

}
