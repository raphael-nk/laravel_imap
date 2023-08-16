<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class ImapTest extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'mail:fetch';

    /**
     * The console command description.
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = Client::account("default");
        $client->connect();

        // $folders = $client->getFolders(false);

        // Get specific folder
        $folders = $client->getFolder('INBOX');  // get the read inbox

        foreach($folders as $folder){
            $this->info("Acces folder: ".$folder->path);
            $messages = $folder->messages()->all()->limit(1, 0)->get();

            $this->info("Number of messages: ".$messages->count());

            foreach ($messages as $message) {
                $this->info("\tMessage: ".$message->message_id);
                $this->info("\tSubject: ".$message->getSubject());
                $this->info("\tBody: ".$message->getHTMLBody(true));
            }
        }
        // $message = $folders->query()->all()->get(); // Get all messages from the INBOX
        // $message = $folders->query()->text('IMAP')->get();

        // $this->info($message);

        return 0;
    }
}
