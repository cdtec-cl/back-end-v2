<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Post;

use Exception;
use Illuminate\Console\Command;



/**
 * Class helloWorldCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class HelloWorldCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "helloWorld:kiu";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "HelloWorld";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->info("HelloWorld");            
        } catch (Exception $e) {
            $this->error("No HelloWorld");
        }
    }
}
