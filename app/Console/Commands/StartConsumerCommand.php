<?php

namespace App\Console\Commands;

use App\Modules\KafkaConsumer\ConsumerWorker;
use App\Modules\Queue\Worker;
use Illuminate\Console\Command;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Создать очередь сообщений
 */
class StartConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать очередь сообщений';

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
     * @throws InvalidArgumentException
     */
    public function handle(): int
    {
        $this->worker->work();

        return CommandAlias::SUCCESS;
    }
}
