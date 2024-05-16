<?php

namespace App\Console\Commands;

use App\Models\PortfolioProject;
use Illuminate\Console\Command;

class MyTestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testing';

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
        $projects = PortfolioProject::where('status', 1)
					->with([
						'image',
						'tags',
						// 'mediaContents.content',
					])
					->orderBy('created_at', 'desc')
					->get();
        dd($projects);

    }
}
