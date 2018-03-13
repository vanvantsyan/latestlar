<?php

namespace App\Console\Commands;

use App\ToursParser as Parser;
use Illuminate\Console\Command;

class ToursParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:start {action}';

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
            case('parsMany'):
                $this->parser->getMany();
                break;
            case('parsOne'):
                $this->parser->getOne();
                break;
            case('createThumbs'):
                $this->parser->createThumbs();
                break;
            case('insertTagsFromModx'):
                $this->parser->insertTagsFromModx();
                break;
            case('relateWithTypes'):
                $this->parser->relateWithTypes();
                break;
            case('parsHoliday'):
                $this->parser->relateWithHolidays();
        }

    }
}
