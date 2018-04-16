<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Main console command list';

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
     * @return mixed
     */
    public function handle()
    {
        switch ($this->argument('action')) {

            case('clearAll'):
                $this->call('route:clear');
                $this->call('view:clear');
                $this->call('cache:clear');
        }

    }
}
