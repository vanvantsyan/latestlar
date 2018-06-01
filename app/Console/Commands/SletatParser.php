<?php

namespace App\Console\Commands;

use App\SletatParser as Parser;
use Illuminate\Console\Command;

class SletatParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sletat:start {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all tours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Parser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case('getAll'):
                $this->parser->getAll();
                break;
        }
    }
}
