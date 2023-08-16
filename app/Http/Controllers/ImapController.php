<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class ImapController extends Controller
{
    public function fetchAll(){
        $client = Client::account('default');

        $folder = $client->getFolder('INBOX');
        $message = $folder->query()->from('raphael.cs.en@gmail.com')->get();

        foreach($message as $msg){
            $body = $msg->getTextBody();
        }
        return response()->json($body);
    }
}
