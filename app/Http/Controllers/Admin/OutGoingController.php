<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;

class OutGoingController extends Controller
{

    protected $client;

    protected $folder;

    protected $messages;

    public function __construct()
    {
        $this->client = Client::account('default');
    }

    public function index()
    {
        try {
            $this->checkConnect();
            $paginator = $this->messages->paginate($per_page = 25, $page = null, $page_name = 'imap_page');
        }catch (AuthFailedException $e){
            return view('admin.mail.error', [
                'error' => 'Failed to authenticate...'
            ]);
        }catch (Exception $e) {
            return view('admin.mail.error', [
                'error' => 'Failed to connect and gathering data...'
            ]);
        }
        return view('admin.mail.sent', [
            'paginator' => $paginator
        ]);
    }

    public function show(int $UID)
    {

        return view('admin.mail.show', [
            'message' => $this->getItemById($UID)
        ]);
    }

    public function getItemById(int $UID)
    {
        try {
            $this->checkConnect();
        } catch (Exception $e) {
            return view('admin.mail.error', [
                'error' => 'Failed to connect and gathering data...'
            ]);
        }
        foreach ($this->messages as $oMessage) {
            if ($UID == $oMessage->getUid()) {
                return $oMessage;
            }
        }
    }

    public function checkConnect()
    {
        if (!$this->client->isConnected()) {
            $this->client->connect();
            $this->folder = $this->client->getFolderByName('Sent');
            $this->messages = $this->folder->messages()->all()->get();
        }
    }
}
