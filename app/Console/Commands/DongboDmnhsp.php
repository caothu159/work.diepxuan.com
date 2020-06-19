<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DongboDmnhsp extends Command {
    use \App\Http\Controllers\Work\Factory\DongBoDmsp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dongbo:dmnhsp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dong bo nhom san pham';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //
        $this->dongboDmnhsp();
    }
}
