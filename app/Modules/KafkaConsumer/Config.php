<?php

namespace App\Modules\KafkaConsumer;

use RdKafka\Conf;

/**
 * Объект конфигурации
 */
class Config extends Conf
{
    public function __construct()
    {
        $this->init();
    }

    /**
     * Инициализация переменных
     *
     * @return void
     */
    private function init()
    {
        $this->set('group.id', config('kafka-consumer.group_id'));
        $this->set('metadata.broker.list', config('kafka-consumer.brokers'));
        $this->set('auto.offset.reset', config('kafka-consumer.auto_offset_reset'));

        if (config('kafka-consumer.security_protocol') === 'SASL_SSL') {
            $this->set('security.protocol', config('kafka-consumer.security_protocol'));
            $this->set('sasl.mechanisms', config('kafka-consumer.sasl.mechanisms'));
            $this->set('sasl.password', config('kafka-consumer.sasl.password'));
            $this->set('sasl.username', config('kafka-consumer.sasl.username'));
            $this->set('ssl.certificate.location', config('kafka-consumer.ssl.certificate_location'));
            $this->set('ssl.ca.location', config('kafka-consumer.ssl.ca_location'));
        }
    }
}