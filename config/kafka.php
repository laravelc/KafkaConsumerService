<?php

use App\Modules\KafkaConsumer\Processors\ExampleProcessor;
use Illuminate\Support\Str;

return [
    'processors' => [
        'example_processor' => ExampleProcessor::class,
    ],

    'timeout' => env('KAFKA_TIMEOUT', 200),
    'memory_limit' => 128,
    'auto_commit' => env('KAFKA_AUTOCOMMIT', false),
    'group_id' => env('KAFKA_GROUP_ID', Str::random(8)),
    'brokers' => env('KAFKA_BROKERS', ''),
    'auto_offset_reset' => env('KAFKA_OFFSET_RESET', 'smallest'),
    'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', ''),
    'sasl' => [
        'mechanisms' => env('KAFKA_SASL_MECHANISMS', 'SCRAM-SHA-256'),
        'password' => env('KAFKA_SASL_PASSWORD', ''),
        'username' => env('KAFKA_SASL_USERNAME', ''),
    ],
    'ssl' => [
        'ca_location' => env('KAFKA_SSL_CA_LOCATION', ''),
        'certificate_location' => env('KAFKA_SSL_CERTIFICATE_LOCATION', ''),
    ],
];
