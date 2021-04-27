<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetUpCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'set:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Set's up project";

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
        $this->call('migrate');
        $this->call('module:seed', [
        'module' => 'Base'
        ]);
        $this->call('module:seed' , [
            'module' => 'Accommodation'
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
