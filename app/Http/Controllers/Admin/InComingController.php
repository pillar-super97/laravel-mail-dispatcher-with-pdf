<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Mail;
use Exception;
use App\Models\Filter;
use App\Http\Controllers\Controller;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;

use App\Models\Mail as Inbox;

class InComingController extends Controller
{

    protected $client;

    protected $folder;

    protected $messages;

    public function __construct()
    {
        $this->client = Client::account('default');

        // while(true) {
        //     $this->checkConnect();
        //     sleep(1000);
        // }
    }

    public function index()
    {
        try {
            $this->checkConnect();
            $paginator = $this->messages->paginate($per_page = 25, $page = null, $page_name = 'imap_page');
        }catch (AuthFailedException $e){
            return view('admin.mail.error', [
                'error' => 'Failed to authenticate...'.$e->getMessage()
            ]);
        }catch (Exception $e) {
            return view('admin.mail.error', [
                'error' => 'Failed to connect and gathering data...'.$e->getMessage()
            ]);
        }
        return view('admin.mail.inbox', [
            'paginator' => $paginator
        ]);
    }

    public function show(int $UID)
    {
        return view('admin.mail.show', [
            'message' => $this->getItemById($UID)
        ]);
    }

    public function forward(int $UID)
    {
        // dd($this->getItemById(20)->getHTMLBody());


        $mail = Inbox::where('uid', $UID)->first();
        if($mail->state) return redirect('/admin/outgoing');

        $filter = Filter::first();

        $data["body"] = "";
        try{
            Mail::send('admin.mail.template', $data, function($message) use ($UID, $filter) {

                $mail = $this->getItemById($UID);

                $message->from(env("MAIL_FROM_ADDRESS",null));
                $message->to($filter->mailto);
                $message->subject('AutoCreated Email');


                $body = null;
                $html = null;
                if ($mail->HasHtmlBody())
                {
                    $body = $mail->getHTMLBody();
                }
                else
                {
                    $body = $mail->bodies["text"];
                }

                $html = $body;

                if ($filter->logo)
                {
                    $logo = "<img src='https://www.ultimateakash.com/assets/img/logo/logo.png' style='width: 100%; max-width: 88px' />";
                    if ($filter->profile)
                    {
                        $profile = "<img src='https://www.gravatar.com/avatar/b80ae1d65878cf68a4b1a00848467527' style='width: 50px; max-width: 50px' /> align='right'";
                        $logo =  $logo . $profile;
                    }
                    $html = $logo . $body;
                }

                if($filter->multipleJpgIntoPdf)
                {
                    $jpgData = "";
                    foreach ($mail->getAttachments() as $file) {
                        // dd($file);
                        if($file->getExtension() == 'jpg')
                        {
                            // dd($file);
                            $image = "data:image/jpg;base64,".base64_encode($file->getContent());
                            $jpgData .= "<img src='$image'>";
                        }
                    }
                    $dompdf = PDF::loadHTML($jpgData)->setOption(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape')->setWarnings(false);
                    $message->attachData($dompdf->output(), "MergedJpeg.pdf");
                }
                else
                {
                    foreach ($mail->getAttachments() as $file) {
                        $message->attachData($file->getContent(), $file->getName());
                    }
                }

                if(!$filter->allowEmptyContent && $body == null)
                {
                    echo ("Not Making PDF");
                }
                else if($filter->pdfFromBody)
                {
                    $dompdf = PDF::loadHTML($body)->setOption(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape')->setWarnings(false);
                    $message->attachData($dompdf->output(), "test.pdf");
                }
                Inbox::where('uid', $UID)
                    ->update(['state' => true]);
            }
        );
        }catch (Exception $e) {
            return view('admin.mail.error', [
                'error' => 'Failed to Sending Email...'.$e->getMessage()
            ]);
        }

        return redirect('/admin/outgoing');
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
            $this->folder = $this->client->getFolderByName('Inbox');
            if($this->folder == null)
                $this->folder = $this->client->getFolderByName('INBOX');
            if($this->folder == null) throw new ErrorException("Cannot Connect to Inbox");
            $this->messages = $this->folder->messages()->all()->get();

            foreach ($this->messages as $key => $_message) {

                $uid = $_message->getUid();
                $result = Inbox::where('uid', $uid)->get();
                if($result->count() == 0)
                Inbox::create(array(
                    'uid' => $uid,
                    'subject' => $_message->getSubject(),
                    'from_email' => $_message->getFrom()[0]->mail,
                    'state' => false
                ));
                $this->forward($uid);
            }
        }
    }
}
