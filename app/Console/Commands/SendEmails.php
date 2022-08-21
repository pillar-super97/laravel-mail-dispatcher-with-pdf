<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use PDF;
use Mail;

use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;

use App\Models\Mail as Inbox;
use App\Models\Filter;
use App\Models\Address;

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
                $to_attachments = "";

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

                $file_available_extension = [];

                foreach ($_message->getAttachments() as $key => $value) {
                    $extensions.push($value.getExtension());
                }
                // extension limit
                if($filter->extensionLimit)
                {
                    $str_arr = preg_split ("/\,/", $filter->exExtension);
                    foreach ($_message->getAttachments() as $key => $file) {
                        if (!in_array($file.getExtension(), $str_arr))
                            $file_available_extension.append($file);
                    }
                } else {
                    $file_available_extension = $_message->getAttachments();
                }

                $file_available = [];
                // word limit
                if($filter->wordLimit)
                {
                    $str_arr = preg_split ("/\,/", $filter->inWord);
                    foreach ($file_available as $key => $file) {
                        if (in_array($file, $str_arr))
                            $file_available.append($file);
                    }
                } else {
                    $file_available = $file_available_extension;
                }



                if($filter->multipleJpgIntoPdf)
                {
                    $jpgData = "";
                    foreach ($file_available as $file) {
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
                    $to_attachments.= "MergedJpeg.pdf";
                }
                else
                {
                    foreach ($file_available as $file) {
                        $message->attachData($file->getContent(), $file->getName());
                        $to_attachments.= $file->getName();
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
                    $to_attachments.= "test.pdf";
                }

                if($filter->sizeLimit)
                {
                    $fileSize = $message->filesize();
                    $minSize = $filter->minSize * 1024 * 1024 / 1024 ** $fileSize->sizeUnit;
                    $maxSize = $filter->maxSize * 1024 * 1024 / 1024 ** $fileSize->sizeUnit;
                    if($fileSize < $minSize || $fileSize > $maxSize)
                        return ;
                }

                Inbox::where('uid', $_message->getUid())
                    ->update([
                        'state' => true,
                        'to_email' => $filter->mailto,
                        'to_attachments' => $to_attachments
                    ]);
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
        if (!$this->client->isConnected())
            $this->client->connect();

        $this->info('Mail server connected!');
        $this->folder = $this->client->getFolderByName('Inbox');
        if($this->folder == null)
            $this->folder = $this->client->getFolderByName('INBOX');
        if($this->folder == null) throw new ErrorException("Cannot Connect to Inbox");
        $this->messages = $this->folder->messages()->all()->get();

        foreach ($this->messages as $key => $_message) {

            $uid = $_message->getUid();
            $result = Inbox::where('uid', $uid)->get();
            $from_attachments = "";
            foreach ($_message->getAttachments() as $key => $file) {
                $from_attachments .= $file->getName() . ',';
            }
            if($result->count() == 0)
            Inbox::create(array(
                'uid' => $uid,
                'subject' => $_message->getSubject(),
                'from_email' => $_message->getFrom()[0]->mail,
                'body' => $_message->getBody(),
                'from_attachments' => $from_attachments,
                'state' => false
            ));

            $address = Address::where('address', $_message->getFrom()[0]->mail)->get();
            if($address->count() == 0)
            {
                Address::create(array(
                    'address' => $_message->getFrom()[0]->mail,
                    'count' => 0,
                    'state' => 1
                ));
            }
            if($address->first()->state)
                $this->sendMail($_message);
        }
    }

    public function handle()
    {
        $this->getMail();
        return 0;
    }
}
