<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\UserSeeder;
use Database\Seeders\RegionSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\SourceSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\PrioritySeeder;
use Database\Seeders\RequestSeeder;
use Database\Seeders\GroupUserSeeder;

class Demo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dm:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding for demonstration';

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
        $type = 'demo';
        $UserSeeder = new UserSeeder();
        $RegionSeeder = new RegionSeeder();
        $GroupSeeder = new GroupSeeder();
        $StatusSeeder = new StatusSeeder();
        $SourceSeeder = new SourceSeeder();
        $ContactSeeder = new ContactSeeder();
        $PrioritySeeder = new PrioritySeeder();
        $RequestSeeder = new RequestSeeder();
        $GroupUserSeeder = new GroupUserSeeder();
        $this->call('migrate:refresh');
        $UserSeeder->run($type);
        $RegionSeeder->run($type);
        $StatusSeeder->run($type);
        $SourceSeeder->run($type);
        $ContactSeeder->run($type);
        $GroupSeeder->run($type);
        $PrioritySeeder->run($type);
        $RequestSeeder->run($type);
        $GroupUserSeeder->run($type);
        return 0;
    }
}
