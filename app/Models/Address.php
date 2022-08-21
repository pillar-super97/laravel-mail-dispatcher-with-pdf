<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'count',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $table = "addresses";
}
