<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LuongImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luong:import {year} {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import luong tu version cu';

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
    public function handle(\App\Services\DatafileService $datafileService)
    {
        $year = $this->argument('year');
        $month = $this->argument('month');

        $datafileService->salaryImport($year, $month);
        return 0;
    }
}
