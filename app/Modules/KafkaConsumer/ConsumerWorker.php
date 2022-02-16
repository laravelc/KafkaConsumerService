<?php

namespace App\Modules\KafkaConsumer;

use App\Modules\KafkaConsumer\Contracts\IConsumerWorker;
use App\Modules\KafkaConsumer\Logs\LogManagerDaily;
use App\Modules\KafkaConsumer\Processors\Contracts\IProcessor;
use App\Modules\KafkaConsumer\Processors\ProcessorManager;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Psr\SimpleCache\InvalidArgumentException;
use RdKafka\Exception;
use RdKafka\KafkaConsumer;
use RdKafka\Message;


class ConsumerWorker implements IConsumerWorker
{
    /**
     * @var KafkaConsumer Объект консумера из библиотеки
     */
    protected KafkaConsumer $consumer;


    protected bool $autocommit = false;

    /**
     * @var CacheContract Кеширование состояния цикла для управления программой
     */
    protected CacheContract $cache;


    protected int $memoryLimit;

    /**
     * @var LogManagerDaily Менеджер логов
     */
    protected LogManagerDaily $logManager;


    /**
     * @var ProcessorManager $processorManager Менеджер процессоров
     */
    protected ProcessorManager $processorManager;

    /**
     * @var int
     */
    protected int $timeout;


    /**
     * @param ProcessorManager $processorManager
     * @param CacheContract $cache
     * @param LogManagerDaily $logManager
     */
    public function __construct(ProcessorManager $processorManager, CacheContract $cache, LogManagerDaily $logManager)
    {
        $this->cache = $cache;
        $this->processorManager = $processorManager;
        $this->logManager = $logManager;
        $this->consumer = new KafkaConsumer(new Config());
        $this->autocommit = config('kafka.auto_commit');
        $this->memoryLimit = config('kafka.memory_limit', 512);
        $this->timeout = config('kafka.timeout', 200);
    }


    /**
     * Консумер работает
     *
     * @throws \Exception|InvalidArgumentException
     */
    public function work()
    {
        try {
            if (!$this->cache->has('consumer:working') || !$this->cache->get('consumer:working')) {
                $this->cache->forever('consumer:working', true);

                try {
                    $this->consumer->subscribe($this->processorManager->getTopics() ?? []);
                    $this->logManager->info('Старт консумера');

                    while ($this->cache->has('consumer:working')) {
                        $message = $this->consumer->consume( $this->timeout * CarbonInterface::MICROSECONDS_PER_MILLISECOND);

                        switch ($message->err) {
                            //Нет ошибок при чтении
                            case RD_KAFKA_RESP_ERR_NO_ERROR:
                                try {
                                    if ($message->payload) {
                                        /** @var IProcessor $processor */
                                        if ($processor = $this->processorManager->getProcessor($message->topic_name)) {
                                            if (!$processor->process(json_decode($message->payload ?? '', true))) {
                                                break;
                                            }
                                        }
                                    }

                                    if (!$this->autocommit) {
                                        $this->consumer->commit($message);
                                    }
                                } catch (Exception $e) {
                                    $this->sendError($message, $e);
                                }
                                break;
                            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                            case RD_KAFKA_RESP_ERR__TRANSPORT:
                                $this->sendError($message, $e);
                                break;
                            default:
                                $this->sendError($message, $e);

                                throw new \Exception($message->errstr(), $message->err);
                        }

                        if ((memory_get_usage(true) / 1024 / 1024) >= $this->memoryLimit) {
                            $this->stop();
                        }
                    }
                } catch (Exception $e) {
                    $this->sendError($message, $e);

                    throw new \Exception($e->getMessage(), $e->getCode());
                }
            }
        } catch (\Exception) {
            $this->cache->forever('consumer:working', false);
        }
    }


    /**
     * Остановка консумера
     *
     * @return bool
     */
    public function stop(): bool
    {
        $this->cache->forever('consumer:working', false);
        $this->stop();
        return true;
    }

    /**
     * Сообщение об ошибке
     *
     * @param Message $message
     * @param Exception|\Exception $e
     * @return void
     */
    public function sendError(Message $message, Exception|\Exception $e): void
    {
        $this->logManager->error(
            sprintf(
                'Topic [%s] [%s] [%s]',
                $message->topic_name ?? 'Error topic name',
                now()->toIso8601String(),
                $e->getMessage()
            )
        );
    }
}
