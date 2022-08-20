<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use PDF;
use Mail;

use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;

use App\Models\Mail as Inbox;
use App\Models\Filter;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    protected $client;

    protected $folder;

    protected $messages;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all emails to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = Client::account('default');
        parent::__construct();
    }

    public function sendMail($_message)
    {
        // dd($this->getItemById(20)->getHTMLBody());


        $filter = Filter::first();

        $data["body"] = "";
        try{
            Mail::send('admin.mail.template', $data, function($message) use ($filter, $_message) {

                $message->from(env("MAIL_FROM_ADDRESS",null));
                $message->to($filter->mailto);
                $message->subject('AutoCreated Email');


                $body = null;
                $html = null;
                if ($_message->HasHtmlBody())
                {
                    $body = $_message->getHTMLBody();
                }
                else
                {
                    $body = $_message->bodies["text"];
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
                    foreach ($_message->getAttachments() as $file) {
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
                    foreach ($_message->getAttachments() as $file) {
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
                Inbox::where('uid', $_message->getUid())
                    ->update(['state' => true]);
            }
        );
        }catch (Exception $e) {
            // return view('admin.mail.error', [
            //     'error' => 'Failed to Sending Email...'.$e->getMessage()
            // ]);
        }

        // return redirect('/admin/outgoing');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function getMail()
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
                $this->sendMail($_message);
            }
        }
    }

    public function handle()
    {
        $this->getMail();
        return 0;
    }
}
