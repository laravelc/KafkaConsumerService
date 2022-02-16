# Сервисы использования Kafka Consumer
Запускает Consumer
```shell
php artisan consumer:work
```

Останавливает Consumer. Необходим для возможностей деплоя с применением супервизора
```shell
php artisan consumer:stop
```
Пространство имен модулей `App\Modules\KafkaConsumer`
