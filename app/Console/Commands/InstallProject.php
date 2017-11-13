<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install project into this machine';

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
        $this->call('migrate:fresh');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('key:generate');
        $this->call('db:seed');
        
        // $this->call('env');
        // $this->call('inspire');
    }
}
