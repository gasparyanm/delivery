<?php

namespace App\Console\Commands;

use App\Models\Delivery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class DisplayDeliveries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliveries:display {--count=10 : count of the delivery}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display deliveries info';

    /**
     * @var ConsoleOutput
     */
    private $out;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConsoleOutput $consoleOutput)
    {
        parent::__construct();

        $this->out = $consoleOutput;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Delivery::query()
            ->with('company')
            ->limit($this->option('count'))
            ->get()
            ->map(function (Delivery $delivery) {
                $this->out->writeln([
                    str_repeat('*', 30),
                    '* Delivery Company: ' . $delivery->company->name,
                    '* Price: ' . $delivery->price . ' USD',
                    '* Weight: ' . $delivery->weight . ' Kg.',
                    '* Delivery Cost: ' . $delivery->deliveryCost . ' USD',
                    '* Total:' . ($delivery->price + $delivery->deliveryCost) . ' USD',
                ]);
            });

        $this->out->writeln(str_repeat('*', 30));
    }
}
