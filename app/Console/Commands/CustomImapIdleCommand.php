<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Commands\ImapIdleCommand;
use Webklex\PHPIMAP\Message;

class CustomImapIdleCommand extends ImapIdleCommand
//Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check'; //custom command

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable the app to check email and do operation';

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
        $this->info("test");
        return 0;
    }

    public function onNewMessage(Message $message) {
        $this->info("New message received: " . $message->subject);
    }
}
