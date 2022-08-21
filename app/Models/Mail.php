<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    public $table = 'mail_boxes';

    protected $fillable = [
        'uid',
        'subject',
        'from_email',
        'to_email',
        'body',
        'from_attachments',
        'to_attachments',
        'state'
    ];
}
