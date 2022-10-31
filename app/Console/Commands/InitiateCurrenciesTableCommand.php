<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Product\Entities\Currency;

class InitiateCurrenciesTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initiate:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Currency::query()->truncate();

        // dollar
        Currency::query()
            ->create([
                'title_fa' => 'دلار',
                'title_en' => 'USD',
                'sign' => '$',
                'golden_package_price' => '27000',
                'silver_package_price' => '28000',
                'bronze_package_price' => '29000',
            ]);

        // euro
        Currency::query()
            ->create([
                'title_fa' => 'یورو',
                'title_en' => 'EUR',
                'sign' => '€',
                'golden_package_price' => '27000',
                'silver_package_price' => '28000',
                'bronze_package_price' => '29000',
            ]);

        // pound

        Currency::query()
            ->create([
                'title_fa' => 'پوند',
                'title_en' => 'GBP',
                'sign' => '£',
                'golden_package_price' => '27000',
                'silver_package_price' => '28000',
                'bronze_package_price' => '29000',
            ]);
    }
}
