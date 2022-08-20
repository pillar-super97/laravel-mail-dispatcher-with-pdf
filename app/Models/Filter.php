<?php

namespace App\Models;

use \DateTimeInterface;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'mailto',
        'pdfFromBody',
        'logo',
        'profile',
        'allowEmptyContent',
        'multipleJpgIntoPdf',
        'sizeLimit',
        'minSize',
        'maxSize',
        'sizeUnit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $table = "filters";

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
