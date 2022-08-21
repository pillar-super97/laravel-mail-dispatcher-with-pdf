<?php

namespace App\Http\Controllers\Admin;

// use PDF;
// use Mail;
// use Exception;
// use App\Models\Filter;
use App\Http\Controllers\Controller;
// use Webklex\IMAP\Facades\Client;
// use Webklex\PHPIMAP\Exceptions\AuthFailedException;

use App\Models\Mail;

class InComingController extends Controller
{

    // protected $client;

    // protected $folder;

    // protected $messages;

    public function __construct()
    {
        // $this->client = Client::account('default');

        // while(true) {
        //     $this->checkConnect();
        //     sleep(1000);
        // }
    }

    public function index()
    {
        $paginator = Mail::paginate($perPage = 25);
        return view('admin.mail.mailbox', [
            'paginator' => $paginator
        ]);
    }
    
    public function show(int $UID)
    {
        $_message = Mail::where('uid', $UID)->first();
        return view('admin.mail.show', [
            'message' => $_message
        ]);
    }
}
