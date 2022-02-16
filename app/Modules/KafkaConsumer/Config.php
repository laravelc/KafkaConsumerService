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
        $this->set('group.id', config('kafka.group_id'));
        $this->set('metadata.broker.list', config('kafka.brokers'));
        $this->set('auto.offset.reset', config('kafka.auto_offset_reset'));

        if (config('kafka.security_protocol') === 'SASL_SSL') {
            $this->set('security.protocol', config('kafka.security_protocol'));
            $this->set('sasl.mechanisms', config('kafka.sasl.mechanisms'));
            $this->set('sasl.password', config('kafka.sasl.password'));
            $this->set('sasl.username', config('kafka.sasl.username'));
            $this->set('ssl.certificate.location', config('kafka.ssl.certificate_location'));
            $this->set('ssl.ca.location', config('kafka.ssl.ca_location'));
        }
    }
}