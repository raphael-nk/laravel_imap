<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class ImapController extends Controller
{
    private $client;
    private $responses;
    private $folders;

    public function __construct(){
        $this->client = Client::account('default');
        $this->folders = $this->client->getFolders(false);
        $this->responses = [];
    }

    public function fetchFromSpecificEmail(){
        $folder = $this->client->getFolder('INBOX');// Fetch from Inbox only
        $messages = $folder->query()->from('raphael.cs.en@gmail.com')->get();

        foreach($messages as $msg){
            $this->responses[] = [
                "id" => $msg->message_id[0],
                "from" => $msg->getFrom()[0],
                "to" => $msg->getTo()[0],
                "subject" => $msg->getSubject()[0],
                "body" => $msg->getTextBody(),
            ];
        }
        return response()->json($this->responses);
    }

    public function fetchAll(){

        foreach($this->folders as $folder){
            $this->responses[] = $folder->path;
            $messages = $folder->messages()->all()->limit(3, 0)->get();

            foreach($messages as $message){

                $this->responses[][] = [
                    "id" => $message->message_id[0],
                    "subject" => $message->getSubject()[0],
                    "body" => $message->getTextBody()
                ];
            }
        }

        return response()->json($this->responses);
    }

    public function fetchUnseenMessage(){
        foreach($this->folders as $folder){
            $this->responses [] = $folder->path;
            $messages = $folder->query()->unseen()->limit(1, 0)->get();

            foreach($messages as $message){
                $this->responses[][] = [
                    "id" => $message->message_id[0],
                    "subject" => $message->getSubject()[0],
                    "body" => $message->getTextBody()
                ];
            }
        }

        return response()->json($this->responses);
    }

    public function fetchWithSpecificText(){
        $folder = $this->client->getFolder('INBOX');
        $messages = $folder->query()->text('IMAP')->get();

        foreach($messages as $message){
            $this->responses[][] = [
                "id" => $message->message_id[0],
                "subject" => $message->getSubject()[0],
                "body" => $message->getTextBody()
            ];
        }

        return response()->json($this->responses);
    }

    public function fetchSinceSpecificDate(){
        $folder = $this->client->getFolder('INBOX');
        $messages = $folder->query()->since(now()->subDays(3))->get();

        foreach($messages as $message){
            $this->responses[][] = [
                "id" => $message->message_id[0],
                "subject" => $message->getSubject()[0],
                "body" => $message->getTextBody()
            ];
        }

        return response()->json($this->responses);
    }

    // We can serialize all of them
    // since, unseen, text, get....
}
