<?php

namespace App\Console\Commands;

use App\Modules\KafkaConsumer\ConsumerWorker;
use App\Modules\Queue\Worker;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Остановить consumer в случает деплоя
 */
class StopConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:stop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Остановка консумера, нужно в случае деплоя. Потом супервизор сам его подлнимает после завершения деплоя';

    /**
     * Consumer
     * @var ConsumerWorker $worker
     */
    private ConsumerWorker $worker;

    /**
     * Create a new queue restart command.
     *
     * @param ConsumerWorker $worker
     */
    public function __construct(ConsumerWorker $worker)
    {
        parent::__construct();
        $this->worker = $worker;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    #[NoReturn] public function handle(): int
    {
        $this->worker->stop();

        return CommandAlias::SUCCESS;
    }
}
